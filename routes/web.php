<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
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
    Route::get('/role-list', ['uses' => 'RoleController@roleList'])->name('role.list');
    Route::get('/permission-list', ['uses' => 'RoleController@permissionList'])->name('permission.list');
});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::get('/admin', ['uses' => 'AdminController@index'])->name('admin.index');
    Route::post('/admin/store', ['uses' => 'AdminController@store'])->name('admin.store');
    Route::get('/admin_edit/{id}', ['uses' => 'AdminController@admin_edit'])->name('admin_edit');
    Route::post('/admin_update', ['uses' => 'AdminController@admin_update'])->name('admin_update');
    Route::get('/admin_delete/{id}', ['uses' => 'AdminController@admin_delete'])->name('admin_delete');
    Route::get('/evaluation/teacher', ['uses' => 'AdminController@evaluation_teacher'])->name('evaluation.teacher');
    Route::post('/evaluation/teacher', ['uses' => 'AdminController@evaluation_teacher_store'])->name('evaluation.teacher.store');


    Route::get('/evaluation/student', ['uses' => 'AdminController@evaluation_student'])->name('evaluation.student');
    Route::post('/evaluation/student/course', ['uses' => 'AdminController@evaluation_student_course'])->name('evaluation.student.course');
    Route::post('/evaluation/student', ['uses' => 'AdminController@evaluation_student_store'])->name('evaluation.student.store');
});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::resource('questions', QuestionController::class);
});
Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::get('/courses_upload', ['uses' => 'CourseUploadController@index'])->name('courses.upload');
    Route::post('/courses/import', ['uses' => 'CourseUploadController@importCourseData'])->name('courses.import');
    Route::get('/departments', ['uses' => 'CourseUploadController@departmentIndex'])->name('departments.index');
    Route::post('/departments_store', ['uses' => 'CourseUploadController@departmentStore'])->name('departments.store');
    Route::get('/departments/{id}', ['uses' => 'CourseUploadController@departmentShow'])->name('departments.show');
    Route::post('/departments_update', ['uses' => 'CourseUploadController@departmentUpdate'])->name('departments.update');
    Route::get('/departments_delete/{id}', ['uses' => 'CourseUploadController@departmentDelete'])->name('departments.delete');
    
});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::get('/departments', ['uses' => 'PortalController@departmentIndex'])->name('departments.index');
    Route::post('/departments_store', ['uses' => 'PortalController@departmentStore'])->name('departments.store');
    Route::get('/departments/{id}', ['uses' => 'PortalController@departmentShow'])->name('departments.show');
    Route::post('/departments_update', ['uses' => 'PortalController@departmentUpdate'])->name('departments.update');
    Route::get('/departments_delete/{id}', ['uses' => 'PortalController@departmentDelete'])->name('departments.delete');

    Route::get('/batches', ['uses' => 'PortalController@batchIndex'])->name('batches.index');
    Route::post('/batches_store', ['uses' => 'PortalController@batchStore'])->name('batches.store');
    Route::get('/batches/{id}', ['uses' => 'PortalController@batchShow'])->name('batches.show');
    Route::post('/batches_update', ['uses' => 'PortalController@batchUpdate'])->name('batches.update');
    Route::get('/batches_delete/{id}', ['uses' => 'PortalController@batchDelete'])->name('batches.delete');

    Route::get('/courses', ['uses' => 'PortalController@courseIndex'])->name('courses.index');
    Route::post('/courses_store', ['uses' => 'PortalController@courseStore'])->name('courses.store');
    Route::get('/courses/{id}', ['uses' => 'PortalController@courseShow'])->name('courses.show');
    Route::post('/courses_update', ['uses' => 'PortalController@courseUpdate'])->name('courses.update');
    Route::get('/courses_delete/{id}', ['uses' => 'PortalController@courseDelete'])->name('courses.delete');

    

});
