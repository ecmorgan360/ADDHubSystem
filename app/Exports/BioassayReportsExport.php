<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Repositories\ReportRepository;

class BioassayReportsExport implements FromArray,WithHeadings
{
    protected $bioassays;

    public function __construct(array $bioassays)
    {
        $this->bioassays = $bioassays;
    }

    public function array(): array
    {
        return $this->bioassays;
    }

    public function headings(): array
    {
        return [
            'Bioassay ID',
            'Created At',
            'Updated At',
            'Responsible PI',
            'Researcher',
            'Date Received',
            'Molecular ID',
            'Diluent',
            'Concentration',
            'Amount',
            'E. coli Viability',
            'E. coli Standard Deviation',
            'S. aureus Viability',
            'S. aureus Standard Deviation',
            'P. areuginosa Viability',
            'p. areuginosa Standard Deviation',
            'S. aureus Biofilm Viability',
            'S. aureus Biofilm Standard Deviation',
            'P. areuginosa Biofilm Viability',
            'p. areuginosa Biofilm Standard Deviation',
            'Cytotox Viability',
            'Cytotox Standard Deviation',
            'PK Activity',
            'DXR Activity',
            'Confirm DXR Activity',
            'HPPK Activity',
            'Cancelled',
            'PK Requested',
        ];
    }
}
