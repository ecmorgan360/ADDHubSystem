<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DashboardRepository;

class DashboardController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var DashboardRepository
     */
    protected $dashboards;

    /**
     * Create a new controller instance.
     * @param ProcessRepository
     * @return void
     */
    public function __construct(DashboardRepository $dashboards)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->dashboards = $dashboards;

    }

    public function index(Request $request)
    {
        // dd($this->dashboards->getAssignerExtracts($request));
        return view('dashboard', [
            'startDate' => null,
            'endDate' => null,
            'result_extracts' => $this->dashboards->getAssignerExtracts($request),
            'result_fractions' => $this->dashboards->getAssignerFractions($request),
            'result_purecomps' => $this->dashboards->getAssignerPurecomps($request),
            'result_proc_bioassays' => $this->dashboards->getBioassayProcesses($request),
            'result_proc_massspecs' => $this->dashboards->getMassspecProcesses($request),
            'result_proc_nmrs' => $this->dashboards->getNmrProcesses($request),
            'result_proc_hplcs' => $this->dashboards->getHplcProcesses($request),
            'result_collections' => $this->dashboards->getCollections($request),
        ]);
    }

    public function result(Request $request)
    {
        return view('dashboard', [
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
            'result_extracts' => $this->dashboards->getAssignerExtracts($request),
            'result_fractions' => $this->dashboards->getAssignerFractions($request),
            'result_purecomps' => $this->dashboards->getAssignerPurecomps($request),
            'result_proc_bioassays' => $this->dashboards->getBioassayProcesses($request),
            'result_proc_massspecs' => $this->dashboards->getMassspecProcesses($request),
            'result_proc_nmrs' => $this->dashboards->getNmrProcesses($request),
            'result_proc_hplcs' => $this->dashboards->getHplcProcesses($request),
            'result_collections' => $this->dashboards->getCollections($request),
        ]);
    }
}
