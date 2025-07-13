<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DashboardDataExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class DashboardExportController extends Controller
{
    /**
     * Exportar datos del dashboard a archivo Excel (.xlsx)
     *
     * @param  Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(Request $request)
    {
        // Obtener solo los filtros permitidos del request
        $filters = $request->only(['year_from', 'year_to', 'sector', 'gender', 'position']);

        // Ejecutar la exportación usando la clase DashboardDataExport
        // y forzar la descarga del archivo Excel con nombre personalizado
        return Excel::download(
            new DashboardDataExport($filters),
            'dashboard-egresados.xlsx'
        );
    }

    /**
     * Exportar datos del dashboard a archivo PDF
     *
     * @param  Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exportPDF(Request $request)
    {
        // Obtener filtros del request
        $filters = $request->only(['year_from', 'year_to', 'sector', 'gender', 'position']);

        // Obtener los datos para exportar reutilizando la clase DashboardDataExport
        // Se llama al método view() para obtener la vista y luego getData() para los datos
        $data = (new DashboardDataExport($filters))->view()->getData();

        // Generar el PDF usando la vista específica para exportación
        $pdf = PDF::loadView('admin.exports.dashboard_pdf', $data);

        // Retornar la descarga del PDF con nombre personalizado
        return $pdf->download('dashboard-egresados.pdf');
    }
}
