<?php
 
namespace App\Repositories;

use App\Models\Group;
 
class GroupRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * 
     * @return array
     */
    public function allGroups()
    {
        return Group::orderBy('group_name', 'asc')->select('group_id', 'group_name')->get();
    }

}