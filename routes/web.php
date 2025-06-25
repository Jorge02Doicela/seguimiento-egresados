<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraduateProfileController;
use App\Http\Controllers\GraduateSearchController;

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
Route::middleware(['auth', 'role:graduate'])->prefix('graduate')->name('graduate.')->group(function () {
    Route::get('/profile', [GraduateProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [GraduateProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [GraduateProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/skills/add', [GraduateProfileController::class, 'addSkill'])->name('profile.skills.add');
    Route::post('/profile/skills/remove', [GraduateProfileController::class, 'removeSkill'])->name('profile.skills.remove');

    Route::get('/home', function () {
        return view('graduate.home');
    })->name('home');

    Route::get('/surveys', function () {
        return view('graduate.surveys');
    })->name('surveys');
});



// Rutas exclusivas Empleadores
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/home', function () {
        return view('employer.home');
    })->name('home');

    // Usamos controlador para listar graduados
    Route::get('/graduates', [GraduateSearchController::class, 'index'])->name('graduates');
});

require __DIR__ . '/auth.php';
