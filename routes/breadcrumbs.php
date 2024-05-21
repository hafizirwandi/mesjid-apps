<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.π

use App\Models\Role;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// User
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push('User', route('user'));
});

// Permission
Breadcrumbs::for('permission', function (BreadcrumbTrail $trail) {
    $trail->push('Permission', route('permission'));
});

// Role
Breadcrumbs::for('role', function (BreadcrumbTrail $trail) {
    $trail->push('Role', route('role'));
});
Breadcrumbs::for('role.detail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('role');
    $trail->push(ucwords(Role::find($id)['name']), route('role.detail', $id));
});


// // Home > Blog
// Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
//     $trail->parent('home');
//     $trail->push('Blog', route('blog'));
// });

// // Home > Blog > [Category]
// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category));
// });
