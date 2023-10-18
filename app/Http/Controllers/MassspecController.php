<?php

namespace App\Http\Controllers;
use App\Models\Massspec;
use App\Models\Massspeccsv;
use App\Models\Massspecmgf;
use App\Repositories\MassspecRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MassspecController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var MassspecRepository
     */
    protected $massspecs;

    /**
     * Create a new controller instance.
     * @param MassspecRepository
     * @return void
     */
    public function __construct(MassspecRepository $massspecs)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->massspecs = $massspecs;

    }

    public function index(Request $request, Massspec $massspec, String $process_id)
    {
        // dd($massspec);
        return view('massspec', [
            'process_id' => $process_id,
            'msmgfs' => $this->massspecs->getMgfs($massspec->massspec_id),
            'mscsvs' => $this->massspecs->getCsvs($massspec->massspec_id),
        ])->withMassspec($massspec);
    }

    // public function csvDownload(Request $request, Massspeccsv $massspeccsv, String $process_id, String $download)
    // {
    //     $path = storage_path().'/app/'.$massspeccsv->link_csv;
    //     // dd(is_file($path));

    //     $extension = pathinfo(storage_path($massspeccsv->link_csv), PATHINFO_EXTENSION);
    //     $name = $process_id.'_mscsv_.'.$extension;
    //     return response()->download($path, $name);
    // }

    public function download(Request $request, Int $id, String $process_id, String $download)
    {
        if ($download == "MGF") {
            $object = Massspecmgf::where('mgf_id', '=', $id)->first();
            $link = $object->link_mgf;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $process_id.'_msmgf_.'.$extension;
        }
        else {
            $object = Massspeccsv::where('csv_id', '=', $id)->first();
            $link = $object->link_csv;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $process_id.'_mscsv_.'.$extension;
        }
        
        return response()->download($path, $name);
    }

}
