<?php
 
namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
 
class RoleRepository
{
    /**
     * Get all of the distinct roles in the roles table.
     *
     * 
     * @return array
     */
    public function getRoles()
    {
        return DB::table('roles')
        ->select('id', 'role')
        ->distinct()
        ->get();
    }

    /**
     * Get all of the distinct classifications in the collection table.
     *
     * 
     * @return array
     */
    public function getAssignedRoles()
    {
        return DB::table('role_users')
        ->join('users', 'role_users.user_id', '=', 'users.id')
        ->join('roles', 'role_users.role_id', '=', 'roles.id')
        ->orderBy('users.name', 'asc')
        ->select('role_users.id',
        'users.name AS User Name',
        'roles.role AS Role Name')
        ->get();
    }

}