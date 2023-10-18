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
            {{ __('Ad-hoc Assay Form') }}
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
                @if ($adhocassay->exists)
                    <form action="{{ route('adhocassayform.update', $adhocassay) }}" method="POST" enctype="multipart/form-data">
                    @method('put')
                @else
                <form action="{{ route('adhocassayform.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                    @csrf

                    <!-- Derived Pure Compound ID -->
                    <div class="form-group">
        
                        <div class="col-sm-6">
                            Derived Pure Compound ID : 
                            {{ $derivedpurecomp_id }}
                            <input type="hidden" name="purecomp_adhoc" id="purecomp_adhoc" class="form-control" value="{{ $derivedpurecomp_id }}" required>
                        </div>
                    </div>

                    <!-- Type of Assay -->
                    <div class="form-group">
                        <label for="type_adhoc" class="col-sm-3 control-label">Type of Ad-hoc Assay</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="type_adhoc" list="type_adhoc" required value="{{old('type_adhoc', $adhocassay->adhoc_type) }}">
                            <datalist id="type_adhoc">
                                @foreach($adhoctypes as $adhoctype)
                                <option value="{{ $adhoctype }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>


                    <!-- Upload file -->
                    <div class="form-group">
                        <label for="adhoc_file">Ad-hoc Assay Report</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="adhoc_file" id="adhoc_file" required>
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Ad-hoc Assay
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>