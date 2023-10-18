<x-app-layout>
<style>
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
            {{ __('Extract Form') }}
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
                @if($extract->exists)
                    <form action="{{ route('extractform.update', $extract) }}" method="POST">
                    @method('put')
                @else
                    <form action="{{ route('extractform.store') }}" method="POST">
                @endif
                    @csrf

                    <!-- Source -->
                    <div class="form-group">
                        <label for="source_extract" class="col-sm-3 control-label">Source of Extract</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="source_extract" id="source_extract" class="form-control" value="{{ old('source_extract', $extract->source_id)}}" autofocus required>
                        </div>
                    </div>

                    <!-- Source type -->
                    <div class="form-group">
                        <label for="type_source" class="col-sm-3 control-label">Type of Source</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="type_source" list="type_source" required value={{old('type_source', $extract->source_type) }}>
                            <datalist id="type_source">
                                @foreach($sourcetypes as $type)
                                <option value="{{ $type }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
        
                    <!-- Extract Name -->
                    <div class="form-group">
                        <label for="extract_name" class="col-sm-3 text-gray-900">Extract Name</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="extract_name" id="extract_name" class="form-control" required value={{old('extract_name', $extract->extract_id)}}>
                        </div>

                        <x-input-error :messages="$errors->get('extract_name')" class="mt-2" />
                    </div>

                    <!-- Research Group -->
                    <div class="form-group">
                        <label for="group_name" class="col-sm-3 control-label">Research Group</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="group_name" id="group_name" class="form-control">
                                @foreach($groups as $group)
                                <option value="{{ $group->group_id }}" {{(old('group_name', $extract->researchgroup_id) == $group->group_id) ? 'selected' : ''}}>{{ $group->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Solvent used -->
                    <div class="form-group">
                        <label for="solvents_extraction" class="col-sm-3 control-label">Solvent used for extraction</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="solvents_extraction" list="solvents_extraction" required value={{old('solvents_extraction', $extract->solvent_extraction) }}>
                            <datalist id="solvents_extraction">
                                @foreach($solvents as $solvent)
                                <option value="{{ $solvent }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount_extract" class="col-sm-3 control-label">Amount Available (mg)</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="amount_extract" id="amount_extract" class="form-control" value="{{ old('amount_extract', $extract->amount_available)}}" required>
                        </div>
                    </div>

                    <!-- Date submitted -->
                    <div class="form-group">
                        <label for="date_submitted" class="col-sm-3 control-label">Date Extract Submitted</label>
        
                        <div class="col-sm-6">
                            <input type="date" name="date_submitted" id="date_submitted" class="form-control" value="{{ old('date_submitted', $extract->date_sample_submitted)}}" required>
                        </div>
                    </div>

                    <!-- Existing literature -->
                    <div class="form-group">
                        <div class="col-sm-6">   

                            <input type="checkbox" name="lit_extract" id="lit_extract" class="form-control" value="lit_extract" @checked(old('lit_extract', $extract->existing_literature))>

                            <label for="lit_extract" class="col-sm-3 control-label">Existing literature</label>
                            <input type="hidden" name="lit_source" id="lit_source" value="{{ old('lit_source', $extract->literature_link)}}">

                            <script>

                            let checkbox = document.getElementById("lit_extract");
                                if ( checkbox.checked ) {
                                    document.getElementById('lit_source').type = 'text';
                                } else {
                                    document.getElementById('lit_source').type = 'hidden';
                                }

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
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Extract
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>