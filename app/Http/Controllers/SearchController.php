<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SearchRepository;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;

class SearchController extends Controller
{

     /**
     * The task repository instance.
     *
     * @var SearchRepository
     */
    protected $results;

    /**
     * The task repository instance.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * The task repository instance.
     *
     * @var GroupRepository
     */
    protected $groups;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SearchRepository $results, UserRepository $users, GroupRepository $groups)
    {
        $this->middleware('auth');

        $this->results = $results;
        $this->users = $users;
        $this->groups = $groups;
    }

    /**
     * Display the main search page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        // dd($request);
        if (($request->process) == "extracts")
            $res = $this->results->allExtracts($request)->paginate(50)->withQueryString();
        
        else if (($request->process) == "fractions")
            $res = $this->results->allFractions($request)->paginate(50)->withQueryString();

        else if (($request->process) == "purecompounds")
            $res = $this->results->allPurecomps($request)->paginate(50)->withQueryString();
        else
            $res = $this->results;
        // dd($request);
        return view('search', [
            'results' => $res,
            'submitters' => $this->users->getRoleUsers(),
            'groups' => $this->groups->allGroups(),
        ]);
    }

    /**
     * Display the main search page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function result(Request $request)
    {

        if (($request->process) == "extracts")
            $res = $this->results->allExtracts($request)->paginate(50)->withQueryString();
        
        else if (($request->process) == "fractions")
            $res = $this->results->allFractions($request)->paginate(50)->withQueryString();

        else if (($request->process) == "purecompounds")
            $res = $this->results->allPurecomps($request)->paginate(50)->withQueryString();

        return view('search', [
            'results' => $res,
            'submitters' => $this->users->getRoleUsers(),
            'groups' => $this->groups->allGroups(),
        ]);

    }
}
