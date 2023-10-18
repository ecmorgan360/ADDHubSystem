<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Nmr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class NmrformController extends Controller
{
    /**
     * Display the main nmr form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->add($request, new Nmr());
        // return view('nmrform');
    }

    /**
     * Display the main nmr form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function add(Request $request, Nmr $nmr)
    {
        return view('nmrform')->withNmr($nmr);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nmr_process' => 'required|exists:processes,process_id',
        ]);

        $nmr = Nmr::where('process_id', '=', $request->nmr_process)->first();
        if ($nmr === null) {
            $nmr = new Nmr;
            $nmr->cancelled = False;
        } 

        if($nmr->date_submitted != NULL) {
            throw ValidationException::withMessages(['nmr_process' => 'This NMR has already been entered. Please edit instead.']);
        }

        $file = $request->file('nmr_file');
        $path = $file->storeAs(
            '/nmr', $file->hashname(),
        );

        $nmr->link_folder = $path;
        $nmr->process_id = $request->nmr_process;
        $nmr->date_submitted = Carbon::now()->format('Y-m-d');
        $nmr->save();

        return redirect()->action([NmrformController::class, 'index']);

    }

    public function update(Request $request, Nmr $nmr)
    {

        $validated = $request->validate([
            'nmr_process' => 'required|exists:processes,process_id',
        ]);

        if ($nmr === NULL) {
            throw ValidationException::withMessages(['nmr_process' => 'This NMR has not been created. Please add instead of edit.']);
        }

        if ($nmr->date_submitted === NULL) {
            throw ValidationException::withMessages(['nmr_process' => 'This NMR has not been added, only created. Please add instead of edit.']);
        }

        //dd(storage_path().'/app/'.$massSpec->link_processed_spec);
        $oldpath = storage_path().'/app/'.$nmr->link_folder;

        if(is_file($oldpath)) {
            Storage::delete($nmr->link_folder);
        }

        $file = $request->file('nmr_file');
        $path = $file->storeAs(
            '/nmr', $file->hashname(),
        );

        $nmr->link_folder = $path;
        $nmr->process_id = $request->nmr_process;
        $nmr->date_submitted = Carbon::now()->format('Y-m-d');
        $nmr->save();

        return redirect()->action([SearchController::class, 'index']);

    }
}
