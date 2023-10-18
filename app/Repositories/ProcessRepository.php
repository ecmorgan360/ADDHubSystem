<?php
 
namespace App\Repositories;

use App\Models\Process;
use Illuminate\Support\Facades\DB;
 
class ProcessRepository
{
    /**
     * Get all of the process IDs.
     *
     * 
     * @return array
     */
    public function getProcessIDs()
    {
        return Process::select('process_id')->distinct()->pluck('process_id');
    }

    /**
     * Get largest AMR ID currently in db.
     *
     * 
     * @return array
     */
    public function getAmr()
    {
        return DB::table('processes')
        ->where('process_id', 'like', 'AMR%')
        ->orderBy('process_id', 'desc')
        ->first();
    }

    /**
     * Get largest MNP ID currently in db.
     *
     * 
     * @return array
     */
    public function getMnp()
    {
        return DB::table('processes')
        ->where('process_id', 'like', 'MNP%')
        ->orderBy('process_id', 'desc')
        ->first();
    }

    /**
     * Get all details of mass spec associate with process ID
     *
     * 
     * @return array
     */
    public function getMsDetails(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->leftJoin('massspecs', 'processes.process_id', '=', 'massspecs.process_id')
        ->select('processes.assigner_id',
        'massspecs.massspec_id',
        'massspecs.date_requested',
        'massspecs.cancelled',
        'massspecs.link_processed_spec',
        'massspecs.date_submitted')
        ->get();
    }

    /**
     * Get all details of processes associated with process ID
     *
     * 
     * @return array
     */
    public function getNmrDetails(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->leftJoin('nmrs', 'processes.process_id', '=', 'nmrs.process_id')
        ->select('processes.assigner_id',
        'nmrs.nmr_id',
        'nmrs.date_requested',
        'nmrs.cancelled',
        'nmrs.link_folder',
        'nmrs.date_submitted')
        ->get();
    }

    /**
     * Get all details of processes associated with process ID
     *
     * 
     * @return array
     */
    public function getBioassayDetails(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->leftJoin('bioassays', 'processes.process_id', '=', 'bioassays.process_id')
        ->leftJoin('groups', 'bioassays.responsible_pi_id', '=', 'groups.group_id')
        ->leftJoin('users', 'bioassays.researcher_id', '=', 'users.id')
        ->select('processes.process_id',
        'processes.date_assigned AS Date Assigned',
        'users.name AS Researcher Name',
        'groups.group_name AS Responsible PI',
        'processes.assigner_id',
        'bioassays.date_received AS Date Received',
        'bioassays.researcher_id AS submitter_bioassay', 
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
        'bioassays.pk_requested AS PK Requested')
        ->get();
    }

    /**
     * Get all details of processes associated with process ID
     *
     * 
     * @return array
     */
    public function getHplcDetails(String $process_id)
    {
        return DB::table('hplcrequests')
        ->where('hplcrequests.process_id', '=', $process_id)
        ->leftJoin('hplc_processes', 'hplc_processes.process_id', '=', 'hplcrequests.process_id')
        ->leftJoin('hplcs', 'hplcs.hplc_id', '=', 'hplc_processes.hplc_id')
        ->select('hplcrequests.process_id',
        'hplcrequests.date_requested',
        'hplcs.date_submitted',
        'hplcrequests.cancelled',
        'hplcs.diluent',
        'hplcs.hplc_id',
        'hplcs.link_uvtrace',
        'hplcs.link_report')
        ->get();
    }

    /**
     * Get details of process given
     *
     * 
     * @return array
     */
    public function getProcessDetails(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->join('users', 'processes.assigner_id', '=', 'users.id')
        ->select('processes.process_id AS Process ID',
        'processes.supplier_id AS Supplier ID',
        'users.name AS Assigner Name',
        'processes.date_assigned AS Date Assigned',
        'processes.sample_level AS Sample Level',
        'processes.assigner_id')
        ->get();
    }

    public function getMSProcess(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->leftjoin('massspecs', 'processes.process_id', '=', 'massspecs.process_id')
        ->select('massspecs.process_id')
        ->first();
    }

    public function getNMRProcess(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->leftjoin('nmrs', 'processes.process_id', '=', 'nmrs.process_id')
        ->select('nmrs.process_id')
        ->first();
    }

    public function getHplcProcess(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->leftjoin('hplcrequests', 'processes.process_id', '=', 'hplcrequests.process_id')
        ->select('hplcrequests.process_id')
        ->first();
    }

    public function getBioassayProcess(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->leftjoin('bioassays', 'processes.process_id', '=', 'bioassays.process_id')
        ->select('bioassays.process_id')
        ->first();
    }

    public function getPKProcess(String $process_id)
    {
        return DB::table('processes')
        ->where('processes.process_id', '=', $process_id)
        ->leftjoin('bioassays', 'processes.process_id', '=', 'bioassays.process_id')
        ->select('bioassays.pk_requested')
        ->first();
    }
    
}