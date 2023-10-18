<?php
 
namespace App\Repositories;

use App\Models\Site;
use Illuminate\Support\Facades\DB;
 
class SiteRepository
{
    /**
     * Get all of the distinct classifications in the collection table.
     *
     * 
     * @return array
     */
    public function getSites()
    {
        return DB::table('sites')
        ->orderBy('site_id', 'asc')
        ->get()->toArray();
    }

}