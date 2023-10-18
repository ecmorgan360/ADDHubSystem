<?php
 
namespace App\Repositories;

use App\Models\Bioassay;
 
class BioassayRepository
{
    /**
     * Get all of the distinct solvents in the fraction table.
     *
     * 
     * @return array
     */
    public function getDiluents()
    {
        return Bioassay::select('diluent')->distinct()->orderBy('diluent', 'asc')->pluck('diluent');
    }
    
    
    /**
     * Get all of the distinct concentrations in the fraction table.
     *
     * 
     * @return array
     */
    public function getConcentrations()
    {
        return Bioassay::select('concentration')->distinct()->orderBy('concentration', 'asc')->pluck('concentration');
    }

}