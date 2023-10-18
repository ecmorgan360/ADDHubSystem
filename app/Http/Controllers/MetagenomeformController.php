<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metagenome;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MetagenomeformController extends Controller
{
    /**
     * Display the main mass spec form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->edit($request, new Metagenome());
        // return view('massspecform');
    }

    /**
     * Display the main nmr form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, Metagenome $metagenome)
    {
        return view('metagenomeform')->withMetagenome($metagenome);
    }

    public function store(Request $request)
    {

        // dd($request);
        $validated = $request->validate([
            'meta_supplier' => 'required|unique:metagenomeraw,supplier_id',
        ]);

        $metagenomeraw = new Metagenome();
        $metagenomeraw->supplier_id = $request->meta_supplier;

        $fileforward = $request->file('meta_bam');
        $pathforward = $fileforward->storeAs(
            '/metagenome', $fileforward->hashname(),
        );

        $metagenomeraw->link_bam = $pathforward;
        $metagenomeraw->save();

        return redirect()->action([DashboardController::class, 'index']);
    }

    public function update(Request $request, Metagenome $metagenome)
    {

        // dd($request);
        $validated = $request->validate([
            'gen_supplier' => 'required|exists:metagenomeraw,supplier_id',
        ]);

        $oldpathForward = storage_path().'/app/'.$metagenome->link_bam;

        if(is_file($oldpathForward)) {
            Storage::delete($metagenome->link_bam);
        }

        $fileforward = $request->file('meta_forward');
        $pathforward = $fileforward->storeAs(
            '/metagenome', $fileforward->hashname(),
        );

        $metagenome->link_forward = $pathforward;
        $metagenome->save();

        return redirect()->action([SearchController::class, 'index']);
    }
}
