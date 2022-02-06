<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GlobalChecklistController;
use App\Http\Controllers\GlobalPointController;
use App\Http\Controllers\CompanyUsersController;
use App\Http\Controllers\UserChecklistController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompanyChecklistController;
use App\Http\Controllers\MyChecklistController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::name('register.')->prefix('register')->group(function () {
    Route::get('{key}', [RegisterController::class, 'showRegistrationForm'])
        ->name('showRegistrationForm');
    Route::get('', [RegisterController::class, 'showRegistrationForm'])
        ->name('showRegistrationForm');
    Route::post('{key}', [RegisterController::class, 'register'])
        ->name('register');
        });

Route::middleware(['auth'])->group(function () {

    Route::name('changePassword.')->prefix('changePassword')->group(function () {
        Route::get('', [UserController::class, 'index'])
            ->name('index');
        Route::post('', [UserController::class, 'update'])
            ->name('update');
    });

    Route::name('users.')->prefix('users')->group(function () {
        Route::get('', [UserController::class, 'allUsers'])
            ->name('allUsers')
            ->where('id', '[0-9]+')
            ->middleware(['permission:users']);
        Route::get('{id}/addAdmin', [UserController::class, 'addAdmin'])
            ->name('addAdmin')
            ->where('id', '[0-9]+')
            ->middleware(['permission:users']);
        Route::delete('{id}', [UserController::class, 'destroy'])
            ->name('destroy')
            ->where('id', '[0-9]+')
            ->middleware(['permission:users']);
        Route::get('{id}/restore', [UserController::class, 'restore'])
            ->name('restore')
            ->where('id', '[0-9]+')
            ->middleware(['permission:users']);
        Route::get('add', [UserController::class, 'add'])
            ->name('add')
            ->middleware(['permission:users']);
        Route::get('{id}', [UserController::class, 'show'])
            ->name('show')
            ->where('id', '[0-9]+')
            ->middleware(['permission:users']);
    });

    Route::name('companies.')->prefix('companies')->group(function () {
        Route::get('', [CompanyController::class, 'index'])
            ->name('index')
            ->middleware(['permission:companies']);
        Route::get('create', [CompanyController::class, 'create'])
            ->name('create')
            ->middleware(['permission:companies']);
        Route::post('', [CompanyController::class, 'store'])
            ->name('store')
            ->middleware(['permission:companies']);
        Route::get('{id}', [CompanyController::class, 'show'])
            ->name('show')
            ->where('id', '[0-9]+')
            ->middleware(['permission:companies']);
        Route::get('{id}/edit', [CompanyController::class, 'edit'])
            ->name('edit')
            ->where('id', '[0-9]+')
            ->middleware(['permission:companies']);
        Route::patch('{id}', [CompanyController::class, 'update'])
            ->name('update')
            ->where('id', '[0-9]+')
            ->middleware(['permission:companies']);
        Route::delete('{id}', [CompanyController::class, 'destroy'])
            ->name('destroy')
            ->where('id', '[0-9]+')
            ->middleware(['permission:companies']);
        Route::get('{id}/restore', [CompanyController::class, 'restore'])
            ->name('restore')
            ->where('id', '[0-9]+')
            ->middleware(['permission:companies']);
    });

    Route::name('company.')->prefix('company')->group(function () {
        Route::get('editCompany', [CompanyController::class, 'editCompany'])
            ->name('editCompany')
            ->middleware(['permission:company']);
        Route::patch('', [CompanyController::class, 'updateCompany'])
            ->name('updateCompany')
            ->middleware(['permission:company']);
    });

    Route::name('categories.')->prefix('categories')->group(function () {
        Route::get('', [CategoryController::class, 'index'])
            ->name('index')
            ->middleware(['permission:category']);
        Route::get('create', [CategoryController::class, 'create'])
            ->name('create')
            ->middleware(['permission:category']);
        Route::post('', [CategoryController::class, 'store'])
            ->name('store')
            ->middleware(['permission:category']);
        Route::get('{id}', [CategoryController::class, 'show'])
            ->name('show')
            ->where('id', '[0-9]+')
            ->middleware(['permission:category']);
        Route::get('{id}/edit', [CategoryController::class, 'edit'])
            ->name('edit')
            ->where('id', '[0-9]+')
            ->middleware(['permission:category']);
        Route::patch('{id}', [CategoryController::class, 'update'])
            ->name('update')
            ->where('id', '[0-9]+')
            ->middleware(['permission:category']);
        Route::get('{id}/delete', [CategoryController::class, 'destroy'])
            ->name('destroy')
            ->where('id', '[0-9]+')
            ->middleware(['permission:category']);
        Route::get('{id}/restore', [CategoryController::class, 'restore'])
            ->name('restore')
            ->where('id', '[0-9]+')
            ->middleware(['permission:category']);
    });

    Route::name('globalChecklists.')->prefix('globalChecklists')->group(function () {
        Route::get('', [GlobalChecklistController::class, 'index'])
            ->name('index')
            ->middleware(['permission:manage_global_checklists']);
        Route::post('{id}/copy', [GlobalChecklistController::class, 'copy'])
            ->name('copy')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('create', [GlobalChecklistController::class, 'create'])
            ->name('create')
            ->middleware(['permission:manage_global_checklists']);
        Route::post('', [GlobalChecklistController::class, 'store'])
            ->name('store')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{id}', [GlobalChecklistController::class, 'show'])
            ->name('show')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{id}/edit', [GlobalChecklistController::class, 'edit'])
            ->name('edit')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::patch('{id}', [GlobalChecklistController::class, 'update'])
            ->name('update')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::delete('{id}', [GlobalChecklistController::class, 'destroy'])
            ->name('destroy')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{id}/restore', [GlobalChecklistController::class, 'restore'])
            ->name('restore')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
    });

    Route::name('globalpoints.')->prefix('globalpoints')->group(function () {
        Route::get('{checklistId}/list', [GlobalPointController::class, 'index'])
            ->name('index')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{checklistId}/create', [GlobalPointController::class, 'create'])
            ->name('create')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{index}/{checklistId}/createuper', [GlobalPointController::class, 'createuper'])
            ->name('createuper')
            ->where('index', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{index}/{checklistId}/createsubsection', [GlobalPointController::class, 'createsubsection'])
            ->name('createsubsection')
            ->where('index', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{id}/{checklistId}/moveup', [GlobalPointController::class, 'moveup'])
            ->name('moveup')
            ->where('id', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{id}/{checklistId}/movedown', [GlobalPointController::class, 'movedown'])
            ->name('movedown')
            ->where('id', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::post('{checklistId}', [GlobalPointController::class, 'store'])
            ->name('store')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::post('{index}/{checklistId}', [GlobalPointController::class, 'storeuper'])
            ->name('storeuper')
            ->where('index', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::post('{index}/{checklistId}/storesubsection', [GlobalPointController::class, 'storesubsection'])
            ->name('storesubsection')
            ->where('index', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{id}', [GlobalPointController::class, 'show'])
            ->name('show')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::get('{id}/{checklistId}/edit', [GlobalPointController::class, 'edit'])
            ->name('edit')
            ->where('id', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::patch('{id}', [GlobalPointController::class, 'update'])
            ->name('update')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
        Route::delete('{id}', [GlobalPointController::class, 'destroy'])
            ->name('destroy')
            ->where('id', '[0-9]+')
            ->middleware(['permission:manage_global_checklists']);
    });

    Route::name('companyUsers.')->prefix('companyUsers')->group(function () {
        Route::get('', [CompanyUsersController::class, 'index'])
            ->name('index')
            ->middleware(['permission:global_checklists']);
        Route::get('admin', [CompanyUsersController::class, 'admin'])
            ->name('admin')
            ->middleware(['permission:company_users']);
        Route::get('add', [CompanyUsersController::class, 'add'])
            ->name('add')
            ->where('userId', '[0-9]+')
            ->middleware(['permission:company_users']);
        Route::get('{id}', [CompanyUsersController::class, 'show'])
            ->name('show')
            ->where('id', '[0-9]+')
            ->middleware(['permission:company_users']);
        Route::get('{id}/edit', [CompanyUsersController::class, 'edit'])
            ->name('edit')
            ->where('id', '[0-9]+')
            ->middleware(['permission:company_users']);
        Route::patch('{id}', [CompanyUsersController::class, 'update'])
            ->name('update')
            ->where('id', '[0-9]+')
            ->middleware(['permission:company_users']);
        Route::delete('{id}', [CompanyUsersController::class, 'destroy'])
            ->name('destroy')
            ->where('id', '[0-9]+')
            ->middleware(['permission:company_users']);
        Route::get('{id}/restore', [CompanyUsersController::class, 'restore'])
            ->name('restore')
            ->where('id', '[0-9]+')
            ->middleware(['permission:company_users']);
    });

    Route::name('userchecklists.')->prefix('userchecklists')->group(function () {
        Route::get('{userId}/list', [UserChecklistController::class, 'index'])
            ->name('index')
            ->where('userId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::post('{userId}/add', [UserChecklistController::class, 'add'])
            ->name('add')
            ->where('userId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::get('{listId}/edit', [UserChecklistController::class, 'edit'])
            ->name('edit')
            ->where('listId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::post('{listId}', [UserChecklistController::class, 'save'])
            ->name('save')
            ->where('listId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::delete('{id}/{userId}', [UserChecklistController::class, 'destroy'])
            ->name('destroy')
            ->where('id', '[0-9]+')
            ->where('userId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::get('{checklistId}/createPDF', [UserChecklistController::class, 'createPDF'])
            ->name('createPDF')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::get('{id}/download', [UserChecklistController::class, 'download'])
            ->name('download')
            ->where('id', '[0-9]+')
            ->middleware(['permission:global_checklists']);
    });

    Route::name('companyChecklists.')->prefix('companyChecklists')->group(function () {
        Route::get('', [CompanyChecklistController::class, 'index'])
            ->name('index')
            ->middleware(['permission:global_checklists']);
        Route::get('{listId}/users', [CompanyChecklistController::class, 'users'])
            ->name('users')
            ->where('listId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::get('{listId}/status', [CompanyChecklistController::class, 'status'])
            ->name('status')
            ->where('listId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::post('{listId}/filtr', [CompanyChecklistController::class, 'filtr'])
            ->name('filtr')
            ->where('listId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::get('{userId}/{listId}/{term}/assign', [CompanyChecklistController::class, 'assign'])
            ->name('assign')
            ->where('userId', '[0-9]+')
            ->where('listId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::delete('{id}', [CompanyChecklistController::class, 'destroy'])
            ->name('destroy')
            ->where('id', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::get('{listId}/edit', [CompanyChecklistController::class, 'edit'])
            ->name('edit')
            ->where('listId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
        Route::post('{listId}', [CompanyChecklistController::class, 'save'])
            ->name('save')
            ->where('listId', '[0-9]+')
            ->middleware(['permission:global_checklists']);
    });

    Route::name('mychecklists.')->prefix('mychecklists')->group(function () {
        Route::get('', [MyChecklistController::class, 'index'])
            ->name('index')
            ->middleware(['permission:user_checklist']);
        Route::get('{checklistId}/realization', [MyChecklistController::class, 'realization'])
            ->name('realization')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:user_checklist']);
        Route::get('{pointId}/{checklistId}/realize', [MyChecklistController::class, 'realize'])
            ->name('realize')
            ->where('pointId', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:user_checklist']);
        Route::get('{pointId}/{checklistId}/undo', [MyChecklistController::class, 'undo'])
            ->name('undo')
            ->where('pointId', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:user_checklist']);
        Route::get('{pointId}/{checklistId}/skip', [MyChecklistController::class, 'skip'])
            ->name('skip')
            ->where('pointId', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:user_checklist']);
        Route::get('{pointId}/{checklistId}/realizeskiped', [MyChecklistController::class, 'realizeskiped'])
            ->name('realizeskiped')
            ->where('pointId', '[0-9]+')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:user_checklist']);
        Route::get('{checklistId}/complete', [MyChecklistController::class, 'complete'])
            ->name('complete')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:user_checklist']);
        Route::post('{checklistId}', [MyChecklistController::class, 'close'])
            ->name('close')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:user_checklist']);
        Route::get('{checklistId}/createPDF', [MyChecklistController::class, 'createPDF'])
            ->name('createPDF')
            ->where('checklistId', '[0-9]+')
            ->middleware(['permission:user_checklist']);
        Route::get('{id}/download', [MyChecklistController::class, 'download'])
            ->name('download')
            ->where('id', '[0-9]+')
            ->middleware(['permission:user_checklist']);
    });

    Route::name('calendar.')->prefix('calendar')->group(function () {
        Route::get('', [CalendarController::class, 'index'])
            ->name('index')
            ->middleware(['permission:user_checklist']);
        Route::get('{id}/getChecklists', [CalendarController::class, 'getChecklists'])
            ->name('getChecklists')
            ->where('id', '[0-9]+')
            ->middleware(['permission:user_checklist']);
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
