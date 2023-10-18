<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProcessRepository;
use Carbon\Carbon;
use App\Models\Massspec;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class MassspecformController extends Controller
{
     /**
     * Display the main mass spec form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->add($request, new Massspec());
        // return view('massspecform');
    }

    /**
     * Display the main nmr form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function add(Request $request, Massspec $massspec)
    {
        return view('massspecform')->withMassspec($massspec);
    }

    public function store(Request $request)
    {
        // dd($request);

        $validated = $request->validate([
            'ms_process' => 'required|exists:processes,process_id',
        ]);

        $massSpec = Massspec::where('process_id', '=', $request->ms_process)->first();
        if ($massSpec === null) {
            $massSpec = new Massspec;
            $massSpec->cancelled = False;
        } 

        if($massSpec->date_submitted != NULL) {
            throw ValidationException::withMessages(['ms_process' => 'This MS has already been entered. Please edit instead.']);
        }

        $file = $request->file('ms_file');
        $path = $file->storeAs(
            '/ms', $file->hashname(),
        );

        $massSpec->link_processed_spec = $path;
        $massSpec->process_id = $request->ms_process;
        $massSpec->date_submitted = Carbon::now()->format('Y-m-d');
        $massSpec->save();

        return redirect()->action([DashboardController::class, 'index']);

    }

    public function update(Request $request, Massspec $massspec)
    {

        $validated = $request->validate([
            'ms_process' => 'required|exists:processes,process_id',
        ]);

        if ($massspec === NULL) {
            throw ValidationException::withMessages(['ms_process' => 'This MS has not been created. Please add instead of edit.']);
        }

        if ($massspec->date_submitted === NULL) {
            throw ValidationException::withMessages(['ms_process' => 'This MS has not been added, only created. Please add instead of edit.']);
        }

        //dd(storage_path().'/app/'.$massSpec->link_processed_spec);
        $oldpath = storage_path().'/app/'.$massspec->link_processed_spec;

        if(is_file($oldpath)) {
            Storage::delete($massspec->link_processed_spec);
        }

        $file = $request->file('ms_file');
        $path = $file->storeAs(
            '/ms', $file->hashname(),
        );

        $massspec->link_processed_spec = $path;
        $massspec->process_id = $request->ms_process;
        $massspec->date_submitted = Carbon::now()->format('Y-m-d');
        $massspec->save();

        return redirect()->action([SearchController::class, 'index']);

    }


}
