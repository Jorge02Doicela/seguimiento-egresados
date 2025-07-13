<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Añade tu middleware CheckIfBlocked al grupo 'web'
        $middleware->web(append: [
            \App\Http\Middleware\CheckIfBlocked::class,
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'check.survey.access' => \App\Http\Middleware\CheckSurveyAccess::class,
            'verified.employer' => \App\Http\Middleware\EnsureEmployerIsVerified::class,
            // Si necesitas aliases adicionales para Spatie o cualquier otro middleware, van aquí
            // 'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            // 'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
