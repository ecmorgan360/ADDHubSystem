<?php
 
namespace App\Repositories;

use App\Models\Collection;
use Illuminate\Support\Facades\DB;
 
class CollectionRepository
{
    /**
     * Get all of the distinct classifications in the collection table.
     *
     * 
     * @return array
     */
    public function getClassifications()
    {
        return Collection::select('classification')->distinct()->pluck('classification');
    }

    /**
     * Get all of the distinct permit numbers in the collection table.
     *
     * 
     * @return array
     */
    public function getPermits()
    {
        return Collection::select('permit_no')->distinct()->pluck('permit_no');
    }

    /**
     * Get all of the distinct permit numbers in the collection table.
     *
     * 
     * @return array
     */
    public function getCollection(String $supplier_id)
    {
        $query =  DB::table('collections')
        ->where('collections.sample_id', '=', $supplier_id)
        ->join('users as usersOne', 'collections.identifier_id', '=', 'usersOne.id')
        ->join('sites', 'collections.site_id', '=', 'sites.site_id')
        ->join('stations', 'sites.site_id', '=', 'stations.station_id')
        ->join('taxonomies', 'collections.taxonomy_id', '=', 'taxonomies.taxonomy_id')
        ->select('collections.sample_id AS Sample ID',
        'usersOne.name AS Identifier Name',
        'collections.date_collected AS Date Collected',
        'stations.station_name AS Station Name',
        'sites.latitude AS Latitude',
        'sites.longitude AS Longitude',
        'sites.depth_min AS Depth Min',
        'sites.depth_max AS Depth Max',
        'collections.classification AS Classification',
        'collections.other_description AS Other Description',
        'taxonomies.taxon_name AS Species Name',
        'collections.permit_no AS Permit No.');

        return $query->get();
    }

    public function getStrain(String $supplier_id)
    {
        $query =  DB::table('strains')
        ->where('strains.strain_id', '=', $supplier_id)
        ->join('taxonomies', 'strains.taxonomy_id', '=', 'taxonomies.taxonomy_id')
        ->select('strains.strain_id AS Strain ID',
        'strains.cultivation_media AS Cultivation Media',
        'taxonomies.taxon_name AS Species Name');

        return $query->get();
    }


    /**
     * Get all of the distinct permit numbers in the collection table.
     *
     * 
     * @return array
     */
    public function getCollectors(String $supplier_id)
    {
        $query =  DB::table('collections')
        ->where('collections.sample_id', '=', $supplier_id)
        ->join('collection_users', 'collections.sample_id', '=', 'collection_users.sample_id')
        ->join('users as usersTwo', 'collection_users.user_id', '=', 'usersTwo.id')
        ->select('usersTwo.name AS Collectors',
        'collection_users.user_id');

        return $query->get();
    }

    /**
     * Get all of the distinct permit numbers in the collection table.
     *
     * 
     * @return array
     */
    public function getCollectionCollectors(String $sample_id)
    {
        return DB::table('collections')
        ->where('collections.sample_id', '=', $sample_id)
        ->join('collection_users', 'collections.sample_id', '=', 'collection_users.sample_id')
        ->select('collection_users.user_id');

    }


}