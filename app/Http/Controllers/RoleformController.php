<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Roleuser;

class RoleformController extends Controller
{
    /**
     * The taxonomy repository instance.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * The taxonomy repository instance.
     *
     * @var RoleUserRepository
     */
    protected $roles;

    /**
     * Create a new controller instance.
     * @param ProcessRepository
     * @return void
     */
    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->users = $users;
        $this->roles = $roles;
    }

    public function index(Request $request)
    {
        return view('roleform', [
            'roles' => $this->roles->getRoles(),
            'users' => $this->users->getUsers(),
            'assignedRoles' => $this->roles->getAssignedRoles(),
        ]);
    }

    public function store(Request $request)
    {

        $roleuser = DB::table('role_users')
        ->where('user_id', '=', $request->user_assign)
        ->where('role_id', '=', $request->role_assign)
        ->first();

        if ($roleuser != NULL) {
            throw ValidationException::withMessages(['user_name' => 'The user already has this role.']);
        }

        $role_user = new Roleuser();
        $role_user->role_id = $request->role_assign;
        $role_user->user_id = $request->user_assign;

        $role_user->save();

        return redirect()->action([RoleformController::class, 'index']);

    }

    public function remove(Request $request, Roleuser $roleuser)
    {
        $roleuser->delete();
        return redirect()->action([RoleformController::class, 'index']);
    }
}
