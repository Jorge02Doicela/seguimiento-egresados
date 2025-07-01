<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Graduate;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos actuales
        $cohortData = Graduate::select('cohort_year', DB::raw('count(*) as total'))
            ->groupBy('cohort_year')
            ->orderBy('cohort_year')
            ->get();

        $salaryData = Graduate::select('position', DB::raw('AVG(salary) as average_salary'))
            ->groupBy('position')
            ->orderByDesc('average_salary')
            ->limit(5)
            ->get();

        $sectorData = Graduate::select('sector', DB::raw('count(*) as total'))
            ->groupBy('sector')
            ->get();

        // Notificaciones no leídas del usuario actual
        $user = auth()->user();
        $unreadNotifications = $user->unreadNotifications;

        // Enviar todo a la vista
        return view('admin.dashboard.index', compact('cohortData', 'salaryData', 'sectorData', 'unreadNotifications'));
    }
}
