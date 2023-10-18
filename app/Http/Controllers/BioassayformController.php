<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GroupRepository;
use App\Repositories\BioassayRepository;
use App\Models\Bioassay;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class BioassayformController extends Controller
{
    /**
     * The group repository instance.
     *
     * @var GroupRepository
     */
    protected $groups;

    /**
     * The bioassay repository instance.
     *
     * @var BioassayRepository
     */
    protected $bioassays;

    /**
     * Create a new controller instance.
     * @param GroupRepository
     * @param BioassayRepository
     * @return void
     */
    public function __construct(GroupRepository $groups, BioassayRepository $bioassays)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->groups = $groups;
        $this->bioassays = $bioassays;

    }

    /**
     * Display the main bioassay form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->add($request, new Bioassay());

        // return view('bioassayform', [
        //     'groups' => $this->groups->allGroups(),
        //     'diluents' => $this->bioassays->getDiluents(),
        //     'concentrations' => $this->bioassays->getConcentrations(),
        // ]);
    }

    /**
     * Display the main bioassay form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function add(Request $request, Bioassay $bioassay)
    {
        return view('bioassayform', [
            'groups' => $this->groups->allGroups(),
            'diluents' => $this->bioassays->getDiluents(),
            'concentrations' => $this->bioassays->getConcentrations(),
        ])->withBioassay($bioassay);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bioassay_process' => 'required|exists:processes,process_id',
        ]);
        
        
        $bioassay = Bioassay::where('process_id', '=', $request->bioassay_process)->first();
        
        if ($bioassay === null) {
            $bioassay = new Bioassay;
            $bioassay->process_id = $request->bioassay_process;
            $bioassay->pk_requested = false;
        } else if ($bioassay->responsible_pi_id != null) {
            throw ValidationException::withMessages(['bioassay_process' => 'This record exists. Please edit it or specify a different process ID.']);
        }
        
        $bioassay->date_received = $request->date_received;
        $bioassay->molecular_id = $request->molecular_id;
        $bioassay->diluent = $request->diluent_bioassay;
        $bioassay->concentration = $request->concentration_bioassay;
        $bioassay->amount = $request->amount_bioassay;
        $bioassay->responsible_pi_id = $request->group_name;
        $bioassay->ecoli_v = $request->ecoliv;
        $bioassay->ecoli_sd = $request->ecolisd;
        $bioassay->saureus_v = $request->saureusv;
        $bioassay->saureus_sd = $request->saureussd;
        $bioassay->pareu_v = $request->pareuv;
        $bioassay->pareu_sd = $request->pareusd;
        $bioassay->saureus_bio_v = $request->saureusbiosv;
        $bioassay->saureus_bio_sd = $request->saureusbiosd;
        $bioassay->pareu_bio_v = $request->pareubiov;
        $bioassay->pareu_bio_sd = $request->pareubiosd;
        $bioassay->cytotox_v = $request->cytotoxv;
        $bioassay->cytotox_sd = $request->cytotoxsd;
        $bioassay->pk_activity = $request->pk_activity;
        $bioassay->dxr_activity = $request->dxr_activity;
        $bioassay->confirm_dxr_activity = $request->confirm_dxr_activity;
        $bioassay->hppk_activity = $request->hppk_activity;
        $bioassay->researcher_id = Auth::user()->id;

        $bioassay->save();

        return redirect()->action([BioassayformController::class, 'index']);

    }

    public function update(Request $request)
    {
        // dd($request);

        $validated = $request->validate([
            'bioassay_process' => 'required|exists:processes,process_id',
        ]);
        
        
        $bioassay = Bioassay::where('process_id', '=', $request->bioassay_process)->first();
        
        if ($bioassay === null) {
            throw ValidationException::withMessages(['bioassay_process' => 'This bioassay record has not been created. Please add it before updating.']);
        } else if ($bioassay->responsible_pi_id === null) {
            throw ValidationException::withMessages(['bioassay_process' => 'This bioassay record has not been added yet. Please add it before updating.']);
        }
        
        $bioassay->date_received = $request->date_received;
        $bioassay->molecular_id = $request->molecular_id;
        $bioassay->diluent = $request->diluent_bioassay;
        $bioassay->concentration = $request->concentration_bioassay;
        $bioassay->amount = $request->amount_bioassay;
        $bioassay->responsible_pi_id = $request->group_name;
        $bioassay->ecoli_v = $request->ecoliv;
        $bioassay->ecoli_sd = $request->ecolisd;
        $bioassay->saureus_v = $request->saureusv;
        $bioassay->saureus_sd = $request->saureussd;
        $bioassay->pareu_v = $request->pareuv;
        $bioassay->pareu_sd = $request->pareusd;
        $bioassay->saureus_bio_v = $request->saureusbiov;
        $bioassay->saureus_bio_sd = $request->saureusbiosd;
        $bioassay->pareu_bio_v = $request->pareubiov;
        $bioassay->pareu_bio_sd = $request->pareubiosd;
        $bioassay->cytotox_v = $request->cytotoxv;
        $bioassay->cytotox_sd = $request->cytotoxsd;
        $bioassay->pk_activity = $request->pk_activity;
        $bioassay->dxr_activity = $request->dxr_activity;
        $bioassay->confirm_dxr_activity = $request->confirm_dxr_activity;
        $bioassay->hppk_activity = $request->hppk_activity;
        $bioassay->researcher_id = Auth::user()->id;

        // dd($bioassay);

        $bioassay->save();

        return redirect()->action([BioassayformController::class, 'index']);

    }
}
