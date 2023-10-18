<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LocationRepository;
use App\Models\Region;
use App\Models\City;
use App\Models\Localarea;
use App\Models\Station;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LocationformController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var LocationRepository
     */
    protected $locations;

    /**
     * Create a new controller instance.
     * @param LocationRepository
     * @return void
     */
    public function __construct(LocationRepository $locations)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->locations = $locations;
    }

     /**
     * Display the main taxonomy form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('locationform', [
            'countries' => $this->locations->getCountries(),
        ]);
    }

    private function addCity($region_id, $city_name) {
        $city = new City();
        $city->region_id = $region_id;
        $city->city_name = $city_name;

        $city->save();
        return $city->city_id;
    }

    private function addLocalarea($city_id, $localarea_name) {
        $localarea = new Localarea();
        $localarea->city_id = $city_id;
        $localarea->localarea_name = $localarea_name;

        $localarea->save();
        return $localarea->localarea_id;
    }

    private function addStation($localarea_id, $station_name) {
        $station = new Station();
        $station->localarea_id = $localarea_id;
        $station->station_name = $station_name;

        $station->save();
        return $station->station_id;
    }

    private function addSite($station_id, $latitude, $longitude, $depthmin, $depthmax) {
        $site = new Site();
        $site->station_id = $station_id;
        $site->latitude = $latitude;
        $site->longitude = $longitude;
        $site->depth_min = $depthmin;
        $site->depth_max = $depthmax;

        $site->save();
        return $site->site_id;
    }

    public function store(Request $request)
    {
        $adding_new = False;
        if ($request->city_location == -1) {
            $adding_new = True;
            $val_new = City::where('city_name', '=', $request->city_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['city_new' => 'This city name exists. Please give a unique name.']);
            }
        }
        if ($request->localarea_location == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Localarea::where('localarea_name', '=', $request->localarea_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['localarea_new' => 'This local area name exists. Please give a unique name.']);
            }
        }
        if ($request->station_location == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Station::where('station_name', '=', $request->station_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['subphylum_new' => 'This station name exists. Please give a unique name.']);
            }
        }
        if ($request->site_location > 0) {
            throw ValidationException::withMessages(['site_new' => 'This location record exists. You do not need to add it.']);
        }
        if ($request->site_location == -1 || $adding_new) {
            $adding_new = True;
            $val_new = Site::where('latitude', '=', $request->latitude_new)->where('longitude', '=', $request->longitude_new)
            ->where('depth_min', '=', $request->depthmin_new)->where('depth_max', '=', $request->depthmax_new)->first();
            if ($val_new != null) {
                throw ValidationException::withMessages(['latitude_new' => 'This site exists. Please give a unique site.']);
            }
        }

        $now_adding = False;
        $parent_id = $request->region_location;
        // City
        if ($request->city_location == -1) {
            $now_adding = True;
            $parent_id = $this->addCity($parent_id, $request->city_new);
        }
        else {
            $parent_id = $request->city_location;
        }
        // Local area
        if ($request->localarea_location == -1 OR $now_adding) {
            $now_adding = True;
            $parent_id = $this->addLocalarea($parent_id, $request->localarea_new);
        }
        else {
            $parent_id = $request->localarea_location;
        }
        // Station
        if ($request->station_location == -1 OR $now_adding) {
            $now_adding = True;
            $parent_id = $this->addStation($parent_id, $request->station_new);
        }
        else {
            $parent_id = $request->station_location;
        }
        
        //Site
        $parent_id = $this->addSite($parent_id, $request->latitude_new, $request->longitude_new, $request->depthmin_new, $request->depthmax_new);

        return redirect()->action([LocationformController::class, 'index']);

    }

    public function fetchRegion(Request $request)
    {
        $data['regions'] = Region::where("country_id", "=", $request->country_id)->get();
        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("region_id", "=", $request->region_id)->get();
        return response()->json($data);
    }

    public function fetchLocalarea(Request $request)
    {
        $data['localareas'] = Localarea::where("city_id", "=", $request->city_id)->get();
        return response()->json($data);
    }

    public function fetchStation(Request $request)
    {
        $data['stations'] = Station::where("localarea_id", "=", $request->localarea_id)->get();
        return response()->json($data);
    }

    public function fetchSite(Request $request)
    {
        $data['sites'] = Site::where("station_id", "=", $request->station_id)->get();
        return response()->json($data);
    }
}
