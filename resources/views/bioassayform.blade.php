<x-app-layout>
<style>
.myalert {
  padding: 20px;
  background-color: #f44336;
  color: white;

}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

div.form-group {
    padding: 5px 20px;
}
select, input[type="text"], table{
    width:50%;
    box-sizing:border-box;
}
</style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bioassay Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($bioassay->exists)
                    @if ($bioassay->responsible_pi_id == NULL)
                    <form action="{{ route('bioassayform.store') }}" method="POST">
                    @else
                        <form action="{{ route('bioassayform.update', $bioassay) }}" method="POST">
                        @method('put')
                    @endif
                @else
                <form action="{{ route('bioassayform.store') }}" method="POST">
                @endif
                    @csrf

                    <!-- Process ID -->
                    <div class="form-group">
                        <label for="bioassay_process" class="col-sm-3 control-label">Process ID</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="bioassay_process" id="bioassay_process" class="form-control" value="{{ old('bioassay_process', $bioassay->process_id)}}" autofocus required>
                        </div>
                        <div class="myalert" id="myalert" style="display: none">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <strong>Danger!</strong> This source is not recorded yet.
                        </div>
                    </div>

                    <!-- Responsible PI -->
                    <div class="form-group">
                        <label for="group_name" class="col-sm-3 control-label">Responsible PI</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="group_name" id="group_name" class="form-control">
                                @foreach($groups as $group)
                                <option value="{{ $group->group_id }}" {{(old('group_name', $bioassay->responsible_pi_id) == $group->group_id) ? 'selected' : ''}}>{{ $group->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Date received -->
                    <div class="form-group">
                        <label for="date_received" class="col-sm-3 control-label">Date Bioassay Received</label>
        
                        <div class="col-sm-6">
                            <input type="date" name="date_received" id="date_received" class="form-control" value="{{ old('date_received', $bioassay->date_received)}}" required>
                        </div>
                    </div>

                    <!-- Molecular ID -->
                    <div class="form-group">
                        <label for="molecular_id" class="col-sm-3 text-gray-900">Molecular ID</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="molecular_id" id="molecular_id" class="form-control" value="{{ old('molecular_id', $bioassay->molecular_id)}}" required>
                        </div>
                    </div>

                    <!-- Diluent -->
                    <div class="form-group">
                        <label for="diluent_bioassay" class="col-sm-3 control-label">Diluent used</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="diluent_bioassay" list="diluent_bioassay" required value={{old('diluent_bioassay', $bioassay->diluent) }}>
                            <datalist id="diluent_bioassay">
                                @foreach($diluents as $diluent)
                                <option value="{{ $diluent }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Concentration -->
                    <div class="form-group">
                        <label for="concentration_bioassay" class="col-sm-3 control-label">Concentration (mg/ml)</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="concentration_bioassay" list="concentration_bioassay" required value={{old('concentration_bioassay', $bioassay->concentration) }}>
                            <datalist id="concentration_bioassay">
                                @foreach($concentrations as $concentration)
                                <option value="{{ $concentration }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount_bioassay" class="col-sm-3 control-label">Amount Available (mg)</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="amount_bioassay" id="amount_bioassay" class="form-control" value="{{ old('amount_bioassay', $bioassay->amount)}}" required>
                        </div>
                    </div>

                    <!-- E.coli -->
                    <div class="form-group">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <label for="ecoliv" class="col-sm-3 control-label">E. coli Viability</label>
                            </td>
                            <td>
                                <label for="ecolisd" class="col-sm-3 control-label" id="lbl_ecolisd" style="display: none">E. coli Standard Deviation</label>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                                <input type="text" name="ecoliv" id="ecoliv" class="form-control" value="{{ old('ecoliv', $bioassay->ecoli_v)}}">
                            </td>
                            <td>
                                <input type="text" name="ecolisd" id="ecolisd" class="form-control" value="{{ old('ecolisd', $bioassay->ecoli_v)}}" style="display: none">
                            </td>
                        </tr>     
                        </tbody>
                    </table>
                    </div>

                    <script>
                        let ecoliv = document.getElementById("ecoliv");
                        if (ecoliv.value === "") {
                            document.getElementById("ecolisd").style.display='none';
                            document.getElementById("ecolisd").required = false;
                            document.getElementById("lbl_ecolisd").style.display='none';
                        } else {
                            document.getElementById("ecolisd").style.display='inline-flex';
                            document.getElementById("ecolisd").required = true;
                            document.getElementById("lbl_ecolisd").style.display='inline-flex';
                        }

                        ecoliv.addEventListener("focusout", function() {
                            if (ecoliv.value === "") {
                                document.getElementById("ecolisd").style.display='none';
                                document.getElementById("ecolisd").required = false;
                                document.getElementById("lbl_ecolisd").style.display='none';
                            } else {
                                document.getElementById("ecolisd").style.display='inline-flex';
                                document.getElementById("ecolisd").required = true;
                                document.getElementById("lbl_ecolisd").style.display='inline-flex';
                            }
                        });
                    </script>

                    <!-- S.aureus -->
                    <div class="form-group">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                            <label for="saureusv" class="col-sm-3 control-label">S. aureus Viability</label>
                            </td>
                            <td>
                            <label for="saureussd" class="col-sm-3 control-label" id="lbl_saureussd" style="display: none">S. aureus Standard Deviation</label>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                            <input type="text" name="saureusv" id="saureusv" class="form-control" value="{{ old('saureusv', $bioassay->saureus_v)}}">
                            </td>
                            <td>
                            <input type="text" name="saureussd" id="saureussd" class="form-control" value="{{ old('saureussd', $bioassay->saureus_sd)}}" style="display: none">
                            </td>
                        </tr>     
                        </tbody>
                    </table>
                    </div>

                    <script>
                        let saureusv = document.getElementById("saureusv");
                        if (saureusv.value === "") {
                            document.getElementById("saureussd").style.display='none';
                            document.getElementById("saureussd").required = false;
                            document.getElementById("lbl_saureussd").style.display='none';
                        } else {
                            document.getElementById("saureussd").style.display='inline-flex';
                            document.getElementById("saureussd").required = true;
                            document.getElementById("lbl_saureussd").style.display='inline-flex';
                        }
                        saureusv.addEventListener("focusout", function() {
                            if (saureusv.value === "") {
                                document.getElementById("saureussd").style.display='none';
                                document.getElementById("saureussd").required = false;
                                document.getElementById("lbl_saureussd").style.display='none';
                            } else {
                                document.getElementById("saureussd").style.display='inline-flex';
                                document.getElementById("saureussd").required = true;
                                document.getElementById("lbl_saureussd").style.display='inline-flex';
                            }
                        });
                    </script>

                    <!-- P.areu -->
                    <div class="form-group">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                            <label for="pareuv" class="col-sm-3 control-label">P. areuginosa Viability</label>
                            </td>
                            <td>
                            <label for="pareusd" class="col-sm-3 control-label" id="lbl_pareusd" style="display: none">P. areuginosa Standard Deviation</label>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                            <input type="text" name="pareuv" id="pareuv" class="form-control" value="{{ old('pareuv', $bioassay->pareu_v)}}">
                            </td>
                            <td>
                            <input type="text" name="pareusd" id="pareusd" class="form-control" value="{{ old('pareusd', $bioassay->pareu_sd)}}" style="display: none">
                            </td>
                        </tr>     
                        </tbody>
                    </table>
                    </div>

                    <script>
                        let pareuv = document.getElementById("pareuv");
                        if (pareuv.value === "") {
                            document.getElementById("pareusd").style.display='none';
                            document.getElementById("pareusd").required = false;
                            document.getElementById("lbl_pareusd").style.display='none';
                        } else {
                            document.getElementById("pareusd").style.display='inline-flex';
                            document.getElementById("pareusd").required = true;
                            document.getElementById("lbl_pareusd").style.display='inline-flex';
                        }
                        pareuv.addEventListener("focusout", function() {
                            if (pareuv.value === "") {
                                document.getElementById("pareusd").style.display='none';
                                document.getElementById("pareusd").required = false;
                                document.getElementById("lbl_pareusd").style.display='none';
                            } else {
                                document.getElementById("pareusd").style.display='inline-flex';
                                document.getElementById("pareusd").required = true;
                                document.getElementById("lbl_pareusd").style.display='inline-flex';
                            }
                        });
                    </script>

                    <!-- S.aureus biofilm -->
                    <div class="form-group">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                            <label for="saureusbiov" class="col-sm-3 control-label">S. aureus Biofilm Integrity Viability</label>
                            </td>
                            <td>
                            <label for="saureusbiosd" class="col-sm-3 control-label" id="lbl_saureusbiosd" style="display: none">S. aureus Biofilm Integrity Standard Deviation</label>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                            <input type="text" name="saureusbiov" id="saureusbiov" class="form-control" value="{{ old('saureusbiov', $bioassay->saureus_bio_v)}}">
                            </td>
                            <td>
                            <input type="text" name="saureusbiosd" id="saureusbiosd" class="form-control" value="{{ old('saureusbiosd', $bioassay->saureus_bio_sd)}}" style="display: none">
                            </td>
                        </tr>     
                        </tbody>
                    </table>
                    </div>

                    <script>
                        let saureusbiov = document.getElementById("saureusbiov");
                        if (saureusbiov.value === "") {
                            document.getElementById("saureusbiosd").style.display='none';
                            document.getElementById("saureusbiosd").required = false;
                            document.getElementById("lbl_saureusbiosd").style.display='none';
                        } else {
                            document.getElementById("saureusbiosd").style.display='inline-flex';
                            document.getElementById("saureusbiosd").required = true;
                            document.getElementById("lbl_saureusbiosd").style.display='inline-flex';
                        }
                        saureusbiov.addEventListener("focusout", function() {
                            if (saureusbiov.value === "") {
                                document.getElementById("saureusbiosd").style.display='none';
                                document.getElementById("saureusbiosd").required = false;
                                document.getElementById("lbl_saureusbiosd").style.display='none';
                            } else {
                                document.getElementById("saureusbiosd").style.display='inline-flex';
                                document.getElementById("saureusbiosd").required = true;
                                document.getElementById("lbl_saureusbiosd").style.display='inline-flex';
                            }
                        });
                    </script>

                    <!-- P.areu biofilm -->
                    <div class="form-group">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                            <label for="pareubiov" class="col-sm-3 control-label">P. areuginosa Biofilm Integrity Viability</label>
                            </td>
                            <td>
                            <label for="pareubiosd" class="col-sm-3 control-label" id="lbl_pareubiosd" style="display: none">P. areuginosa Biofilm Integrity Standard Deviation</label>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                            <input type="text" name="pareubiov" id="pareubiov" class="form-control" value="{{ old('pareubiov', $bioassay->pareu_bio_v)}}">
                            </td>
                            <td>
                            <input type="text" name="pareubiosd" id="pareubiosd" class="form-control" value="{{ old('pareubiosd', $bioassay->pareu_bio_sd)}}" style="display: none">
                            </td>
                        </tr>     
                        </tbody>
                    </table>
                    </div>

                    <script>
                        let pareubiov = document.getElementById("pareubiov");
                        if (pareubiov.value === "") {
                            document.getElementById("pareubiosd").style.display='none';
                            document.getElementById("pareubiosd").required = false;
                            document.getElementById("lbl_pareubiosd").style.display='none';
                        } else {
                            document.getElementById("pareubiosd").style.display='inline-flex';
                            document.getElementById("pareubiosd").required = true;
                            document.getElementById("lbl_pareubiosd").style.display='inline-flex';
                        }
                        pareubiov.addEventListener("focusout", function() {
                            if (pareubiov.value === "") {
                                document.getElementById("pareubiosd").style.display='none';
                                document.getElementById("pareubiosd").required = false;
                                document.getElementById("lbl_pareubiosd").style.display='none';
                            } else {
                                document.getElementById("pareubiosd").style.display='inline-flex';
                                document.getElementById("pareubiosd").required = true;
                                document.getElementById("lbl_pareubiosd").style.display='inline-flex';
                            }
                        });
                    </script>

                    <!-- Cytotox -->
                    <div class="form-group">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                            <label for="cytotoxv" class="col-sm-3 control-label">Cytotox Viability</label>
                            </td>
                            <td>
                            <label for="cytotoxsd" class="col-sm-3 control-label" id="lbl_cytotoxsd" style="display: none">Cytotox Standard Deviation</label>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                            <input type="text" name="cytotoxv" id="cytotoxv" class="form-control" value="{{ old('cytotoxv', $bioassay->cytotox_v)}}">
                            </td>
                            <td>
                            <input type="text" name="cytotoxsd" id="cytotoxsd" class="form-control" value="{{ old('cytotoxsd', $bioassay->cytotox_sd)}}" style="display: none">
                            </td>
                        </tr>     
                        </tbody>
                    </table>
                    </div>

                    <script>
                        let cytotoxv = document.getElementById("cytotoxv");
                        if (cytotoxv.value === "") {
                            document.getElementById("cytotoxsd").style.display='none';
                            document.getElementById("cytotoxsd").required = false;
                            document.getElementById("lbl_cytotoxsd").style.display='none';
                        } else {
                            document.getElementById("cytotoxsd").style.display='inline-flex';
                            document.getElementById("cytotoxsd").required = true;
                            document.getElementById("lbl_cytotoxsd").style.display='inline-flex';
                        }
                        cytotoxv.addEventListener("focusout", function() {
                            if (cytotoxv.value === "") {
                                document.getElementById("cytotoxsd").style.display='none';
                                document.getElementById("cytotoxsd").required = false;
                                document.getElementById("lbl_cytotoxsd").style.display='none';
                            } else {
                                document.getElementById("cytotoxsd").style.display='inline-flex';
                                document.getElementById("cytotoxsd").required = true;
                                document.getElementById("lbl_cytotoxsd").style.display='inline-flex';
                            }
                        });
                    </script>

                    <!-- PK activity -->
                    <div class="form-group">
                        <label for="pk_activity" class="col-sm-3 control-label">PK activity</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="pk_activity" id="pk_activity" class="form-control" value="{{ old('pk_activity', $bioassay->pk_activity)}}">
                        </div>
                    </div>

                    <!-- DXR activity -->
                    <div class="form-group">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                            <label for="dxr_activity" class="col-sm-6 control-label">DXR activity</label>
                            </td>
                            <td>
                            <label for="confirm_dxr_activity" class="col-sm-6 control-label" id="lbl_confirm_dxr_activity" style="display: none">Confirm DXR activity</label>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                            <input type="text" name="dxr_activity" id="dxr_activity" class="form-control" value="{{ old('dxr_activity', $bioassay->dxr_activity)}}">
                            </td>
                            <td>
                            <input type="text" name="confirm_dxr_activity" id="confirm_dxr_activity" class="form-control" value="{{ old('confirm_dxr_activity', $bioassay->confirm_dxr_activity)}}" style="display: none">
                            </td>
                        </tr>     
                        </tbody>
                    </table>
                    </div>

                    <script>
                        let dxr_activity = document.getElementById("dxr_activity");
                        if (dxr_activity.value === "") {
                            document.getElementById("confirm_dxr_activity").style.display='none';
                            document.getElementById("lbl_confirm_dxr_activity").style.display='none';
                        } else {
                            document.getElementById("confirm_dxr_activity").style.display='inline-flex';
                            document.getElementById("lbl_confirm_dxr_activity").style.display='inline-flex';
                        }
                        dxr_activity.addEventListener("focusout", function() {
                            if (dxr_activity.value === "") {
                                document.getElementById("confirm_dxr_activity").style.display='none';
                                document.getElementById("lbl_confirm_dxr_activity").style.display='none';
                            } else {
                                document.getElementById("confirm_dxr_activity").style.display='inline-flex';
                                document.getElementById("lbl_confirm_dxr_activity").style.display='inline-flex';
                            }
                        });
                    </script>

                    <!-- HPPK activity -->
                    <div class="form-group">
                        <label for="hppk_activity" class="col-sm-3 control-label">HPPK activity</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="hppk_activity" id="hppk_activity" class="form-control" value="{{ old('hppk_activity', $bioassay->hppk_activity)}}">
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Bioassay Result
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>