<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Survey;

class CheckSurveyAccess
{
    public function handle(Request $request, Closure $next)
    {
        $survey = $request->route('survey');

        if (!$survey->is_active) {
            return redirect()->route('graduate.surveys.index')->with('error', 'La encuesta no está activa.');
        }

        if ($survey->start_date && now()->lt($survey->start_date)) {
            return redirect()->route('graduate.surveys.index')->with('error', 'La encuesta aún no ha comenzado.');
        }

        if ($survey->end_date && now()->gt($survey->end_date)) {
            return redirect()->route('graduate.surveys.index')->with('error', 'La encuesta ya ha finalizado.');
        }

        return $next($request);
    }
}
