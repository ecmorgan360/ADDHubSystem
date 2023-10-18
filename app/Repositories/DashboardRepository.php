<?php
 
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
 
class DashboardRepository
{
    /**
     * Get all of the distinct classifications in the collection table.
     *
     * 
     * @return array
     */
    public function getAssignerExtracts(Request $request)
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
        'extracts.source_id AS Source ID', 
        'extracts.source_type AS Source Type',
        'extracts.solvent_extraction AS Solvent Used');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('extracts.date_sample_submitted', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('extracts.date_sample_submitted',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('extracts.date_sample_submitted',  $request->end_date);
        }

        $query->leftJoin('processes', 'processes.supplier_id', '=', 'extracts.extract_id')
        ->where('processes.process_id', '=', NULL)
        ->addSelect('processes.process_id AS Process Extract ID');

        $query->addSelect('users.id AS submitter_extract');

        return $query->get();
    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function getAssignerFractions(Request $request)
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

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('fractions.date_sample_submitted', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('fractions.date_sample_submitted',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('fractions.date_sample_submitted',  $request->end_date);
        }

        $query->leftJoin('processes', 'processes.supplier_id', '=', 'fractions.fraction_id')
        ->where('processes.process_id', '=', NULL)
        ->addSelect('processes.process_id AS Process Fraction ID');

        $query->addSelect('users.id AS submitter_fraction');

        return $query->get();

    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function getAssignerPurecomps(Request $request)
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

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('derivedpurecomps.date_sample_submitted', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('derivedpurecomps.date_sample_submitted',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('derivedpurecomps.date_sample_submitted',  $request->end_date);
        }

        $query->leftJoin('processes', 'processes.supplier_id', '=', 'derivedpurecomps.derivedpurecomp_id')
        ->where('processes.process_id', '=', NULL)
        ->addSelect('processes.process_id AS Process Compound ID');

        $query->addSelect('users.id AS submitter_derivedpurecomp');

        return $query->get();
    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function getBioassayProcesses(Request $request)
    {
        $query = DB::table('processes')
        ->leftJoin('bioassays', 'processes.process_id', '=', 'bioassays.process_id')
        ->join('users', 'processes.assigner_id', '=', 'users.id')
        ->where('bioassays.cancelled', '=', False)
        ->where('bioassays.responsible_pi_id', '=', NULL)
        ->select('processes.process_id AS Process ID',
        'processes.supplier_id AS Supplier ID',
        'users.name AS Assigner Name',
        'processes.date_assigned AS Date Assigned',
        'processes.sample_level AS Sample Level',
        'bioassays.pk_requested AS PK Requested');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('processes.date_assigned', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('processes.date_assigned',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('processes.date_assigned',  $request->end_date);
        }

        return $query->get();
    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function getMassspecProcesses(Request $request)
    {
        $query = DB::table('processes')
        ->leftJoin('massspecs', 'processes.process_id', '=', 'massspecs.process_id')
        ->join('users', 'processes.assigner_id', '=', 'users.id')
        ->where('massspecs.cancelled', '=', False)
        ->where('massspecs.date_submitted', '=', NULL)
        ->select('processes.process_id AS Process ID',
        'processes.supplier_id AS Supplier ID',
        'users.name AS Assigner Name',
        'processes.date_assigned AS Date Assigned',
        'processes.sample_level AS Sample Level',
        'massspecs.massspec_id AS MS ID');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('processes.date_assigned', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('processes.date_assigned',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('processes.date_assigned',  $request->end_date);
        }

        return $query->get();
    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function getNmrProcesses(Request $request)
    {
        $query = DB::table('processes')
        ->leftJoin('nmrs', 'processes.process_id', '=', 'nmrs.process_id')
        ->join('users', 'processes.assigner_id', '=', 'users.id')
        ->where('nmrs.cancelled', '=', False)
        ->where('nmrs.date_submitted', '=', NULL)
        ->select('processes.process_id AS Process ID',
        'processes.supplier_id AS Supplier ID',
        'users.name AS Assigner Name',
        'processes.date_assigned AS Date Assigned',
        'processes.sample_level AS Sample Level',
        'nmrs.nmr_id AS NMR ID');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('processes.date_assigned', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('processes.date_assigned',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('processes.date_assigned',  $request->end_date);
        }

        return $query->get();
    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function getHplcProcesses(Request $request)
    {
        $query = DB::table('processes')
        ->leftJoin('hplcrequests', 'hplcrequests.process_id', '=', 'processes.process_id')
        ->leftJoin('hplc_processes', 'hplc_processes.process_id', '=', 'hplcrequests.process_id')
        ->join('users', 'processes.assigner_id', '=', 'users.id')
        ->where('hplcrequests.cancelled', '=', False)
        ->where('hplc_processes.hplc_id', '=', NULL)
        ->select('processes.process_id AS Process ID',
        'processes.supplier_id AS Supplier ID',
        'users.name AS Assigner Name',
        'processes.date_assigned AS Date Assigned',
        'processes.sample_level AS Sample Level');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('hplcrequests.date_requested', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('hplcrequests.date_requested',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('hplcrequests.date_requested',  $request->end_date);
        }

        return $query->get();
    }

    /**
     * Get all of the fraction records
     *
     * 
     * @return Collection
     */
    public function getCollections(Request $request)
    {
        $query = DB::table('collections')
        ->join('users', 'collections.identifier_id', '=', 'users.id')
        ->leftjoin('extracts', 'collections.sample_id', '=', 'extracts.source_id' )
        ->leftjoin('sites', 'collections.site_id', '=', 'sites.site_id')
        ->leftjoin('stations', 'sites.site_id', '=', 'stations.station_id')
        ->where('extracts.source_id', '=', NULL)
        ->select('collections.sample_id AS Sample ID',
        'collections.date_collected AS Date Collected',
        'stations.station_name AS Station Name',
        'sites.latitude AS Latitude',
        'sites.longitude AS Longitude',
        'sites.depth_min AS Depth Min',
        'sites.depth_max AS Depth Max',
        'collections.classification AS Classification',
        'collections.other_description AS Other Description',
        'collections.permit_no AS Permit No.');

        if ($request->start_date != NULL AND $request->end_date != NULL) {
            $query->whereBetween('collections.date_collected', [$request->start_date, $request->end_date]);
        }
        else if ($request->start_date != NULL) {
            $query->where('collections.date_collected',  $request->start_date);
        }
        else if ($request->end_date != NULL) {
            $query->where('collections.date_collected',  $request->end_date);
        }

        return $query->get();
    }


}