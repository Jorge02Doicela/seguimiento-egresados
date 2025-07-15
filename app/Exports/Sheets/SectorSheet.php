<?php

namespace App\Exports\Sheets;

use App\Models\Graduate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SectorSheet implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Graduate::query();

        if ($this->filters['sector']) {
            $query->where('sector', $this->filters['sector']);
        }

        return $query
            ->select('sector', DB::raw('COUNT(*) as total'))
            ->groupBy('sector')
            ->get();
    }

    public function headings(): array
    {
        return ['Sector', 'Total de Egresados'];
    }

    public function map($row): array
    {
        return [
            $row->sector ?? 'No especificado',
            $row->total,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
