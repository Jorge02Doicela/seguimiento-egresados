<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard general para usuarios autenticados y verificados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas perfil común (usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas exclusivas Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/surveys', function () {
        return view('admin.surveys');
    })->name('admin.surveys');

    Route::get('/admin/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
});

// Rutas exclusivas Egresados (graduate)
Route::middleware(['auth', 'role:graduate'])->group(function () {
    Route::get('/graduate/home', function () {
        return view('graduate.home');
    })->name('graduate.home');

    Route::get('/graduate/surveys', function () {
        return view('graduate.surveys');
    })->name('graduate.surveys');
});

// Rutas exclusivas Empleadores
Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('/employer/home', function () {
        return view('employer.home');
    })->name('employer.home');

    Route::get('/employer/graduates', function () {
        return view('employer.graduates');
    })->name('employer.graduates');
});

require __DIR__ . '/auth.php';
