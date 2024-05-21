<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    private $permissions = [
        'user-list',
        'user-edit',
        'user-delete',
        'user-create',
        'role-list',
        'role-edit',
        'role-delete',
        'role-create',
        'role-add-permission',
        'permission-list',
        'permission-edit',
        'permission-delete',
        'permission-create',
        'ganti-password',
        'pengaturan-sistem'

    ];

    public function up()
    {
        app()['cache']->forget('spatie.permission.cache');
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        //Super Admin Online
        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@cat.com',
            'status' => '1',
            'password' => Hash::make('admin')
        ]);
        $role = Role::create(['name' => 'admin']);

        foreach ($this->permissions as $r) {
            $role->givePermissionTo($r);
        }

        $user->assignRole([$role->id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::whereIn('name', $this->permissions)->delete();
        Role::whereIn('name', ['admin', 'operator'])->delete();
        User::whereIn('name', ['Admin', 'Operator'])->delete();
    }
};
