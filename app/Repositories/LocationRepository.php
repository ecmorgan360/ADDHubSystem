<?php
 
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
 
class LocationRepository
{
    /**
     * Get all of the distinct classifications in the collection table.
     *
     * 
     * @return array
     */
    public function getCountries()
    {
        return DB::table('countries')
        ->orderBy('country_name', 'asc')
        ->select('country_id', 'country_name')
        ->get()->toArray();
    }

}