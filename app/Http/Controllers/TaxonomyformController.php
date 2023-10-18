<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaxonomyRepository;
use App\Models\Taxonomy;
use App\Http\Controllers\TaxonomyformController;
use Illuminate\Validation\ValidationException;

class TaxonomyformController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var TaxonomyRepository
     */
    protected $taxonomies;

    /**
     * Create a new controller instance.
     * @param GroupRepository
     * @return void
     */
    public function __construct(TaxonomyRepository $taxonomies)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->taxonomies = $taxonomies;
    }

     /**
     * Display the main taxonomy form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('taxonomyform', [
            'taxonomies' => $this->taxonomies->getTaxonomies(),
        ]);
    }

    private function addTaxonRecord($parent_id, $rank_id, $name) {
        $taxon = new Taxonomy();
        $taxon->parent_taxon_id = $parent_id;
        $taxon->rank_id = $rank_id;
        $taxon->taxon_name = $name;

        $taxon->save();
        return $taxon->taxonomy_id;
    }

    public function store(Request $request)
    {
        $adding_new = False;
        if ($request->kingdom == -1) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->kingdom_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['kingdom_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->phylum == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->phylum_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['phylum_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->subphylum == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->subphylum_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['subphylum_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->tax_class == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->class_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['tax_class' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->subclass == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->subclass_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['subclass_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->superorder == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->superorder_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['superorder_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->order == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->order_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['order_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->suborder == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->suborder_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['suborder_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->family == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->family_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['family_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->subfamily == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->subfamily_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['subfamily_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->genus == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->genus_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['genus_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->subgenus == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->subgenus_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['subgenus_new' => 'This name exists. Please give a unique name.']);
            }
        }
        if ($request->species > 0) {
            throw ValidationException::withMessages(['species_new' => 'This record exists. You do not need to add it.']);
        }
        if ($request->species == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Taxonomy::where('taxon_name', '=', $request->species_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['species_new' => 'This name exists. Please give a unique name.']);
            }
        }

        $now_adding = False;
        $parent_id = 0;
        // Kingdom
        if ($request->kingdom == -1) {
            $now_adding = True;
            $parent_id = $this->addTaxonRecord($parent_id, 1, $request->kingdom_new);
        }
        else {
            $parent_id = $request->kingdom;
        }
        //Phylum
        if ($request->phylum == -1 OR $now_adding) {
            $now_adding = True;
            $parent_id = $this->addTaxonRecord($parent_id, 2, $request->phylum_new);
        }
        else {
            $parent_id = $request->phylum;
        }
        //Subphylum
        if ($request->subphylum == -1 OR $now_adding) {
            if ($request->subphylum_new != NULL) {
                $now_adding = True;
                $parent_id = $this->addTaxonRecord($parent_id, 3, $request->subphylum_new);
            }
        }
        else if ($request->subphylum != 0){
            $parent_id = $request->subphylum;
        }
        //Class
        if ($request->tax_class == -1 OR $now_adding) {
            $now_adding = True;
            $parent_id = $this->addTaxonRecord($parent_id, 4, $request->class_new);
        }
        else {
            $parent_id = $request->tax_class;
        }
        //Subclass
        if ($request->subclass == -1 OR $now_adding) {
            if ($request->subclass_new != NULL) {
                $now_adding = True;
                $parent_id = $this->addTaxonRecord($parent_id, 5, $request->subclass_new);
            }
        }
        else if ($request->subclass != 0){
            $parent_id = $request->subclass;
        }
        //Superorder
        if ($request->superorder == -1 OR $now_adding) {
            if ($request->superorder_new != NULL){
                $now_adding = True;
                $parent_id = $this->addTaxonRecord($parent_id, 6, $request->superorder_new);
            }
        }
        else if ($request->superorder != 0){
            $parent_id = $request->superorder;
        }
        //Order
        if ($request->order == -1 OR $now_adding) {
            $now_adding = True;
            $parent_id = $this->addTaxonRecord($parent_id, 7, $request->order_new);
        }
        else {
            $parent_id = $request->order;
        }
        //Suborder
        if ($request->suborder == -1 OR $now_adding) {
            if ($request->suborder_new != NULL){
                $now_adding = True;
                $parent_id = $this->addTaxonRecord($parent_id, 8, $request->suborder_new);
            }
        }
        else if ($request->suborder != 0){
            $parent_id = $request->suborder;
        }
        //Family
        if ($request->family == -1 OR $now_adding) {
            $now_adding = True;
            $parent_id = $this->addTaxonRecord($parent_id, 9, $request->family_new);
        }
        else {
            $parent_id = $request->order;
        }
        //Subfamily
        if ($request->subfamily == -1 OR $now_adding) {
            if ($request->subfamily_new != NULL){
                $now_adding = True;
                $parent_id = $this->addTaxonRecord($parent_id, 10, $request->subfamily_new);
            }
        }
        else if ($request->subfamily != 0){
            $parent_id = $request->subfamily;
        }
        //Genus
        if ($request->genus == -1 OR $now_adding) {
            $now_adding = True;
            $parent_id = $this->addTaxonRecord($parent_id, 11, $request->genus_new);
        }
        else {
            $parent_id = $request->genus;
        }
        //Subgenus
        if ($request->subgenus == -1 OR $now_adding) {
            if ($request->subgenus_new != NULL){
                $now_adding = True;
                $parent_id = $this->addTaxonRecord($parent_id, 12, $request->subgenus_new);
            }
        }
        else if ($request->subgenus != 0){
            $parent_id = $request->subgenus;
        }
        //Species
        $parent_id = $this->addTaxonRecord($parent_id, 13, $request->species_new);

        return redirect()->action([TaxonomyformController::class, 'index']);

    }

    public function fetchPhylum(Request $request)
    {
        $data['phylums'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->get();
        return response()->json($data);
    }

    public function fetchSubphylum(Request $request)
    {
        $data['subphylums'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "3")->get();
        return response()->json($data);
    }

    public function fetchClass(Request $request)
    {
        $data['classes'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "4")->get();
        return response()->json($data);
    }

    public function fetchSubclass(Request $request)
    {
        $data['subclasses'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "5")->get();
        return response()->json($data);
    }

    public function fetchSuperorder(Request $request)
    {
        $data['superorders'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "6")->get();
        return response()->json($data);
    }

    public function fetchOrder(Request $request)
    {
        $data['orders'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "7")->get();
        return response()->json($data);
    }

    public function fetchSuborder(Request $request)
    {
        $data['suborders'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "8")->get();
        return response()->json($data);
    }

    public function fetchFamily(Request $request)
    {
        $data['families'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "9")->get();
        return response()->json($data);
    }

    public function fetchSubfamily(Request $request)
    {
        $data['subfamilies'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "10")->get();
        return response()->json($data);
    }

    public function fetchGenus(Request $request)
    {
        $data['geni'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "11")->get();
        return response()->json($data);
    }

    public function fetchSubgenus(Request $request)
    {
        $data['subgeni'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "12")->get();
        return response()->json($data);
    }

    public function fetchSpecies(Request $request)
    {
        $data['species'] = Taxonomy::where("parent_taxon_id", "=", $request->taxonomy_id)->where("rank_id", "=", "13")->get();
        return response()->json($data);
    }
}
