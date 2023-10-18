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
            {{ __('Fraction Form') }}
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
                @if($fraction->exists)
                    <form action="{{ route('fractionform.update', $fraction) }}" method="POST">
                    @method('put')
                @else
                    <form action="{{ route('fractionform.store') }}" method="POST">
                @endif
                    @csrf

                    <!-- Source -->
                    <div class="form-group">
                        <label for="source_fraction" class="col-sm-3 control-label">Source of Fraction</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="source_fraction" id="source_fraction" class="form-control" value="{{ old('source_fraction', $fraction->source_id)}}" autofocus required>
                        </div>
                        <div class="myalert" id="myalert" style="display: none">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <strong>Danger!</strong> This source is not recorded yet.
                        </div>
                    </div>

                    <script>
                            let source = document.getElementById("source_fraction");
                            var extractList = {!! json_encode($extractNames->toArray(), JSON_HEX_TAG) !!};
                            var fractionList = {!! json_encode($fractionNames->toArray(), JSON_HEX_TAG) !!};
                            source.addEventListener("blur", function() {
                                let name = document.getElementById("source_fraction").value;
                                if (extractList.indexOf(name) > -1) {
                                    document.getElementById("myalert").style.display='none';
                                } else if (fractionList.indexOf(name) > -1) {
                                    document.getElementById("myalert").style.display='none';
                                } else {
                                    document.getElementById("myalert").style.display = 'block';
                                }
                            });
                        </script>
        
                    <!-- Fraction Name -->
                    <div class="form-group">
                        <label for="fraction_name" class="col-sm-3 text-gray-900">Fraction Name</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="fraction_name" id="fraction_name" class="form-control" required value="{{old('fraction_name', $fraction->fraction_id)}}">
                        </div>

                        <x-input-error :messages="$errors->get('fraction_name')" class="mt-2" />
                    </div>

                    <!-- Research Group -->
                    <div class="form-group">
                        <label for="group_name" class="col-sm-3 control-label">Research Group</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="group_name" id="group_name" class="form-control">
                                @foreach($groups as $group)
                                <option value="{{ $group->group_id }}" {{(old('group_name', $fraction->researchgroup_id) == $group->group_id) ? 'selected' : ''}}>{{ $group->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Project -->
                    <div class="form-group">
                        <label for="project_fraction" class="col-sm-3 control-label">Project</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="project_fraction" list="project_fraction" required value="{{old('project_fraction', $fraction->project) }}">
                            <datalist id="project_fraction">
                                @foreach($projects as $project)
                                <option value="{{ $project }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Solvent used -->
                    <div class="form-group">
                        <label for="solvents_fractionation" class="col-sm-3 control-label">Solvent used for fractionation</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="solvents_fractionation" list="solvents_fractionation" required value="{{old('solvents_fractionation', $fraction->solvent_used) }}">
                            <datalist id="solvents_fractionation">
                                @foreach($solvents as $solvent)
                                <option value="{{ $solvent }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount_fraction" class="col-sm-3 control-label">Amount Available (mg)</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="amount_fraction" id="amount_fraction" class="form-control" value="{{ old('amount_fraction', $fraction->amount_available)}}" required>
                        </div>
                    </div>

                    <!-- Concentration -->
                    <div class="form-group">
                        <label for="concentration_fraction" class="col-sm-3 control-label">Concentration of fraction (mg/ml)</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="concentration_fraction" list="concentration_fraction" required value="{{old('concentration_fraction', $fraction->concentration) }}">
                            <datalist id="concentration_fraction">
                                @foreach($concentrations as $concentration)
                                <option value="{{ $concentration }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Fraction method -->
                    <div class="form-group">
                        <label for="method_fraction" class="col-sm-3 control-label">Method of fractionation</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="method_fraction" list="method_fraction" required value="{{old('method_fraction', $fraction->sample_type) }}">
                            <datalist id="method_fraction">
                                @foreach($methods as $method)
                                <option value="{{ $method }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Date submitted -->
                    <div class="form-group">
                        <label for="date_submitted" class="col-sm-3 control-label">Date Fraction Submitted</label>
        
                        <div class="col-sm-6">
                            <input type="date" name="date_submitted" id="date_submitted" class="form-control" value="{{ old('date_submitted', $fraction->date_sample_submitted)}}" required>
                        </div>
                    </div>

                    <!-- Comments -->
                    <div class="form-group">
                        <label for="comment_fraction" class="col-sm-3 control-label">Comments</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="comment_fraction" id="comment_fraction" class="form-control" value="{{ old('comment_fraction', $fraction->comments)}}">
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Fraction
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>