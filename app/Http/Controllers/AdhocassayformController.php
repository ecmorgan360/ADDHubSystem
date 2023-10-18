<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AdhocassayRepository;
use App\Models\Adhocassay;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AdhocassayformController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var AdhocassayRepository
     */
    protected $adhocassays;

    /**
     * Create a new controller instance.
     * @param AdhocassayRepository
     * @return void
     */
    public function __construct(AdhocassayRepository $adhocassays)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->adhocassays = $adhocassays;

    }

    public function add(Request $request, String $derivedpurecomp_id)
    {
        $adhocassay = new Adhocassay();
        return view('adhocassayform', [
            'derivedpurecomp_id' => $derivedpurecomp_id,
            'adhoctypes' => $this->adhocassays->getTypes(),
        ])->withAdhocassay($adhocassay);
    }

    public function edit(Request $request, String $derivedpurecomp_id, Adhocassay $adhocassay)
    {
        return view('adhocassayform', [
            'derivedpurecomp_id' => $derivedpurecomp_id,
            'adhoctypes' => $this->adhocassays->getTypes(),
        ])->withAdhocassay($adhocassay);
    }

    public function store(Request $request)
    {

        // dd($request);

        $adhocassay = new Adhocassay();
        $adhocassay->pure_comp_id = $request->purecomp_adhoc;
        $adhocassay->adhoc_type = $request->type_adhoc;

        $file = $request->file('adhoc_file');
        $path = $file->storeAs(
            '/adhocassay', $file->hashname(),
        );

        $adhocassay->link_report = $path;
        $adhocassay->save();

        return redirect()->route('adhocassay.index', ['derivedpurecomp' => $adhocassay->pure_comp_id]);
    }

    public function update(Request $request, Adhocassay $adhocassay)
    {

        // dd($request);

        $oldpathForward = storage_path().'/app/'.$adhocassay->link_report;

        if(is_file($oldpathForward)) {
            Storage::delete($adhocassay->link_report);
        }

        $file = $request->file('adhoc_file');
        $path = $file->storeAs(
            '/adhocassay', $file->hashname(),
        );

        $adhocassay->adhoc_type = $request->type_adhoc;
        $adhocassay->link_report = $path;
        $adhocassay->save();

        return redirect()->route('adhocassay.index', ['derivedpurecomp' => $adhocassay->pure_comp_id]);

    }
}
