<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Repositories\ReportRepository;

class OrphanFractionsExport implements FromArray,WithHeadings
{
    protected $fractions;

    public function __construct(array $fractions)
    {
        $this->fractions = $fractions;
    }

    public function array(): array
    {
        return $this->fractions;
    }

    public function headings(): array
    {
        return [
            'Fraction ID',
            'Created At',
            'Updated At',
            'Date Sample Submitted',
            'Amount Available',
            'Sample Type',
            'Concentration',
            'Project',
            'Source ID',
            'Research Group ID',
            'Submitter ID',
            'Solvent Used',
            'Comments',
        ];
    }
}
