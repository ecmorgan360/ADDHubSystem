<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Derivedpurecomp;
use App\Repositories\DerivedpurecompRepository;
use App\Repositories\ExtractRepository;
use App\Repositories\FractionRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DerivedpurecompformController extends Controller
{

    /**
     * The derived pure compounds repository instance.
     *
     * @var DerivedpurecompRepository
     */
    protected $deriveds;

    /**
     * The fraction repository instance.
     *
     * @var FractionRepository
     */
    protected $fractions;

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
     * @param FractionRepository
     * @param ExtractRepository
     * @param GroupRepository
     * @param UserRepository
     * @return void
     */
    public function __construct(DerivedpurecompRepository $deriveds, FractionRepository $fractions, ExtractRepository $extracts, GroupRepository $groups, UserRepository $users)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

        $this->deriveds = $deriveds;
        $this->fractions = $fractions;
        $this->extracts = $extracts;
        $this->groups = $groups;
        $this->users = $users;

    }

    /**
     * Display the main fraction form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->edit($request, new Derivedpurecomp());

        // return view('derivedpurecompform', [
        //     'extractNames' => $this->extracts->getNames(),
        //     'fractionNames' => $this->fractions->getNames(),
        //     'derivedNames' => $this->deriveds->getNames(),
        //     'solvents' => $this->deriveds->getSolvents(),
        //     'solublelist' => $this->deriveds->getSolubilities(),
        //     'groups' => $this->groups->allGroups(),
        //     'fractionators' => $this->users->getFractionUsers(),
        // ]);
    }

    /**
     * Display the main extract form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, Derivedpurecomp $derivedpurecomp)
    {
        return view('derivedpurecompform', [
            'extractNames' => $this->extracts->getNames(),
            'fractionNames' => $this->fractions->getNames(),
            'derivedNames' => $this->deriveds->getNames(),
            'solvents' => $this->deriveds->getSolvents(),
            'solublelist' => $this->deriveds->getSolubilities(),
            'groups' => $this->groups->allGroups(),
            'fractionators' => $this->users->getFractionUsers(),
        ])->withDerivedpurecomp($derivedpurecomp);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'derived_name' => 'required|unique:derivedpurecomps,derivedpurecomp_id|max:255',
        ]);

        $derived = new Derivedpurecomp;
        $derived->derivedpurecomp_id = $request->derived_name;
        $derived->date_sample_submitted = $request->date_submitted;
        $derived->amount_available = $request->amount_derived;
        $derived->researchgroup_id = $request->group_name;
        $derived->submitter_id = Auth::user()->id;
        $derived->source_id = $request->source_derived;
        $derived->solvent_used = $request->solvents_derived;
        $derived->solubility = $request->solubility_derived;
        $derived->synthesis_potential = $request->has('synthesis_derived');
        $derived->ms = 0;
        $derived->nmr = 0;
        $derived->stereo_comments = $request->stereo_derived;
        $derived->smile_structure = $request->smile_derived;
        $derived->mw = $request->mw_derived;
        $derived->additional_metadata = $request->has('metadata_derived');
        $derived->existing_patent = $request->has('patent_derived');

        $derived->existing_literature = $request->has('lit_derived');
        if ($derived->existing_literature == 1) {
            $derived->literature_link = $request->lit_source;
        }
        $derived->comments = $request->comment_derived;

        $derived->save();

        return redirect()->action([DerivedpurecompformController::class, 'index']);

    }

    public function update(Request $request, Derivedpurecomp $derivedpurecomp) 
    {

        if ($request->derived_name == $derivedpurecomp->derivedpurecomp_id) {
            $derivedpurecomp->derivedpurecomp_id = $request->derived_name;
            $derivedpurecomp->date_sample_submitted = $request->date_submitted;
            $derivedpurecomp->amount_available = $request->amount_derived;
            $derivedpurecomp->researchgroup_id = $request->group_name;
            //$derivedpurecomp->submitter_id = Auth::user()->id;
            $derivedpurecomp->source_id = $request->source_derived;
            $derivedpurecomp->solvent_used = $request->solvents_derived;
            $derivedpurecomp->solubility = $request->solubility_derived;
            $derivedpurecomp->synthesis_potential = $request->has('synthesis_derived');
            $derivedpurecomp->ms = 0;
            $derivedpurecomp->nmr = 0;
            $derivedpurecomp->stereo_comments = $request->stereo_derived;
            $derivedpurecomp->smile_structure = $request->smile_derived;
            $derivedpurecomp->mw = $request->mw_derived;
            $derivedpurecomp->additional_metadata = $request->has('metadata_derived');
            $derivedpurecomp->existing_patent = $request->has('patent_derived');
            $derivedpurecomp->existing_literature = $request->has('lit_derived');
            if ($derivedpurecomp->existing_literature == 1) {
                $derivedpurecomp->literature_link = $request->lit_source;
            }
            else {
                $derivedpurecomp->literature_link = NULL;
            }
            $derivedpurecomp->comments = $request->comment_derived;

            $derivedpurecomp->save();

            return redirect()->action([SearchController::class, 'index']);
        }
        else if (Derivedpurecomp::where('derivedpurecomp_id', '=', $request->derived_name)->exists()) {
            throw ValidationException::withMessages(['derivedpurecomp_name' => 'This record exists. Please edit it or specify a different derived pure compound name.']);
        }
        else {
            $derivedpurecomp->derivedpurecomp_id = $request->derived_name;
            $derivedpurecomp->date_sample_submitted = $request->date_submitted;
            $derivedpurecomp->amount_available = $request->amount_derived;
            $derivedpurecomp->researchgroup_id = $request->group_name;
            //$derivedpurecomp->submitter_id = Auth::user()->id;
            $derivedpurecomp->source_id = $request->source_derived;
            $derivedpurecomp->solvent_used = $request->solvents_derived;
            $derivedpurecomp->solubility = $request->solubility_derived;
            $derivedpurecomp->synthesis_potential = $request->has('synthesis_derived');
            $derivedpurecomp->ms = 0;
            $derivedpurecomp->nmr = 0;
            $derivedpurecomp->stereo_comments = $request->stereo_derived;
            $derivedpurecomp->smile_structure = $request->smile_derived;
            $derivedpurecomp->mw = $request->mw_derived;
            $derivedpurecomp->additional_metadata = $request->has('metadata_derived');
            $derivedpurecomp->existing_patent = $request->has('patent_derived');
            $derivedpurecomp->existing_literature = $request->has('lit_derived');
            if ($derivedpurecomp->existing_literature == 1) {
                $derivedpurecomp->literature_link = $request->lit_source;
            }
            else {
                $derivedpurecomp->literature_link = NULL;
            }
            $derivedpurecomp->comments = $request->comment_derived;

            $derivedpurecomp->save();

            return redirect()->action([SearchController::class, 'index']);
        }
    }


}
