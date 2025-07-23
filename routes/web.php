<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    } else {
        return redirect('/login');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::resource('roles', RoleController::class);
    Route::post('/create-role', ['uses' => 'RoleController@createRole'])->name('create-role');
    Route::post('/create-permission', ['uses' => 'RoleController@createPermission'])->name('create-permission');
    Route::get('/role_permission', ['uses' => 'RoleController@role_permission'])->name('role_permission');
    Route::get('/role-delete/{id}', ['uses' => 'RoleController@role_delete'])->name('role-delete');
    Route::get('/permission-delete/{id}', ['uses' => 'RoleController@permission_delete'])->name('permission-delete');
    Route::get('/role-table', ['uses' => 'RoleController@roleTable'])->name('role-table');
    Route::get('/permission-table', ['uses' => 'RoleController@PermissionTable'])->name('permission-table');
    Route::get('/role-edit/{id}', ['uses' => 'RoleController@role_edit'])->name('role-edit');
    Route::get('/permission-edit/{id}', ['uses' => 'RoleController@permission_edit'])->name('permission-edit');
    Route::post('/role-update', ['uses' => 'RoleController@role_update'])->name('role-update');
    Route::post('/permission-update', ['uses' => 'RoleController@permission_update'])->name('permission-update');
});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::get('/admin', ['uses' => 'AdminController@index'])->name('admin_list');
    Route::post('/admin/store', ['uses' => 'AdminController@store'])->name('admin.store');
   


});
