<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Gen16s;
use App\Models\Metagenome;
use App\Repositories\CollectionRepository;
use App\Repositories\GenomicsRepository;

class SupplierController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var CollectionRepository
     */
    protected $collections;

    /**
     * The taxonomy repository instance.
     *
     * @var GenomicsRepository
     */
    protected $genomics;

    /**
     * Create a new controller instance.
     * @param ProcessRepository
     * @return void
     */
    public function __construct(CollectionRepository $collections, GenomicsRepository $genomics)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->collections = $collections;
        $this->genomics = $genomics;

    }

    public function index(Request $request, String $supplier_id)
    {
        $collection = $this->collections->getCollection($supplier_id);
        $strain = $this->collections->getStrain($supplier_id);
        if ($collection->first() != NULL) {
            $results_type = "Collection";
            $results = $collection;
            $results_collectors = $this->collections->getCollectors($supplier_id);
        }
        else if ($strain->first() != NULL) {
            $results_type = "Strain";
            $results = $strain;
            $results_collectors = NULL;
        }
        else {
            $results_type = "None";
            $results = NULL;
            $results_collectors = NULL;
        }

        return view('supplier', [
            'results_type' => $results_type,
            'results' => $results,
            'result_name' => $supplier_id,
            'results_collectors' => $results_collectors,
            'results_gen16s' => $this->genomics->getGen16sDetails($supplier_id),
            'results_metagenome' => $this->genomics->getMetagenomeDetails($supplier_id),
        ]);
    }

    public function download(Request $request, Int $id, String $supplier_id, String $download)
    {
        if ($download == "16SF") {
            $object = Gen16s::where('gen16s_id', '=', $id)->first();
            $link = $object->link_forward;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $supplier_id.'_forward_.'.$extension;
        }
        else if ($download == "16SR") {
            $object = Gen16s::where('gen16s_id', '=', $id)->first();
            $link = $object->link_reverse;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $supplier_id.'_reverse_.'.$extension;
        }
        else {
            $object = Metagenome::where('metagenome_id', '=', $id)->first();
            $link = $object->link_bam;

            $path = storage_path().'/app/'.$link;
            // dd(is_file($path));

            $extension = pathinfo(storage_path($link), PATHINFO_EXTENSION);
            $name = $supplier_id.'_metagenome_.'.$extension;
        }
        
        return response()->download($path, $name);
    }
}
