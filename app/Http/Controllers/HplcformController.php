<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Hplc;
use App\Models\Hplc_process;
use App\Repositories\HplcRepository;
use App\Http\Controllers\Controller;

class HplcformController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var HplcRepository
     */
    protected $hplcs;

    /**
     * Create a new controller instance.
     * @param GroupRepository
     * @return void
     */
    public function __construct(HplcRepository $hplcs)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->hplcs = $hplcs;
    }

    /**
     * Display the main mass spec form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->add($request, new Hplc());
        // return view('massspecform');
    }

    /**
     * Display the main nmr form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function add(Request $request, Hplc $hplc)
    {
        // dd($this->hplcs->getRequested());
        return view('hplcform', [
            'diluents' => $this->hplcs->getDiluents(),
            'results' => $this->hplcs->getRequested(),
            'myProcesses' => null,
        ])->withHplc($hplc);
    }

    public function store(Request $request)
    {
        $hplc = new Hplc();

        $uvfile = $request->file('hplc_uvtrace');
        $uvpath = $uvfile->storeAs(
            '/uvtrace', $uvfile->hashname(),
        );

        $reportfile = $request->file('hplc_report');
        $reportpath = $reportfile->storeAs(
            '/uvtrace', $reportfile->hashname(),
        );

        $hplc->link_uvtrace = $uvpath;
        $hplc->link_report = $reportpath;
        $hplc->diluent = $request->diluent_hplc;
        $hplc->date_submitted = $request->hplc_date;

        $hplc->save();

        foreach ($request->requests_hplc as $processID) {
            $hplcprocess = new Hplc_process();
            $hplcprocess->hplc_id = $hplc->hplc_id;
            $hplcprocess->process_id = $processID;

            $hplcprocess->save();
        }

        return redirect()->action([HplcformController::class, 'index']);
    }
}
