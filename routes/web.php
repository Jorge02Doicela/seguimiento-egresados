<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta dashboard solo para usuarios autenticados y verificados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para usuarios autenticados
Route::middleware('auth')->group(function () {
    // Perfil accesible para cualquier usuario autenticado
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas exclusivas para Admin (por ejemplo panel de control)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Aquí crearás esta vista luego
    })->name('admin.dashboard');

    // Aquí puedes agregar más rutas exclusivas para admin
});

// Rutas exclusivas para Egresados
Route::middleware(['auth', 'role:graduate'])->group(function () {
    Route::get('/graduate/home', function () {
        return view('graduate.home'); // También crear esta vista
    })->name('graduate.home');

    // Más rutas para egresados
});

// Rutas exclusivas para Empleadores
Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('/employer/home', function () {
        return view('employer.home'); // Vista para empleadores
    })->name('employer.home');
});

require __DIR__ . '/auth.php';
