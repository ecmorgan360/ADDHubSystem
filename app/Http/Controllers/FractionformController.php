<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fraction;
use App\Repositories\ExtractRepository;
use App\Repositories\FractionRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FractionformController extends Controller
{
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
    public function __construct(FractionRepository $fractions, ExtractRepository $extracts, GroupRepository $groups, UserRepository $users)
    {
        # Check user is logged in to be able to access
        $this->middleware('auth');

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
        return $this->edit($request, new Fraction());

        // return view('fractionform', [
        //     'extractNames' => $this->extracts->getNames(),
        //     'fractionNames' => $this->fractions->getNames(),
        //     'solvents' => $this->fractions->getSolvents(),
        //     'groups' => $this->groups->allGroups(),
        //     'fractionators' => $this->users->getFractionUsers(),
        //     'concentrations' => $this->fractions->getConcentrations(),
        //     'methods' =>$this->fractions->getSampletypes(),
        //     'projects' => $this->fractions->getProjects(),
        // ]);
    }

    /**
     * Display the main extract form page.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, Fraction $fraction)
    {
        return view('fractionform', [
            'extractNames' => $this->extracts->getNames(),
            'fractionNames' => $this->fractions->getNames(),
            'solvents' => $this->fractions->getSolvents(),
            'groups' => $this->groups->allGroups(),
            'fractionators' => $this->users->getFractionUsers(),
            'concentrations' => $this->fractions->getConcentrations(),
            'methods' =>$this->fractions->getSampletypes(),
            'projects' => $this->fractions->getProjects(),
        ])->withFraction($fraction);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fraction_name' => 'required|unique:fractions,fraction_id|max:255',
        ]);

        $fraction = new Fraction;
        $fraction->fraction_id = $request->fraction_name;
        $fraction->date_sample_submitted = $request->date_submitted;
        $fraction->amount_available = $request->amount_fraction;
        $fraction->researchgroup_id = $request->group_name;
        $fraction->project = $request->project_fraction;
        $fraction->submitter_id = Auth::user()->id;
        $fraction->source_id = $request->source_fraction;
        $fraction->solvent_used = $request->solvents_fractionation;
        $fraction->concentration = $request->concentration_fraction;
        $fraction->sample_type = $request->method_fraction;
        $fraction->comments = $request->comment_fraction;

        $fraction->save();

        return redirect()->action([FractionformController::class, 'index']);

    }

    public function update(Request $request, Fraction $fraction) 
    {
        if ($request->fraction_name == $fraction->fraction_id) {
            $fraction->fraction_id = $request->fraction_name;
            $fraction->date_sample_submitted = $request->date_submitted;
            $fraction->amount_available = $request->amount_fraction;
            $fraction->researchgroup_id = $request->group_name;
            $fraction->project = $request->project_fraction;
            //$fraction->submitter_id = Auth::user()->id;
            $fraction->source_id = $request->source_fraction;
            $fraction->solvent_used = $request->solvents_fractionation;
            $fraction->concentration = $request->concentration_fraction;
            $fraction->sample_type = $request->method_fraction;
            $fraction->comments = $request->comment_fraction;

            $fraction->save();

            return redirect()->action([SearchController::class, 'index']);
        }
        else if (Fraction::where('fraction_id', '=', $request->fraction_name)->exists()) {
            throw ValidationException::withMessages(['fraction_name' => 'This record exists. Please edit it or specify a different fraction name.']);
        }
        else {
            $fraction->fraction_id = $request->fraction_name;
            $fraction->date_sample_submitted = $request->date_submitted;
            $fraction->amount_available = $request->amount_fraction;
            $fraction->researchgroup_id = $request->group_name;
            $fraction->project = $request->project_fraction;
            //$fraction->submitter_id = Auth::user()->id;
            $fraction->source_id = $request->source_fraction;
            $fraction->solvent_used = $request->solvents_fractionation;
            $fraction->concentration = $request->concentration_fraction;
            $fraction->sample_type = $request->method_fraction;
            $fraction->comments = $request->comment_fraction;

            $fraction->save();

            return redirect()->action([SearchController::class, 'index']);
        }
    }
}