<?php
 
namespace App\Repositories;

use App\Models\Process;
use Illuminate\Support\Facades\DB;
 
class GenomicsRepository
{

    /**
     * Get all details of processes associated with process ID
     *
     * 
     * @return array
     */
    public function getGen16sDetails(String $sample_id)
    {
        return DB::table('gen16sraws')
        ->where('supplier_id', '=', $sample_id)
        ->select('gen16s_id',
        'supplier_id AS Supplier ID',
        'created_at AS Date Created',
        'updated_at AS Last Updated',
        'link_forward AS Link Forward',
        'link_reverse AS Link Reverse')
        ->get();
    }

    public function getMetagenomeDetails(String $sample_id)
    {
        return DB::table('metagenomeraw')
        ->where('supplier_id', '=', $sample_id)
        ->select('metagenome_id',
        'created_at AS Date Created',
        'updated_at AS Last Updated',
        'supplier_id AS Supplier ID',
        'link_bam AS Link BAM')
        ->get();
    }
    
}