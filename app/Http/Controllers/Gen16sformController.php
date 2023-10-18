<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gen16s;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class Gen16sformController extends Controller
{
     /**
     * Display the main mass spec form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->edit($request, new Gen16s());
        // return view('massspecform');
    }

    /**
     * Display the main nmr form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, Gen16s $gen16s)
    {
        return view('gen16sform')->withGen16s($gen16s);
    }

    public function store(Request $request)
    {

        // dd($request);
        $validated = $request->validate([
            'gen_supplier' => 'required|unique:gen16sraws,supplier_id',
        ]);



        $gen16sraw = new Gen16s();
        $gen16sraw->supplier_id = $request->gen_supplier;

        $fileforward = $request->file('gen_forward');
        $pathforward = $fileforward->storeAs(
            '/gen16s', $fileforward->hashname(),
        );

        $filereverse = $request->file('gen_reverse');
        $pathreverse = $filereverse->storeAs(
            '/gen16s', $filereverse->hashname(),
        );

        $gen16sraw->link_forward = $pathforward;
        $gen16sraw->link_reverse = $pathreverse;
        $gen16sraw->save();

        return redirect()->action([DashboardController::class, 'index']);
    }

    public function update(Request $request, Gen16s $gen16s)
    {

        // dd($request);
        $validated = $request->validate([
            'gen_supplier' => 'required|exists:gen16sraws,supplier_id',
        ]);

        $oldpathForward = storage_path().'/app/'.$gen16s->link_forward;

        if(is_file($oldpathForward)) {
            Storage::delete($gen16s->link_forward);
        }

        $oldpathReverse = storage_path().'/app/'.$gen16s->link_reverse;

        if(is_file($oldpathReverse)) {
            Storage::delete($gen16s->link_reverse);
        }

        $fileforward = $request->file('gen_forward');
        $pathforward = $fileforward->storeAs(
            '/gen16s', $fileforward->hashname(),
        );

        $filereverse = $request->file('gen_reverse');
        $pathreverse = $filereverse->storeAs(
            '/gen16s', $filereverse->hashname(),
        );

        $gen16s->link_forward = $pathforward;
        $gen16s->link_reverse = $pathreverse;
        $gen16s->save();

        return redirect()->action([SearchController::class, 'index']);
    }
}
