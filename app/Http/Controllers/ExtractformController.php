<?php

namespace App\Http\Controllers;

use App\Models\Extract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ExtractRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ExtractformController extends Controller
{

    /**
     * The extract repository instance.
     *
     * @var ExtractRepository
     */
    protected $extracts;

    /**
     * The group repository instance.
     *
     * @var GroupRepository
     */
    protected $groups;

    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new controller instance.
     * @param ExtractRepository
     * @param GroupRepository
     * @param UserRepository
     * @return void
     */
    public function __construct(ExtractRepository $extracts, GroupRepository $groups, UserRepository $users)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->extracts = $extracts;
        $this->groups = $groups;
        $this->users = $users;

    }

    /**
     * Display the main extract form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {

        // return view('extractform', [
        //     'solvents' => $this->extracts->getSolvents(),
        //     'groups' => $this->groups->allGroups(),
        //     'extractors' => $this->users->getExtractUsers(),
        //     'sourcetypes' => $this->extracts->getSourcetypes(),
        // ]);

        return $this->edit($request, new Extract());
    }

    /**
     * Display the main extract form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, Extract $extract)
    {
        return view('extractform', [
            'solvents' => $this->extracts->getSolvents(),
            'groups' => $this->groups->allGroups(),
            'extractors' => $this->users->getExtractUsers(),
            'sourcetypes' => $this->extracts->getSourcetypes(),
        ])->withExtract($extract);
    }

    public function update(Request $request, Extract $extract) 
    {

        if ($request->extract_name == $extract->extract_id) {
            $extract->extract_id = $request->extract_name;
            $extract->date_sample_submitted = $request->date_submitted;
            $extract->amount_available = $request->amount_extract;
            $extract->ms = 0;
            $extract->nmr = 0;
            $extract->researchgroup_id = $request->group_name;
            // $extract->submitter_id = Auth::user()->id;
            $extract->existing_literature = $request->has('lit_extract');
            if ($extract->existing_literature == 1) {
                $extract->literature_link = $request->lit_source;
            }
            else {
                $extract->literature_link = NULL;
            }
            $extract->source_id = $request->source_extract;
            $extract->source_type = $request->type_source;
            $extract->solvent_extraction = $request->solvents_extraction;

            $extract->save();

            return redirect()->action([SearchController::class, 'index']);
        }
        else if (Extract::where('extract_id', '=', $request->extract_name)->exists()) {
            throw ValidationException::withMessages(['extract_name' => 'This record exists. Please edit it or specify a different extract name.']);
        }
        else {
            $extract->extract_id = $request->extract_name;
            $extract->date_sample_submitted = $request->date_submitted;
            $extract->amount_available = $request->amount_extract;
            $extract->ms = 0;
            $extract->nmr = 0;
            $extract->researchgroup_id = $request->group_name;
            //$extract->submitter_id = Auth::user()->id;
            $extract->existing_literature = $request->has('lit_extract');
            if ($extract->existing_literature == 1) {
                $extract->literature_link = $request->lit_source;
            }
            else {
                $extract->literature_link = NULL;
            }
            $extract->source_id = $request->source_extract;
            $extract->source_type = $request->type_source;
            $extract->solvent_extraction = $request->solvents_extraction;

            $extract->save();

            return redirect()->action([SearchController::class, 'index']);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'extract_name' => 'required|unique:extracts,extract_id|max:255',
        ]);

        $extract = new Extract;
        $extract->extract_id = $request->extract_name;
        $extract->date_sample_submitted = $request->date_submitted;
        $extract->amount_available = $request->amount_extract;
        $extract->ms = 0;
        $extract->nmr = 0;
        $extract->researchgroup_id = $request->group_name;
        $extract->submitter_id = Auth::user()->id;
        $extract->existing_literature = $request->has('lit_extract');
        if ($extract->existing_literature == 1) {
            $extract->literature_link = $request->lit_source;
        }
        $extract->source_id = $request->source_extract;
        $extract->source_type = $request->type_source;
        $extract->solvent_extraction = $request->solvents_extraction;

        $extract->save();

        return redirect()->action([ExtractformController::class, 'index']);

    }
}
