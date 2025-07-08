<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraduateProfileController;
use App\Http\Controllers\GraduateSearchController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Graduate\SurveyResponseController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardExportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SurveyDashboardController;
use App\Http\Controllers\Admin\ReportController;

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

// Rutas exclusivas Admin con CRUD completo para encuestas y dashboards
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard principal admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reportes generales
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/excel', [ReportController::class, 'excel'])->name('reports.excel');
    Route::get('/reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');

    // Dashboard y exportaciones para encuestas
    Route::get('surveys/dashboard', [SurveyDashboardController::class, 'index'])->name('surveys.dashboard');
    Route::get('surveys/dashboard/charts', [SurveyDashboardController::class, 'charts'])->name('surveys.dashboard.charts');
    Route::get('surveys/export/excel', [SurveyDashboardController::class, 'exportExcel'])->name('surveys.export.excel');
    Route::get('surveys/export/pdf', [SurveyDashboardController::class, 'exportPDF'])->name('surveys.export.pdf');

    // Operación especial: clonar encuesta
    Route::get('surveys/{survey}/clone', [SurveyController::class, 'clone'])->name('surveys.clone');

    // CRUD completo encuestas
    Route::resource('surveys', SurveyController::class);
});

// Rutas exclusivas Egresados (graduate)
Route::middleware(['auth', 'role:graduate'])->prefix('graduate')->name('graduate.')->group(function () {
    // Perfil egresado
    Route::get('/profile', [GraduateProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [GraduateProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [GraduateProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/skills/add', [GraduateProfileController::class, 'addSkill'])->name('profile.skills.add');
    Route::post('/profile/skills/remove', [GraduateProfileController::class, 'removeSkill'])->name('profile.skills.remove');

    // Home egresado
    Route::get('/home', function () {
        return view('graduate.home');
    })->name('home');

    // Encuestas para responder
    Route::get('/surveys', [SurveyResponseController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/{survey}', [SurveyResponseController::class, 'show'])->middleware('check.survey.access')->name('surveys.show');
    Route::post('/surveys/{survey}/answers', [SurveyResponseController::class, 'store'])->middleware('check.survey.access')->name('surveys.answers.store');
});

// Rutas exclusivas Empleadores
Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/home', function () {
        return view('employer.home');
    })->name('home');

    // Controlador para listar egresados
    Route::get('/graduates', [GraduateSearchController::class, 'index'])->name('graduates');
});

// Rutas para mensajes y notificaciones (usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    // Mensajes
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
    Route::post('messages/{id}/read', [MessageController::class, 'markAsRead'])->name('messages.read');

    // Notificaciones
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

// Rutas para exportar datos del dashboard general admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard/export/excel', [DashboardExportController::class, 'exportExcel'])->name('admin.dashboard.export.excel');
    Route::get('/dashboard/export/pdf', [DashboardExportController::class, 'exportPDF'])->name('admin.dashboard.export.pdf');
});

require __DIR__ . '/auth.php';
