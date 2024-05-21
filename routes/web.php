<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'loginFormAdmin'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return redirect('/login')->withErrors(['msg' => 'Please log in to continue your session']);
    }
});

Route::middleware('auth:web')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('can:user-list');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('can:user-create');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('can:user-edit');
    Route::post('/user', [UserController::class, 'saveOrUpdate'])->name('user.store')->middleware('can:user-create');
    Route::put('/user/{id}', [UserController::class, 'saveOrUpdate'])->name('user.update')->middleware('can:user-edit');
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy')->middleware('can:user-delete');

    Route::get('/permission', [PermissionController::class, 'index'])->name('permission')->middleware('can:permission-list');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('can:permission-create');
    Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('can:permission-edit');
    Route::post('/permission', [PermissionController::class, 'saveOrUpdate'])->name('permission.store')->middleware('can:permission-create');
    Route::put('/permission/{id}', [PermissionController::class, 'saveOrUpdate'])->name('permission.update')->middleware('can:permission-edit');
    Route::delete('/permission/delete', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('can:permission-delete');

    Route::get('/role', [RoleController::class, 'index'])->name('role')->middleware('can:role-list');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create')->middleware('can:role-create');
    Route::get('/role/detail/{id}', [RoleController::class, 'detail'])->name('role.detail')->middleware('can:role-add-permission');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('can:role-edit');
    Route::post('/role', [RoleController::class, 'saveOrUpdate'])->name('role.store')->middleware('can:role-create');
    Route::post('/role/savePermission', [RoleController::class, 'savePermission'])->name('role.savePermission')->middleware('can:role-add-permission');
    Route::put('/role/{id}', [RoleController::class, 'saveOrUpdate'])->name('role.update')->middleware('can:role-edit');
    Route::delete('/role/delete', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('can:role-delete');


    Route::get('/ganti-password', [AuthController::class, 'gantiPassword'])->name('ganti-password')->middleware('can:ganti-password');
    Route::post('/ganti-password', [AuthController::class, 'saveGantiPassword'])->name('ganti-password.save')->middleware('can:ganti-password');
});
