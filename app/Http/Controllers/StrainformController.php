<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaxonomyRepository;
use App\Repositories\StrainRepository;
use App\Models\Strain;
use Illuminate\Validation\ValidationException;

class StrainformController extends Controller
{
    /**
     * The user repository instance.
     *
     * @var StrainRepository
     */
    protected $strains;

    /**
     * The taxonomy repository instance.
     *
     * @var TaxonomyRepository
     */
    protected $taxonomies;

    public function __construct(StrainRepository $strains, TaxonomyRepository $taxonomies)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->strains = $strains;
        $this->taxonomies = $taxonomies;
    }

     /**
     * Display the main strain form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->edit($request, new Strain());
        // $strain = new Strain();
        // return view('collectionform', [
        //     'groups' => $this->groups->allGroups(),
        //     'identifiers' => $this->users->getIdentifiers(),
        //     'collectors' => $this->users->getCollectors(),
        //     'classifications' => $this->collections->getClassifications(),
        //     'permits' => $this->collections->getPermits(),
        //     'sites' => $this->sites->getSites(),
        //     'stations' => $this->stations->getStations(),
        //     'taxonomies' => $this->taxonomies->getSpecies(),
        //     'myCollectors' => null,
        // ])->withStrain($strain);
    }

    public function edit(Request $request, Strain $strain)
    {
        //dd($this->collections->getCollectionCollectors($collection->sample_id)->get());
        return view('strainform', [
            'medias' => $this->strains->getMedias(),
            'taxonomies' => $this->taxonomies->getSpecies(),
        ])->withStrain($strain);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'strain_name' => 'required|unique:strains,strain_id|max:30',
        ]);

        $strain = new Strain;
        $strain->strain_id = $request->strain_name;
        $strain->cultivation_media = $request->media_strain;
        $strain->taxonomy_id = $request->species_strain;
        
        $strain->save();

        return redirect()->action([StrainformController::class, 'index']);

    }

    public function update(Request $request, Strain $strain)
    {

        if ($strain->strain_id != $request->strain_name) {
            $newstrain = Strain::where('strain_id', '=', $request->strain_name)->first();
            if ($newstrain != NULL) {
                throw ValidationException::withMessages(['strain_name' => 'This strain ID already exists. Please edit instead.']);
            }
        }

        $strain->strain_id = $request->strain_name;
        $strain->cultivation_media = $request->media_strain;
        $strain->taxonomy_id = $request->species_strain;

        $strain->save();

        return redirect()->action([SearchController::class, 'index']);

    }
}
