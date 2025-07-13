<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard con indicadores filtrados por varios criterios.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // --------------------------------------
        // Validación segura de filtros entrantes
        // --------------------------------------
        $validated = $request->validate([
            'year_from' => 'nullable|integer|min:1900|max:' . date('Y'),
            'year_to' => 'nullable|integer|min:1900|max:' . date('Y'),
            'sector' => 'nullable|in:privado,público,freelance',
            'gender' => 'nullable|in:M,F,Otro',
            'position' => 'nullable|string|max:100',
        ]);

        // Asignar variables con valores validados o null si no vienen
        $yearFrom = $validated['year_from'] ?? null;
        $yearTo = $validated['year_to'] ?? null;
        $sector = $validated['sector'] ?? null;
        $gender = $validated['gender'] ?? null;
        $position = $validated['position'] ?? null;

        // ------------------------------------------------------
        // Construcción de consulta base para egresados con filtros
        // ------------------------------------------------------
        $graduatesQuery = Graduate::query();

        if ($yearFrom) {
            $graduatesQuery->where('cohort_year', '>=', $yearFrom);
        }
        if ($yearTo) {
            $graduatesQuery->where('cohort_year', '<=', $yearTo);
        }
        if ($sector) {
            $graduatesQuery->where('sector', $sector);
        }
        if ($gender) {
            $graduatesQuery->where('gender', $gender);
        }
        if ($position) {
            // Escapar caracteres especiales para LIKE y buscar coincidencia parcial
            $graduatesQuery->where('position', 'like', '%' . addcslashes($position, '%_') . '%');
        }

        // --------------------------------------
        // Datos para el gráfico: empleabilidad por cohorte
        // --------------------------------------
        $cohortData = (clone $graduatesQuery)
            ->whereNotNull('cohort_year')
            ->select('cohort_year', DB::raw('COUNT(*) as total'))
            ->groupBy('cohort_year')
            ->orderBy('cohort_year')
            ->get();

        // --------------------------------------
        // Datos para gráfico: salario promedio por puesto (top 5)
        // --------------------------------------
        $salaryData = (clone $graduatesQuery)
            ->whereNotNull('salary')
            ->whereNotNull('position')
            ->select('position', DB::raw('AVG(salary) as average_salary'))
            ->groupBy('position')
            ->orderByDesc('average_salary')
            ->limit(5)
            ->get();

        // --------------------------------------
        // Distribución de egresados por sector laboral
        // --------------------------------------
        $sectorData = (clone $graduatesQuery)
            ->whereNotNull('sector')
            ->select('sector', DB::raw('COUNT(*) as total'))
            ->groupBy('sector')
            ->get();

        // --------------------------------------
        // Distribución de egresados por país
        // --------------------------------------
        $countryData = (clone $graduatesQuery)
            ->whereNotNull('country')
            ->select('country', DB::raw('COUNT(*) as total'))
            ->groupBy('country')
            ->orderByDesc('total')
            ->get();

        // --------------------------------------
        // Distribución por género
        // --------------------------------------
        $genderData = (clone $graduatesQuery)
            ->whereNotNull('gender')
            ->select('gender', DB::raw('COUNT(*) as total'))
            ->groupBy('gender')
            ->get();

        // --------------------------------------
        // Consulta para obtener habilidades más frecuentes (top 5)
        // Se hace join con tabla pivot graduate_skill y skills
        // --------------------------------------
        $skillQuery = DB::table('graduate_skill')
            ->join('skills', 'skills.id', '=', 'graduate_skill.skill_id')
            ->join('graduates', 'graduates.id', '=', 'graduate_skill.graduate_id');

        // Aplicar filtros a la consulta de habilidades según parámetros
        if ($yearFrom) {
            $skillQuery->where('graduates.cohort_year', '>=', $yearFrom);
        }
        if ($yearTo) {
            $skillQuery->where('graduates.cohort_year', '<=', $yearTo);
        }
        if ($sector) {
            $skillQuery->where('graduates.sector', $sector);
        }
        if ($gender) {
            $skillQuery->where('graduates.gender', $gender);
        }
        if ($position) {
            $skillQuery->where('graduates.position', 'like', '%' . addcslashes($position, '%_') . '%');
        }

        $skillData = $skillQuery
            ->select('skills.name', DB::raw('COUNT(*) as total'))
            ->groupBy('skills.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // --------------------------------------
        // Ciudades más comunes de empleo (top 5)
        // --------------------------------------
        $cityData = (clone $graduatesQuery)
            ->whereNotNull('city')
            ->select('city', DB::raw('COUNT(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // --------------------------------------
        // Contadores de egresados con portafolio y CV subido
        // --------------------------------------
        $withPortfolio = (clone $graduatesQuery)->whereNotNull('portfolio_url')->count();
        $withCV = (clone $graduatesQuery)->whereNotNull('cv_path')->count();

        // --------------------------------------
        // Participación en encuestas:
        // Calcula porcentaje de egresados que han respondido alguna encuesta
        // --------------------------------------
        $totalGraduates = (clone $graduatesQuery)->count();

        // Se usa Answer para contar usuarios distintos que respondieron
        $graduatesWithAnswers = Answer::distinct('user_id')->count('user_id');

        $surveyParticipationRate = $totalGraduates > 0
            ? round(($graduatesWithAnswers / $totalGraduates) * 100, 2)
            : 0;

        // --------------------------------------
        // Notificaciones no leídas para el usuario autenticado
        // --------------------------------------
        $unreadNotifications = auth()->user()->unreadNotifications;

        // --------------------------------------
        // Renderizar vista del dashboard con todos los datos preparados
        // --------------------------------------
        return view('admin.dashboard.index', compact(
            'cohortData',
            'salaryData',
            'sectorData',
            'countryData',
            'genderData',
            'skillData',
            'cityData',
            'withPortfolio',
            'withCV',
            'surveyParticipationRate',
            'unreadNotifications'
        ));
    }
}
