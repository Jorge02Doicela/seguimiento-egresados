<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DashboardDataExport implements WithMultipleSheets
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        return [
            new \App\Exports\Sheets\CohortSheet($this->filters),
            new \App\Exports\Sheets\SectorSheet($this->filters),
            // Puedes añadir más hojas como SkillsSheet si deseas
        ];
    }
}
