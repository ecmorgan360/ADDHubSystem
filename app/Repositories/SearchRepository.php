<?php
 
namespace App\Repositories;

use App\Models\Extract;
use App\Models\Fraction;
use App\Models\Derivedpurecomp;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
 
class SearchRepository
{
    /**
     * Get all of the extract records
     *
     * 
     * @return Collection
     */
    public function allExtracts(Request $request)
    {
        $query = DB::table('extracts')
        ->join('groups', 'extracts.researchgroup_id', '=', 'groups.group_id')
        ->join('users', 'extracts.submitter_id', '=', 'users.id')
        ->orderBy('date_sample_submitted', 'asc')
        ->select('extracts.extract_id AS Extract ID', 
        'extracts.date_sample_submitted AS Date Submitted', 
        'extracts.amount_available AS Amount Available (mg)', 
        'groups.group_name AS Research Group',
        'users.name AS Submitter Name',
        'extracts.existing_literature AS Existing Literature', 
        'extracts.literature_link AS Literature Link', 
        'extracts.source_id AS Source of Extract', 
        'extracts.source_type AS Source Type',
        'extracts.solvent_extraction AS Solvent Used');

        if ($request->submitter_name != NULL) {
            $query->whereIn('extracts.submitter_id', $request->submitter_name);           
        }

        if ($request->group_name != NULL) {
            $query->whereIn('extracts.researchgroup_id', $request->group_name);           
        }

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('extracts.date_sample_submitted', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('extracts.date_sample_submitted',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('extracts.date_sample_submitted',  $request->end_date);
        }

        if ($request->has('proc_check')) {
            $query->leftJoin('processes', 'processes.supplier_id', '=', 'extracts.extract_id')->addSelect('processes.process_id AS Process Extract ID');
        }

        $query->addSelect('users.id AS submitter_extract');

        return $query;

    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function allFractions(Request $request)
    {
        // return Fraction::orderBy('date_sample_submitted', 'asc')->get()->makeHidden(['created_at','updated_at' ]);
        $query = DB::table('fractions')
        ->join('groups', 'fractions.researchgroup_id', '=', 'groups.group_id')
        ->join('users', 'fractions.submitter_id', '=', 'users.id')
        ->orderBy('date_sample_submitted', 'asc')
        ->select('fractions.fraction_id AS Fraction ID', 
        'fractions.date_sample_submitted AS Date Submitted', 
        'fractions.amount_available AS Amount Available (mg)', 
        'groups.group_name AS Research Group',
        'users.name AS Submitter Name',
        'fractions.sample_type AS Sample Type',
        'fractions.concentration AS Concentration (mg/ml)',
        'fractions.project AS Project',
        'fractions.source_id AS Source of Fraction',
        'fractions.solvent_used AS Solvent Used',
        'fractions.comments AS Comments');
        
        if ($request->submitter_name != NULL) {
            $query->whereIn('fractions.submitter_id', $request->submitter_name);           
        }

        if ($request->group_name != NULL) {
            $query->whereIn('fractions.researchgroup_id', $request->group_name);           
        }

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('fractions.date_sample_submitted', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('fractions.date_sample_submitted',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('fractions.date_sample_submitted',  $request->end_date);
        }

        if ($request->has('proc_check')) {
            $query->leftJoin('processes', 'processes.supplier_id', '=', 'fractions.fraction_id')->addSelect('processes.process_id AS Process Fraction ID');
        }

        $query->addSelect('users.id AS submitter_fraction');

        return $query;

    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function allPurecomps(Request $request)
    {
        // return Derivedpurecomp::orderBy('date_sample_submitted', 'asc')->get()->makeHidden(['created_at','updated_at' ]);
        $query = DB::table('derivedpurecomps')
        ->join('groups', 'derivedpurecomps.researchgroup_id', '=', 'groups.group_id')
        ->join('users', 'derivedpurecomps.submitter_id', '=', 'users.id')
        ->orderBy('date_sample_submitted', 'asc')
        ->select('derivedpurecomps.derivedpurecomp_id AS Pure Compound ID', 
        'derivedpurecomps.date_sample_submitted AS Date Submitted', 
        'derivedpurecomps.amount_available AS Amount Available (mg)',
        'derivedpurecomps.synthesis_potential AS Synthesis Potential',
        'groups.group_name AS Research Group',
        'users.name AS Submitter Name',
        'derivedpurecomps.source_id AS Source of Pure Compound',
        'derivedpurecomps.solvent_used AS Solvent Used',
        'derivedpurecomps.solubility AS Solubility',
        'derivedpurecomps.stereo_comments AS Stereo Comments',
        'derivedpurecomps.smile_structure AS SMILE Structure',
        'derivedpurecomps.mw AS Molecular Weight',
        'derivedpurecomps.existing_patent AS Existing Patent',
        'derivedpurecomps.existing_literature AS Existing Literature',
        'derivedpurecomps.literature_link AS Literature Link',
        'derivedpurecomps.comments AS Comments');

        if ($request->submitter_name != NULL) {
            $query->whereIn('derivedpurecomps.submitter_id', $request->submitter_name);           
        }

        if ($request->group_name != NULL) {
            $query->whereIn('derivedpurecomps.researchgroup_id', $request->group_name);           
        }

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('derivedpurecomps.date_sample_submitted', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('derivedpurecomps.date_sample_submitted',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('derivedpurecomps.date_sample_submitted',  $request->end_date);
        }

        if ($request->has('proc_check')) {
            $query->leftJoin('processes', 'processes.supplier_id', '=', 'derivedpurecomps.derivedpurecomp_id')->addSelect('processes.process_id AS Process Compound ID');
        }

        $query->addSelect('users.id AS submitter_derivedpurecomp');

        return $query;
    }


    public function count()
    {
        return 0;
    }
}