<?php
 
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
 
class ReportRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * 
     * @return array
     */
    public function getOrphanFractions(Request $request)
    {
        $query = DB::table('fractions as start_frac')
        ->leftJoin('fractions as supp_frac', 'start_frac.source_id', '=', 'supp_frac.fraction_id')
        ->leftJoin('extracts', 'start_frac.source_id', '=', 'extracts.extract_id')
        ->join('groups', 'start_frac.researchgroup_id', '=', 'groups.group_id')
        ->join('users', 'start_frac.submitter_id', '=', 'users.id')
        ->where('supp_frac.fraction_id', '=', NULL)
        ->where('extracts.extract_id', '=', NULL)
        ->select('start_frac.fraction_id AS Fraction ID',
        'start_frac.created_at AS Created At',
        'start_frac.updated_at AS Updated At',
        'start_frac.date_sample_submitted AS Date Sample Submitted',
        'start_frac.amount_available AS Amount Available',
        'start_frac.sample_type AS Sample Type',
        'start_frac.concentration AS Concentration',
        'start_frac.project AS Project',
        'start_frac.source_id AS Source ID',
        'groups.group_name AS Group Name',
        'users.name AS Submitted By',
        'start_frac.solvent_used AS Solvent Used',
        'start_frac.comments AS Comments');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('start_frac.updated_at', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('start_frac.updated_at',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('start_frac.updated_at',  $request->end_date);
        }

        return $query->get();
    }

    /**
     * Get all of the tasks for a given user.
     *
     * 
     * @return array
     */
    public function getOrphanCompounds(Request $request)
    {
        $query = DB::table('derivedpurecomps')
        ->leftJoin('fractions', 'derivedpurecomps.source_id', '=', 'fractions.fraction_id')
        ->leftJoin('extracts', 'derivedpurecomps.source_id', '=', 'extracts.extract_id')
        ->join('groups', 'derivedpurecomps.researchgroup_id', '=', 'groups.group_id')
        ->join('users', 'derivedpurecomps.submitter_id', '=', 'users.id')
        ->where('fractions.fraction_id', '=', NULL)
        ->where('extracts.extract_id', '=', NULL)
        ->select('derivedpurecomps.derivedpurecomp_id AS Fraction ID',
        'derivedpurecomps.created_at AS Created At',
        'derivedpurecomps.updated_at AS Updated At',
        'derivedpurecomps.date_sample_submitted AS Date Sample Submitted',
        'derivedpurecomps.synthesis_potential AS Synthesis Potential',
        'derivedpurecomps.amount_available AS Amount Available',
        'derivedpurecomps.source_id AS Source ID',
        'groups.group_name AS Group Name',
        'users.name AS Submitted By',
        'derivedpurecomps.solubility AS Solubility',
        'derivedpurecomps.stereo_comments AS Stereo Comments',
        'derivedpurecomps.smile_structure AS SMILE Structure',
        'derivedpurecomps.mw AS Molecular Weight',
        'derivedpurecomps.existing_patent AS Existing Patent',
        'derivedpurecomps.existing_literature AS Existing Literature',
        'derivedpurecomps.literature_link AS Literature Link',
        'derivedpurecomps.solvent_used AS Solvents Used',
        'derivedpurecomps.comments AS Comments');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('derivedpurecomps.updated_at', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('derivedpurecomps.updated_at',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('derivedpurecomps.updated_at',  $request->end_date);
        }

        return $query->get();
    }

    public function getBioassayReports(Request $request)
    {
        $query =  DB::table('bioassays')
        ->join('groups', 'bioassays.responsible_pi_id', '=', 'groups.group_id')
        ->join('users', 'bioassays.researcher_id', '=', 'users.id')
        ->orderBy('date_received', 'desc')
        ->select('bioassays.process_id AS Process ID',
        'bioassays.created_at AS Created At',
        'bioassays.updated_at AS Updated At',
        'groups.group_name AS Responsible PI',
        'users.name AS Researcher',
        'bioassays.date_received AS Date Received',
        'bioassays.molecular_id AS Molecular ID',
        'bioassays.diluent AS Diluent',
        'bioassays.concentration AS Concentration',
        'bioassays.amount AS Amount',
        'bioassays.ecoli_v AS E. coli Viability',
        'bioassays.ecoli_sd AS E. coli Standard Deviation',
        'bioassays.saureus_v AS S. aureus Viability',
        'bioassays.saureus_sd AS S. aureus Standard Deviation',
        'bioassays.pareu_v AS P. areuginosa Viability',
        'bioassays.pareu_sd AS P. areuginosa Standard Deviation',
        'bioassays.saureus_bio_v AS S. aureus Biofilm Viability',
        'bioassays.saureus_bio_sd AS S. aureus Biofilm Standard Deviation',
        'bioassays.pareu_bio_v AS P. areuginosa Biofilm Viability',
        'bioassays.pareu_bio_sd AS P. areuginosa Biofilm Standard Deviation',
        'bioassays.cytotox_v AS Cytotox Viability',
        'bioassays.cytotox_sd AS Cytotox Standard Deviation',
        'bioassays.pk_activity AS PK Activity',
        'bioassays.dxr_activity AS DXR Activity',
        'bioassays.confirm_dxr_activity AS Confirm DXR Activity',
        'bioassays.hppk_activity AS HPPK Activity',
        'bioassays.cancelled',
        'bioassays.pk_requested AS PK Requested');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('bioassays.date_received', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('bioassays.date_received',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('bioassays.date_received',  $request->end_date);
        }

        return $query;
    }

}