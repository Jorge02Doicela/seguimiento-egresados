<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DashboardDataExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class DashboardExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $filters = $request->only(['year_from', 'year_to', 'sector', 'gender', 'position']);
        return Excel::download(new DashboardDataExport($filters), 'dashboard-egresados.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $filters = $request->only(['year_from', 'year_to', 'sector', 'gender', 'position']);
        // Puedes reutilizar la lógica de DashboardDataExport o moverla a un servicio
        $data = (new DashboardDataExport($filters))->view()->getData();
        $pdf = PDF::loadView('admin.exports.dashboard_pdf', $data);
        return $pdf->download('dashboard-egresados.pdf');
    }
}
