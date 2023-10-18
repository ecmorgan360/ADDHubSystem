<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nmr;
use App\Models\Massspec;
use App\Models\Hplc;
use App\Repositories\ProcessRepository;


class ProcessController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var ProcessRepository
     */
    protected $processes;

    /**
     * Create a new controller instance.
     * @param ProcessRepository
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
        // dd($this->processes->getHplcDetails($request->process_id));
        return view('process', [
            'process_id' => $request->process_id,
            'supplier_id' => $request->supplier_id,
            'process_details' => $this->processes->getProcessDetails($request->process_id),
            'ms_details' => $this->processes->getMsDetails($request->process_id),
            'nmr_details' => $this->processes->getNmrDetails($request->process_id),
            'bioassay_details' => $this->processes->getBioassayDetails($request->process_id),
            'hplc_details' => $this->processes->getHplcDetails($request->process_id),
        ]);
    }

    public function download(Request $request, Int $id, String $process_id, String $supplier_id, String $download)
    {
        if ($download == "MS") {
            $object = Massspec::where('massspec_id', '=', $id)->first();
            $link = $object->link_processed_spec;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $process_id.'_ms.'.$extension;
        }
        else if ($download == "NMR") {
            $object = Nmr::where('nmr_id', '=', $id)->first();
            $link = $object->link_folder;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $process_id.'_nmr.'.$extension;
        }
        else if ($download == "UV") {
            $object = Hplc::where('hplc_id', '=', $id)->first();
            $link = $object->link_uvtrace;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $process_id.'_hplc_uvtrace.'.$extension;
        }
        else {
            $object = Hplc::where('hplc_id', '=', $id)->first();
            $link = $object->link_report;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $process_id.'_hplc_report.'.$extension;
        }
        
        return response()->download($path, $name);
    }
}
