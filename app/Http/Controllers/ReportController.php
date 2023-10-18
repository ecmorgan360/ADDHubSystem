<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReportRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrphanFractionsExport;
use App\Exports\OrphanCompoundsExport;
use App\Exports\BioassayReportsExport;
use Maatwebsite\Excel\HeadingRowImport;

class ReportController extends Controller
{
     /**
     * The taxonomy repository instance.
     *
     * @var ReportRepository
     */
    protected $reports;

    /**
     * Create a new controller instance.
     * @param ProcessRepository
     * @return void
     */
    public function __construct(ReportRepository $reports)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->reports = $reports;

    }

    public function orphanfractionIndex(Request $request)
    {
        return view('orphanfractions', [
            'startDate' => null,
            'endDate' => null,
            'result_fractions' => $this->reports->getOrphanFractions($request),
        ]);
    }

    public function orphancompoundIndex(Request $request)
    {
        return view('orphancompounds', [
            'startDate' => null,
            'endDate' => null,
            'result_compounds' => $this->reports->getOrphanCompounds($request),
        ]);
    }

    public function bioassayreportIndex(Request $request)
    {
        return view('bioassayreport', [
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'result_bioassays' => $this->reports->getBioassayReports($request)->paginate(50)->withQueryString(),
        ]);
    }

    public function orphanfractionResult(Request $request)
    {
        return view('orphanfractions', [
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'result_fractions' => $this->reports->getOrphanFractions($request),
        ]);
    }

    public function orphancompoundResult(Request $request)
    {
        return view('orphancompounds', [
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'result_compounds' => $this->reports->getOrphanCompounds($request),
        ]);
    }

    public function bioassayreportResult(Request $request)
    {
        return view('bioassayreport', [
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'result_bioassays' => $this->reports->getBioassayReports($request)->paginate(50)->withQueryString(),
        ]);
    }


    public function exportOrphanFractions()
    {
        $export = new OrphanFractionsExport($this->reports->getOrphanFractions()->toArray());

        return Excel::download($export, 'orphanFractions.xlsx');
    }

    public function exportOrphanCompounds()
    {
        $export = new OrphanCompoundsExport($this->reports->getOrphanCompounds()->toArray());

        return Excel::download($export, 'orphanCompounds.xlsx');
    }

    public function exportBioassayReports(Request $request)
    {
        $export = new BioassayReportsExport($this->reports->getBioassayReports($request)->get()->toArray());

        return Excel::download($export, 'bioassay_report.xlsx');
    }

}
