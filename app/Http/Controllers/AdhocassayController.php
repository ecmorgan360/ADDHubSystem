<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Derivedpurecomp;
use App\Models\Adhocassay;
use App\Repositories\AdhocassayRepository;

class AdhocassayController extends Controller
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

    public function index(Request $request, Derivedpurecomp $derivedpurecomp)
    {
        $adhocassays = $this->adhocassays->getAdhocs($derivedpurecomp->derivedpurecomp_id);
        // dd($adhocassays);
        return view('adhocassay', [
            'adhocassays' => $adhocassays,
        ])->withDerivedpurecomp($derivedpurecomp);
    }

    public function download(Request $request, Derivedpurecomp $derivedpurecomp, Adhocassay $adhocassay, String $download)
    {
        $path = storage_path().'/app/'.$adhocassay->link_report;
        // dd(is_file($path));

        $extension = pathinfo(storage_path($adhocassay->link_report), PATHINFO_EXTENSION);
        $name = $derivedpurecomp->derivedpurecomp_id.'_adhoc_'.$adhocassay->adhoc_type.'_.'.$extension;
        return response()->download($path, $name);
    }
}
