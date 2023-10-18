<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Repositories\ReportRepository;

class OrphanCompoundsExport implements FromArray,WithHeadings
{
    protected $purecomps;

    public function __construct(array $purecomps)
    {
        $this->purecomps = $purecomps;
    }

    public function array(): array
    {
        return $this->purecomps;
    }

    public function headings(): array
    {
        return [
            'Derived Pure Compound ID',
            'Created At',
            'Updated At',
            'Date Sample Submitted',
            'Synthesis Potential',
            'Amount Available',
            'Source ID',
            'Research Group',
            'Submitted By',
            'Solubility',
            'Stereo Comments',
            'SMILE Structure',
            'Molecular Weight',
            'Existing Patent',
            'Existing Literature',
            'Literature Link',
            'Solvent Used',
            'Comments',
        ];
    }
}
