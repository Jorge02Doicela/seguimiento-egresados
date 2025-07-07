<?php

namespace App\Exports;

use App\Models\Graduate;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DashboardDataExport implements FromView
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $graduatesQuery = Graduate::query();

        if (isset($this->filters['year_from'])) {
            $graduatesQuery->where('cohort_year', '>=', $this->filters['year_from']);
        }
        if (isset($this->filters['year_to'])) {
            $graduatesQuery->where('cohort_year', '<=', $this->filters['year_to']);
        }

        // Aplica los demás filtros como en tu DashboardController...

        // Aquí puedes preparar todos los datos que usas en el dashboard
        $cohortData = (clone $graduatesQuery)
            ->select('cohort_year', \DB::raw('COUNT(*) as total'))
            ->groupBy('cohort_year')
            ->get();

        // Retorna una vista con los datos
        return view('admin.exports.dashboard_excel', [
            'cohortData' => $cohortData,
            // pasa también sectorData, skillData, etc.
        ]);
    }
}
