<?php

declare(strict_types=1);

use App\App\Admin\Controllers\DepartmentsController;
use App\App\Admin\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [HomeController::class, 'users']);

Route::prefix('departments')->group(function () {
    Route::get('/',[DepartmentsController::class,'index']);
    Route::get('/create',[DepartmentsController::class,'create'])->name('departments.create');
    Route::post('/',[DepartmentsController::class,'store'])->name('departments.store');
});
