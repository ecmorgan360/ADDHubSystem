<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProcessRepository;
use App\Models\Massspec;
use App\Models\Nmr;
use App\Models\Bioassay;
use App\Models\Process;
use App\Models\Hplcrequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class ProcessformController extends Controller
{
    /**
     * Create a new controller instance.
     * @param GroupRepository
     * @return void
     */
    public function __construct(ProcessRepository $processes)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->processes = $processes;
    }

    public function index(Request $request)
    {
        if ($request->supplier_type == "Fraction") {
            $process_id = $this->processes->getMnp();
        }
        else {
            $process_id = $this->processes->getAmr();
        }  

        $process = new Process();

        return view('processform', [
            'supplier_id' => $request->supplier_id,
            'supplier_type' => $request->supplier_type,
            'process_id' => $process_id,
            'process_date' => NULL,
            'process_ms' => NULL,
            'process_nmr' => NULL,
            'process_hplc' => NULL,
            'process_bioassay' => NULL,
            'process_pk' => NULL,
        ])->withProcess($process);
    }

    public function edit(Request $request, Process $process)
    {
        return view('processform', [
            'supplier_id' => $process->supplier_id,
            'supplier_type' => $process->sample_level,
            'process_id' => $process->process_id,
            'process_date' => $process->date_assigned,
            'process_ms' => $this->processes->getMSProcess($process->process_id)->process_id,
            'process_nmr' => $this->processes->getNMRProcess($process->process_id)->process_id,
            'process_hplc' => $this->processes->getHplcProcess($process->process_id)->process_id,
            'process_bioassay' => $this->processes->getBioassayProcess($process->process_id)->process_id,
            'process_pk' => $this->processes->getPKProcess($process->process_id)->pk_requested,
        ])->withProcess($process);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'process_name' => 'required|unique:processes,process_id|max:10',
        ]);

        $process = new Process();
        $process->process_id = $request->process_name;
        $process->supplier_id = $request->supplier_process;
        $process->assigner_id = Auth::user()->id;
        $process->date_assigned = $request->date_assigned;
        $process->sample_level = $request->supplier_level;

        $process->save();

        if ($request->has('ms_process')) {
            $ms = new Massspec();
            $ms->process_id = $request->process_name;
            $ms->date_requested = $request->date_assigned;
            $ms->cancelled = False;

            $ms->save();
        }

        if ($request->has('nmr_process')) {
            $nmr = new Nmr();
            $nmr->process_id = $request->process_name;
            $nmr->date_requested = $request->date_assigned;
            $nmr->cancelled = False;

            $nmr->save();
        }

        if ($request->has('hplc_process')) {
            $hplcrequest = new Hplcrequest();
            $hplcrequest->process_id = $request->process_name;
            $hplcrequest->date_requested = $request->date_assigned;
            $hplcrequest->cancelled = False;

            $hplcrequest->save();
        }

        if ($request->has('bioassay_process')) {
            $bioassay = new Bioassay();
            $bioassay->process_id = $request->process_name;
            $bioassay->date_received = $request->date_assigned;
            $bioassay->cancelled = False;
            if ($request->has('pk_process')) {
                $bioassay->pk_requested = True;
            }
            else {
                $bioassay->pk_requested = False;
            }

            $bioassay->save();
        }

        return redirect()->action([SearchController::class, 'index']);

    }

    public function update(Request $request, Process $process)
    {
        $saveMS = False;
        $saveNMR = False;
        $saveBio = False;
        $saveHPLC = False;
        $saveNewProcess = False;

        $process->date_assigned = $request->date_assigned;

        $newMS = new Massspec();
        $newNMR = new NMR();
        $newHPLC = new Hplcrequest();
        $newBioassay = new Bioassay();
        if ($request->process_name != $process->process_id) {
            $newprocess = Process::where('process_id', '=', $request->process_name)->first();
            if ($newprocess != NULL) {
                throw ValidationException::withMessages(['process_name' => 'This process ID already exists. Please use another process name or edit the process.']);
            }
            else {
                $saveNewProcess = True;
                $newprocess = new Process();
                $newprocess->process_id = $request->process_name;
                $newprocess->supplier_id = $process->supplier_id;
                $newprocess->assigner_id = $process->assigner_id;
                $newprocess->date_assigned = $process->date_assigned;
                $newprocess->sample_level = $process->sample_level;
            }
        }
        $newMS = Massspec::where('process_id', '=', $process->process_id)->first();
        $newNMR = NMR::where('process_id', '=', $process->process_id)->first();
        $newHPLC = Hplcrequest::where('process_id', '=', $process->process_id)->first();
        $newBioassay = Bioassay::where('process_id', '=', $process->process_id)->first();
        if ($newMS != NULL) {
            $newMS->process_id = $request->process_name;
            $saveMS = True;
        }
        else {
            $newMS = new Massspec();
            $newMS->process_id = $request->process_name;
        }
        if ($newNMR != NULL) {
            $newNMR->process_id = $request->process_name;
            $saveNMR = True;
        }
        else {
            $newNMR = new NMR();
            $newNMR->process_id = $request->process_name;
        }
        if ($newHPLC != NULL) {
            $newHPLC->process_id = $request->process_name;
            $saveHPLC = True;
        }
        else {
            $newHPLC = new Hplcrequest();
            $newHPLC->process_id = $request->process_name;
        }
        if ($newBioassay != NULL) {
            $newBioassay->process_id = $request->process_name;
            $saveBio = True;
        }
        else {
            $newBioassay = new Bioassay();
            $newBioassay->process_id = $request->process_name;
        }

        $msID = Massspec::where('process_id', '=', $process->process_id)->first();
        // dd($msID);
        if ($request->has('ms_process')) {
            if ($msID == NULL) {
                $newMS->date_requested = $request->date_assigned;
                $newMS->cancelled = False;
                $saveMS = True;
            }
            elseif ($msID != NULL AND $msID->cancelled == True) {
                $newMS->date_requested = $request->date_assigned;
                $newMS->cancelled = False;
                $saveMS = True;
            }
        }
        else {
            if ($msID != NULL) {
                $newMS->cancelled = True;
                $saveMS = True;
            }
        }

        $nmrID = NMR::where('process_id', '=', $process->process_id)->first();
        if ($request->has('nmr_process')) {
            if ($nmrID == NULL) {
                $newNMR->date_requested = $request->date_assigned;
                $newNMR->cancelled = False;
                $saveNMR = True;
            }
            elseif ($nmrID != NULL AND $nmrID->cancelled == True) {
                $newNMR->date_requested = $request->date_assigned;
                $newNMR->cancelled = False;
                $saveNMR = True;
            }
        }
        else {
            if ($nmrID != NULL) {
                $newNMR->cancelled = True;
                $saveNMR = True;
            }
        }

        $hplcID = Hplcrequest::where('process_id', '=', $process->process_id)->first();
        if ($request->has('hplc_process')) {
            if ($hplcID == NULL) {
                $newHPLC->date_requested = $request->date_assigned;
                $newHPLC->cancelled = False;
                $saveHPLC = True;
            }
            elseif ($hplcID != NULL AND $hplcID->cancelled == True) {
                $newHPLC->date_requested = $request->date_assigned;
                $newHPLC->cancelled = False;
                $saveHPLC = True;
            }
        }
        else {
            if ($hplcID != NULL) {
                $newHPLC->cancelled = True;
                $saveHPLC = True;
            }
        }

        $bioassayID = Bioassay::where('process_id', '=', $process->process_id)->first();
        if ($request->has('bioassay_process')) {
            if ($bioassayID == NULL) {
                $newBioassay->date_received = $request->date_assigned;
                $newBioassay->cancelled = False;
                if ($request->has('pk_process')) {
                    $newBioassay->pk_requested = True;
                }
                else {
                    $newBioassay->pk_requested = False;
                }
                $saveBio = True;
            }
            elseif ($bioassayID != NULL AND $bioassayID->cancelled == True) {
                $newBioassay->date_received = $request->date_assigned;
                $newBioassay->cancelled = False;
                if ($request->has('pk_process')) {
                    $newBioassay->pk_requested = True;
                }
                else {
                    $newBioassay->pk_requested = False;
                }
                $saveBio = True;
            }
            else {
                if ($request->has('pk_process')) {
                    $newBioassay->pk_requested = True;
                }
                else {
                    $newBioassay->pk_requested = False;
                }
                $saveBio = True;
            }
        }
        else {
            if ($bioassayID != NULL) {
                $newBioassay->cancelled = True;
                $newBioassay->pk_requested = False;
                $saveBio = True;
            }
        }

        if ($saveNewProcess) {
            $newprocess->save();
        }

        if ($saveMS) {
            $newMS->save();
        }
        if ($saveNMR) {
            $newNMR->save();
        }
        if ($saveBio) {
            $newBioassay->save();
        }
        if ($saveHPLC) {
            $newHPLC->save();
        }

        if ($saveNewProcess) {
            $process->delete();
        }
        else {
            $process->save();
        }

        return redirect()->action([SearchController::class, 'index']);

    }
}
