<?php
 
namespace App\Repositories;

use App\Models\Derivedpurecomp;
 
class DerivedpurecompRepository
{
    /**
     * Get all of the distinct solvents in the fraction table.
     *
     * 
     * @return array
     */
    public function getSolvents()
    {
        return Derivedpurecomp::select('solvent_used')->distinct()->pluck('solvent_used');
    }

    /**
     * Get all of the distinct solvents in the fraction table.
     *
     * 
     * @return array
     */
    public function getSolubilities()
    {
        return Derivedpurecomp::select('solubility')->distinct()->pluck('solubility');
    }

    /**
     * Get all fraction names.
     *
     * 
     * @return array
     */
    public function getNames()
    {
        return Derivedpurecomp::pluck('derivedpurecomp_id');
    }

}