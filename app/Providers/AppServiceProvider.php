<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Project;

use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return Collection
     */
    public function boot()
    {

        // View::share('roles', DB::table('users')
        //                         ->join('role_users', 'users.id', '=', 'role_users.user_id')
        //                         ->join('roles', 'role_users.role_id', '=', 'roles.id')
        //                         ->where('users.id', 2)
        //                         ->pluck('roles.role')
        //                         ->toArray());
    }
}
