<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraduateProfileController;
use App\Http\Controllers\GraduateSearchController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Graduate\SurveyResponseController;

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

// Rutas exclusivas Admin con CRUD completo para encuestas
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('surveys', SurveyController::class);
    Route::resource('surveys', \App\Http\Controllers\Admin\SurveyController::class);
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Controlador Resource para CRUD encuestas y preguntas
    Route::resource('surveys', SurveyController::class);

    // Puedes agregar aquí otras rutas admin si necesitas
    Route::get('/reports', function () {
        return view('admin.reports');
    })->name('reports');
});

// Rutas exclusivas Egresados (graduate)
Route::middleware(['auth', 'role:graduate'])->prefix('graduate')->name('graduate.')->group(function () {
    // Perfil egresado
    Route::get('/profile', [GraduateProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [GraduateProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [GraduateProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/skills/add', [GraduateProfileController::class, 'addSkill'])->name('profile.skills.add');
    Route::post('/profile/skills/remove', [GraduateProfileController::class, 'removeSkill'])->name('profile.skills.remove');

    Route::get('/home', function () {
        return view('graduate.home');
    })->name('home');

    // Encuestas para responder (lista, ver formulario, enviar respuestas)
    Route::get('/surveys', [SurveyResponseController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/{survey}', [SurveyResponseController::class, 'show'])->name('surveys.show');
    Route::post('/surveys/{survey}/answers', [SurveyResponseController::class, 'store'])->name('surveys.answers.store');
});

// Rutas exclusivas Empleadores
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/home', function () {
        return view('employer.home');
    })->name('home');

    // Controlador para listar egresados
    Route::get('/graduates', [GraduateSearchController::class, 'index'])->name('graduates');
});

require __DIR__ . '/auth.php';
