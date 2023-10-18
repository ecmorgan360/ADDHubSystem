<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MassspecRepository;
use App\Models\Massspec;
use App\Models\Massspecmgf;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MassspecmgfformController extends Controller
{
    public function add(Request $request, String $massspec_id)
    {
        $massspecmgf = new Massspecmgf();
        return view('msmgfform', [
            'massspec_id' => $massspec_id,
        ])->withMassspecmgf($massspecmgf);
    }

    public function edit(Request $request, String $massspec_id, Massspecmgf $massspecmgf)
    {
        // dd($massspecmgf);
        return view('msmgfform', [
            'massspec_id' => $massspec_id,
        ])->withMassspecmgf($massspecmgf);
    }

    public function store(Request $request)
    {
        $massspecmgf = new Massspecmgf();
        $massspecmgf->massspec_id = $request->msid_mgf;

        $file = $request->file('mgf_file');
        $path = $file->storeAs(
            '/msmgf', $file->hashname(),
        );

        $massspecmgf->link_mgf = $path;
        $massspecmgf->save();

        $massspec = Massspec::where('massspec_id', '=',  $massspecmgf->massspec_id)->first();
        return redirect()->route('massspec.index', ['massspec' => $massspecmgf->massspec_id, 'process_id' => $massspec->process_id]);
    }

    public function update(Request $request, Massspecmgf $massspecmgf)
    {

        // dd($massspecmgf);

        $oldpathForward = storage_path().'/app/'.$massspecmgf->link_mgf;

        if(is_file($oldpathForward)) {
            Storage::delete($massspecmgf->link_mgf);
        }

        $file = $request->file('mgf_file');
        $path = $file->storeAs(
            '/msmgf', $file->hashname(),
        );

        $massspecmgf->link_mgf = $path;
        $massspecmgf->save();

        $massspec = Massspec::where('massspec_id', '=',  $massspecmgf->massspec_id)->first();
        // dd($massspec);
        return redirect()->route('massspec.index', ['massspec' => $massspecmgf->massspec_id, 'process_id' => $massspec->process_id]);

    }
}
