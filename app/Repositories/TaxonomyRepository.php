<?php
 
namespace App\Repositories;

use App\Models\Taxonomy;
use Illuminate\Support\Facades\DB;
 
class TaxonomyRepository
{
    /**
     * Get all of the distinct classifications in the collection table.
     *
     * 
     * @return array
     */
    public function getTaxonomies()
    {
        return DB::table('taxonomies')
        ->orderBy('taxonomy_id', 'asc')
        ->get()->toArray();
    }

    /**
     * Get all of the distinct classifications in the collection table.
     *
     * 
     * @return array
     */
    public function getSpecies()
    {
        return DB::table('taxonomies')
        ->where('rank_id', '=', 13)
        ->orderBy('taxon_name', 'asc')
        ->get()->toArray();
    }

}