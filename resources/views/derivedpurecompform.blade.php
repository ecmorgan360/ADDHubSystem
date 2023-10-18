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
select, input[type="text"]{
    width:25%;
    box-sizing:border-box;
}
</style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Derived Pure Compound Form') }}
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
                @if($derivedpurecomp->exists)
                    <form action="{{ route('derivedpurecompform.update', $derivedpurecomp) }}" method="POST">
                    @method('put')
                @else
                    <form action="{{ route('derivedpurecompform.store') }}" method="POST">
                @endif
                    @csrf

                    <!-- Source -->
                    <div class="form-group">
                        <label for="source_derived" class="col-sm-3 control-label">Source of Compound</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="source_derived" id="source_derived" class="form-control" value="{{ old('source_derived', $derivedpurecomp->source_id)}}" autofocus required>
                        </div>
                        <div class="myalert" id="myalert" style="display: none">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <strong>Danger!</strong> This source is not recorded yet.
                        </div>
                    </div>

                        <script>
                            let source = document.getElementById("source_derived");
                            var extractList = {!! json_encode($extractNames->toArray(), JSON_HEX_TAG) !!};
                            var fractionList = {!! json_encode($fractionNames->toArray(), JSON_HEX_TAG) !!};
                            source.addEventListener("focusout", function() {
                                let name = document.getElementById("source_derived").value;
                                //window.alert(name)
                                if (extractList.indexOf(name) > -1) {
                                    document.getElementById("myalert").style.display='none';
                                } else if (fractionList.indexOf(name) > -1) {
                                    //window.alert("in here")
                                    document.getElementById("myalert").style.display='none';
                                } else {
                                    document.getElementById("myalert").style.display = 'block';
                                }
                            });
                        </script>
        
                    <!-- Compound Name -->
                    <div class="form-group">
                        <label for="derived_name" class="col-sm-3 text-gray-900">Derived Pure Compound Name</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="derived_name" id="derived_name" class="form-control" value="{{ old('derived_name', $derivedpurecomp->derivedpurecomp_id)}}" required>
                        </div>

                        <x-input-error :messages="$errors->get('derived_name')" class="mt-2" />

                    </div>

                    <script>
                        let comp = document.getElementById("derived_name");
                        comp.addEventListener("focusout", function() {
                            let comp_name = document.getElementById("derived_name").value;
                            //window.alert(comp_name.substr(0,3).valueOf());
                            if (comp_name.substr(0,3).valueOf() != "PC-".valueOf()) {
                                document.getElementById("derived_name").value = "PC-" + comp_name;
                            }
                        });
                    </script>

                    <!-- Research Group -->
                    <div class="form-group">
                        <label for="group_name" class="col-sm-3 control-label">Research Group</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="group_name" id="group_name" class="form-control">
                                @foreach($groups as $group)
                                <option value="{{ $group->group_id }}" {{(old('group_name', $derivedpurecomp->researchgroup_id) == $group->group_id) ? 'selected' : ''}}>{{ $group->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Solvent used -->
                    <div class="form-group">
                        <label for="solvents_derived" class="col-sm-3 control-label">Solvent used for derivation</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="solvents_derived" list="solvents_derived" required value="{{old('solvents_derived', $derivedpurecomp->solvent_used) }}">
                            <datalist id="solvents_derived">
                                @foreach($solvents as $solvent)
                                <option value="{{ $solvent }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Solubility -->
                    <div class="form-group">
                        <label for="solubility_derived" class="col-sm-3 control-label">List of solvents compound is soluble in</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="solubility_derived" list="solubility_derived" required value="{{old('solubility_derived', $derivedpurecomp->solubility) }}">
                            <datalist id="solubility_derived">
                                @foreach($solublelist as $soluble)
                                <option value="{{ $soluble }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount_derived" class="col-sm-3 control-label">Amount Available (mg)</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="amount_derived" id="amount_derived" class="form-control" value="{{ old('amount_derived', $derivedpurecomp->amount_available)}}" required>
                        </div>
                    </div>

                    <!-- Date submitted -->
                    <div class="form-group">
                        <label for="date_submitted" class="col-sm-3 control-label">Date Compound Submitted</label>
        
                        <div class="col-sm-6">
                            <input type="date" name="date_submitted" id="date_submitted" class="form-control" value="{{ old('date_submitted', $derivedpurecomp->date_sample_submitted)}}" required>
                        </div>
                    </div>

                    <!-- Synthesis potential -->
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="checkbox" name="synthesis_derived" id="synthesis_derived" class="form-control" @checked(old('synthesis_derived', $derivedpurecomp->synthesis_potential))>
                            <label for="synthesis_derived" class="col-sm-3 control-label">Can this compound be synthesised?</label>
                        </div>
                    </div>

                    <!-- Stereo Comments -->
                    <div class="form-group">
                        <label for="stereo_derived" class="col-sm-3 control-label">Stereo Comments</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="stereo_derived" id="stereo_derived" class="form-control" value="{{ old('stereo_derived', $derivedpurecomp->stereo_comments)}}">
                        </div>
                    </div>

                    <!-- SMILE structure -->
                    <div class="form-group">
                        <label for="smile_derived" class="col-sm-3 control-label">SMILE structure</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="smile_derived" id="smile_derived" class="form-control" value="{{ old('smile_derived', $derivedpurecomp->smile_structure)}}" required>
                        </div>
                    </div>

                    <!-- Molecular weight -->
                    <div class="form-group">
                        <label for="mw_derived" class="col-sm-3 control-label">Molecular weight (g/mol)</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="mw_derived" id="mw_derived" class="form-control" value="{{ old('mw_derived', $derivedpurecomp->mw)}}" required>
                        </div>
                    </div>

                    <!-- Additional Metadata -->
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="checkbox" name="metadata_derived" id="metadata_derived" class="form-control" @checked(old('metadata_derived', $derivedpurecomp->additional_metadata))>
                            <label for="metadata_derived" class="col-sm-3 control-label">Is there additional metadata?</label>
                        </div>
                    </div>

                    <!-- Existing Patent -->
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="checkbox" name="patent_derived" id="patent_derived" class="form-control" @checked(old('patent_derived', $derivedpurecomp->existing_patent))>
                            <label for="patent_derived" class="col-sm-3 control-label">Is there any existing patent?</label>
                        </div>
                    </div>

                    <!-- Existing literature -->
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="checkbox" name="lit_derived" id="lit_derived" class="form-control" @checked(old('lit_derived', $derivedpurecomp->existing_literature))>
                            <label for="lit_derived" class="col-sm-3 control-label">Existing literature</label>
                            <input type="hidden" name="lit_source" id="lit_source" value="{{ old('lit_source', $derivedpurecomp->literature_link)}}">

                            <script>

                            let checkbox = document.getElementById("lit_derived");
                            // checkbox.addEventListener( "change", () => {
                                if ( checkbox.checked ) {
                                    document.getElementById('lit_source').type = 'text';
                                } else {
                                    document.getElementById('lit_source').type = 'hidden';
                                }
                            // });

                            checkbox.addEventListener( "change", () => {
                                if ( checkbox.checked ) {
                                    document.getElementById('lit_source').type = 'text';
                                } else {
                                    document.getElementById('lit_source').type = 'hidden';
                                }
                            });
                            </script>
                            
                        </div>
                    </div>

                    <!-- Comments -->
                    <div class="form-group">
                        <label for="comment_derived" class="col-sm-3 control-label">Comments</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="comment_derived" id="comment_derived" class="form-control" value="{{ old('comment_derived', $derivedpurecomp->comments)}}">
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Compound
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>