<?php
 
namespace App\Repositories;

use App\Models\Strain;
 
class StrainRepository
{
    /**
     * Get all of the distinct cultivation media in the strain table.
     *
     * 
     * @return array
     */
    public function getMedias()
    {
        return Strain::select('cultivation_media')->distinct()->pluck('cultivation_media');
    }

}