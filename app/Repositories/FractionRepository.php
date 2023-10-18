<?php
 
namespace App\Repositories;

use App\Models\Fraction;
 
class FractionRepository
{
    /**
     * Get all of the distinct solvents in the fraction table.
     *
     * 
     * @return array
     */
    public function getSolvents()
    {
        return Fraction::select('solvent_used')->distinct()->pluck('solvent_used');
    }
    
    
    /**
     * Get all of the distinct concentrations in the fraction table.
     *
     * 
     * @return array
     */
    public function getConcentrations()
    {
        return Fraction::select('concentration')->distinct()->orderBy('concentration', 'asc')->pluck('concentration');
    }

    /**
     * Get all of the distinct fraction methods (sample types) in the fraction table.
     *
     * 
     * @return array
     */
    public function getSampletypes()
    {
        return Fraction::select('sample_type')->distinct()->orderBy('sample_type', 'asc')->pluck('sample_type');
    }

    /**
     * Get all of the distinct projects in the fraction table.
     *
     * 
     * @return array
     */
    public function getProjects()
    {
        return Fraction::select('project')->distinct()->orderBy('project', 'asc')->pluck('project');
    }

    /**
     * Get all fraction names.
     *
     * 
     * @return array
     */
    public function getNames()
    {
        return Fraction::pluck('fraction_id');
    }

}