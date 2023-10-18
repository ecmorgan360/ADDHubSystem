<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use App\Repositories\CollectionRepository;
use App\Repositories\SiteRepository;
use App\Repositories\StationRepository;
use App\Repositories\TaxonomyRepository;
use App\Models\Collection;
use App\Models\CollectionUser;
use Illuminate\Validation\ValidationException;


class CollectionformController extends Controller
{
    /**
     * The group repository instance.
     *
     * @var GroupRepository
     */
    protected $groups;

    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * The user repository instance.
     *
     * @var CollectionRepository
     */
    protected $collections;

    /**
     * The user repository instance.
     *
     * @var SiteRepository
     */
    protected $sites;

    /**
     * The user repository instance.
     *
     * @var StationRepository
     */
    protected $stations;

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
    public function __construct(GroupRepository $groups, UserRepository $users, CollectionRepository $collections, SiteRepository $sites, StationRepository $stations, TaxonomyRepository $taxonomies)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->groups = $groups;
        $this->users = $users;
        $this->collections = $collections;
        $this->sites = $sites;
        $this->stations = $stations;
        $this->taxonomies = $taxonomies;
    }

     /**
     * Display the main collection form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        //return $this->edit($request, new Collection());
        $collection = new Collection();
        return view('collectionform', [
            'groups' => $this->groups->allGroups(),
            'identifiers' => $this->users->getIdentifiers(),
            'collectors' => $this->users->getCollectors(),
            'classifications' => $this->collections->getClassifications(),
            'permits' => $this->collections->getPermits(),
            'sites' => $this->sites->getSites(),
            'stations' => $this->stations->getStations(),
            'taxonomies' => $this->taxonomies->getSpecies(),
            'myCollectors' => null,
        ])->withCollection($collection);
    }

    public function edit(Request $request, Collection $collection)
    {
        //dd($this->collections->getCollectionCollectors($collection->sample_id)->get());
        return view('collectionform', [
            'groups' => $this->groups->allGroups(),
            'identifiers' => $this->users->getIdentifiers(),
            'collectors' => $this->users->getCollectors(),
            'classifications' => $this->collections->getClassifications(),
            'permits' => $this->collections->getPermits(),
            'sites' => $this->sites->getSites(),
            'stations' => $this->stations->getStations(),
            'taxonomies' => $this->taxonomies->getSpecies(),
            'myCollectors' => $this->collections->getCollectionCollectors($collection->sample_id)->get(),
        ])->withCollection($collection);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sample_name' => 'required|unique:collections,sample_id|max:30',
        ]);

        $collect = new Collection;
        $collect->sample_id = $request->sample_name;
        $collect->site_id = $request->location_collection;
        $collect->date_collected = $request->date_collected;
        $collect->other_ids = $request->other_id_collect;
        $collect->identifier_id = $request->identifier_name;
        $collect->classification = $request->classification_collection;
        $collect->other_description = $request->other_description;
        $collect->taxonomy_id = $request->species_collection;
        $collect->permit_no = $request->permit_collection;

        $collect->save();

        foreach ($request->collector_name as $person) {
            $personCollector = new CollectionUser;
            $personCollector->user_id = $person;
            $personCollector->sample_id = $request->sample_name;
            $personCollector->save();
        }

        return redirect()->action([CollectionformController::class, 'index']);

    }

    public function update(Request $request, Collection $collection)
    {

        if ($collection->sample_id != $request->sample_name) {
            $newcollection = Collection::where('process_id', '=', $request->sample_name)->first();
            if ($newcollection != NULL) {
                throw ValidationException::withMessages(['sample_name' => 'This sample ID already exists. Please edit instead.']);
            }
        }

        $collectors = CollectionUser::where('sample_id', '=', $collection->sample_id)->get();
        // $collectors = CollectionUser::hydrate($collectorsEloquent);
        foreach ($collectors as $collector) {
            $collector->delete();
        }

        $collection->sample_id = $request->sample_name;
        $collection->site_id = $request->location_collection;
        $collection->date_collected = $request->date_collected;
        $collection->other_ids = $request->other_id_collect;
        $collection->identifier_id = $request->identifier_name;
        $collection->classification = $request->classification_collection;
        $collection->other_description = $request->other_description;
        $collection->taxonomy_id = $request->species_collection;
        $collection->permit_no = $request->permit_collection;

        $collection->save();

        foreach ($request->collector_name as $person) {
            $personCollector = new CollectionUser;
            $personCollector->user_id = $person;
            $personCollector->sample_id = $request->sample_name;
            $personCollector->save();
        }

        return redirect()->action([SearchController::class, 'index']);

    }

}
