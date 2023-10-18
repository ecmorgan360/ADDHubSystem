<?php
 
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
 
class UserRepository
{

    /**
     * Get all users.
     *
     * 
     * @return array
     */
    public function getRoleUsers()
    {
        return DB::table('users')
        ->select('users.id', 'users.name')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->distinct()
        ->orderBy('users.name', 'asc')
        ->get();
    }

    /**
     * Get all of the extractors.
     *
     * 
     * @return array
     */
    public function getExtractUsers()
    {
        return DB::table('users')
        ->select('users.id', 'users.name')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->join('roles', 'roles.id', '=', 'role_users.role_id')
        ->where('roles.role', '=', config('global.role_extract'))
        ->orderBy('users.name', 'asc')
        ->get();
    }

    /**
     * Get all of the fractionators.
     *
     * 
     * @return array
     */
    public function getFractionUsers()
    {
        return DB::table('users')
        ->select('users.id', 'users.name')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->join('roles', 'roles.id', '=', 'role_users.role_id')
        ->where('roles.role', '=', config('global.role_fraction'))
        ->orderBy('users.name', 'asc')
        ->get();
    }

    /**
     * Get all of the fractionators.
     *
     * 
     * @return array
     */
    public function getIdentifiers()
    {
        return DB::table('users')
        ->select('users.id', 'users.name')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->join('roles', 'roles.id', '=', 'role_users.role_id')
        ->where('roles.role', '=', config('global.role_identify'))
        ->orderBy('users.name', 'asc')
        ->get();
    }

    /**
     * Get all of the fractionators.
     *
     * 
     * @return array
     */
    public function getCollectors()
    {
        return DB::table('users')
        ->select('users.id', 'users.name')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->join('roles', 'roles.id', '=', 'role_users.role_id')
        ->where('roles.role', '=', config('global.role_collect'))
        ->orderBy('users.name', 'asc')
        ->get();
    }

    /**
     * Get all users
     *
     * 
     * @return array
     */
    public function getUsers()
    {
        return DB::table('users')
        ->select('users.id', 'users.name')
        ->distinct()
        ->get();
    }

}