<?php
 
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Massspec;
 
class MassspecRepository
{
    /**
     * Get all of the distinct solvents in the extract table.
     *
     * 
     * @return array
     */
    public function getMgfs(String $massspecid)
    {
        return DB::table('massspecmgfs')
        ->where('massspec_id', '=', $massspecid)
        ->select('mgf_id',
        'massspec_id AS MS ID',
        'created_at AS Date Created',
        'updated_at AS Last Updated',
        'link_mgf AS MGF File')
        ->get();
    }

    /**
     * Get all of the distinct solvents in the extract table.
     *
     * 
     * @return array
     */
    public function getCsvs(String $massspecid)
    {
        return DB::table('massspeccsvs')
        ->where('massspec_id', '=', $massspecid)
        ->select('csv_id',
        'massspec_id AS MS ID',
        'created_at AS Date Created',
        'updated_at AS Last Updated',
        'link_csv AS CSV/TSV File')
        ->get();
    }

}