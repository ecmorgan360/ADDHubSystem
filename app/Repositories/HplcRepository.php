<?php
 
namespace App\Repositories;

use App\Models\Hplc;
use Illuminate\Support\Facades\DB;
 
class HplcRepository
{
    /**
     * Get all of the distinct solvents in the extract table.
     *
     * 
     * @return array
     */
    public function getDiluents()
    {
        return Hplc::select('diluent')->distinct()->pluck('diluent');
    }

    /**
     * Get all of the distinct solvents in the extract table.
     *
     * 
     * @return array
     */
    public function getRequested()
    {
        return DB::table('hplcrequests')
        ->leftJoin('hplc_processes', 'hplcrequests.process_id', '=', 'hplc_processes.process_id')
        ->where('hplc_processes.process_id', '=', NULL)
        ->select('hplcrequests.process_id')
        ->pluck('hplcrequests.process_id');
    }

}