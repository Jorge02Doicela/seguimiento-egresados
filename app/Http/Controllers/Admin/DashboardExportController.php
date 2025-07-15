<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\DashboardDataExport;
use Illuminate\Http\Request;
use App\Models\Graduate;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class DashboardExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $filters = [
            'year_from' => $request->input('year_from'),
            'year_to' => $request->input('year_to'),
            'sector' => $request->input('sector'),
            'gender' => $request->input('gender'),
            'position' => $request->input('position'),
        ];
        return Excel::download(new DashboardDataExport($filters), 'dashboard-egresados.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $filters = [
            'year_from' => $request->input('year_from'),
            'year_to' => $request->input('year_to'),
            'sector' => $request->input('sector'),
            'gender' => $request->input('gender'),
            'position' => $request->input('position'),
        ];

        $cohortData = Graduate::query()
            ->when($filters['year_from'], fn($q) => $q->where('cohort_year', '>=', $filters['year_from']))
            ->when($filters['year_to'], fn($q) => $q->where('cohort_year', '<=', $filters['year_to']))
            ->select('cohort_year', \DB::raw('COUNT(*) as total'))
            ->groupBy('cohort_year')
            ->get();

        $sectorData = Graduate::query()
            ->when($filters['sector'], fn($q) => $q->where('sector', $filters['sector']))
            ->select('sector', \DB::raw('COUNT(*) as total'))
            ->groupBy('sector')
            ->get();

        $pdf = PDF::loadView('admin.exports.dashboard_pdf', [
            'cohortData' => $cohortData,
            'sectorData' => $sectorData,
            'filters' => $filters,
        ]);

        return $pdf->download('dashboard-egresados.pdf');
    }
}
