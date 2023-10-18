<?php
 
namespace App\Repositories;

use App\Models\Extract;
 
class ExtractRepository
{
    /**
     * Get all of the distinct solvents in the extract table.
     *
     * 
     * @return array
     */
    public function getSolvents()
    {
        return Extract::select('solvent_extraction')->distinct()->pluck('solvent_extraction');
    }

    /**
     * Get all of the distinct source types in the extract table.
     *
     * 
     * @return array
     */
    public function getSourcetypes()
    {
        return Extract::select('source_type')->distinct()->pluck('source_type');
    }

    /**
     * Get all extract names.
     *
     * 
     * @return array
     */
    public function getNames()
    {
        return Extract::pluck('extract_id');
    }
}