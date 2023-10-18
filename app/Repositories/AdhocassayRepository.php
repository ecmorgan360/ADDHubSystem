<?php
 
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Adhocassay;
 
class AdhocassayRepository
{
    /**
     * Get all of the distinct solvents in the extract table.
     *
     * 
     * @return array
     */
    public function getAdhocs(String $derivedpurecompid)
    {
        return DB::table('adhocassays')
        ->where('pure_comp_id', '=', $derivedpurecompid)
        ->select('adhoc_id',
        'pure_comp_id AS Pure Compound ID',
        'created_at AS Date Created',
        'updated_at AS Last Updated',
        'adhoc_type AS Ad-hoc Assay Type',
        'link_report')
        ->get();
    }

    /**
     * Get all of the distinct solvents in the fraction table.
     *
     * 
     * @return array
     */
    public function getTypes()
    {
        return Adhocassay::select('adhoc_type')->distinct()->pluck('adhoc_type');
    }

}