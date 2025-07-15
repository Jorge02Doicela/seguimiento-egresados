<?php

namespace App\Exports\Sheets;

use App\Models\Graduate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CohortSheet implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Graduate::query();

        if (!empty($this->filters['year_from'])) {
            $query->where('cohort_year', '>=', $this->filters['year_from']);
        }

        if (!empty($this->filters['year_to'])) {
            $query->where('cohort_year', '<=', $this->filters['year_to']);
        }

        return $query
            ->select('cohort_year', \DB::raw('COUNT(*) as total'))
            ->groupBy('cohort_year')
            ->orderBy('cohort_year')
            ->get();
    }



    public function headings(): array
    {
        return ['Cohorte', 'Total de Egresados'];
    }

    public function map($row): array
    {
        return [
            $row->cohort_year,
            $row->total,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
