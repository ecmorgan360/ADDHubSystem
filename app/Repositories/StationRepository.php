<?php
 
namespace App\Repositories;

use App\Models\Station;
use Illuminate\Support\Facades\DB;
 
class StationRepository
{
    /**
     * Get all of the distinct classifications in the collection table.
     *
     * 
     * @return array
     */
    public function getStations()
    {
        return DB::table('stations')
        ->select('station_id', 'station_name')
        ->orderBy('station_id', 'asc')
        ->get();
    }

}