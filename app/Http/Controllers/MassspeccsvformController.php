<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MassspecRepository;
use App\Models\Massspec;
use App\Models\Massspeccsv;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MassspeccsvformController extends Controller
{
    public function add(Request $request, String $massspec_id)
    {
        $massspeccsv = new Massspeccsv();
        return view('mscsvform', [
            'massspec_id' => $massspec_id,
        ])->withMassspeccsv($massspeccsv);
    }

    public function edit(Request $request, String $massspec_id, Massspeccsv $massspeccsv)
    {
        // dd($massspeccsv);
        return view('mscsvform', [
            'massspec_id' => $massspec_id,
        ])->withMassspeccsv($massspeccsv);
    }

    public function store(Request $request)
    {
        $massspeccsv = new Massspeccsv();
        $massspeccsv->massspec_id = $request->msid_csv;

        $file = $request->file('csv_file');
        $path = $file->storeAs(
            '/mscsv', $file->hashname(),
        );

        $massspeccsv->link_csv = $path;
        $massspeccsv->save();

        $massspec = Massspec::where('massspec_id', '=',  $massspeccsv->massspec_id)->first();
        return redirect()->route('massspec.index', ['massspec' => $massspeccsv->massspec_id, 'process_id' => $massspec->process_id]);
    }

    public function update(Request $request, Massspeccsv $massspeccsv)
    {

        //dd($massspeccsv);

        $oldpathForward = storage_path().'/app/'.$massspeccsv->link_csv;

        if(is_file($oldpathForward)) {
            Storage::delete($massspeccsv->link_csv);
        }

        $file = $request->file('csv_file');
        $path = $file->storeAs(
            '/mscsv', $file->hashname(),
        );

        $massspeccsv->link_csv = $path;
        $massspeccsv->save();

        $massspec = Massspec::where('massspec_id', '=',  $massspeccsv->massspec_id)->first();
        // dd($massspec);
        return redirect()->route('massspec.index', ['massspec' => $massspeccsv->massspec_id, 'process_id' => $massspec->process_id]);

    }
}
