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
            {{ __('MS MGF Form') }}
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
                @if ($massspecmgf->exists)
                    <form action="{{ route('msmgfform.update', $massspecmgf) }}" method="POST" enctype="multipart/form-data">
                    @method('put')
                @else
                <form action="{{ route('msmgfform.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                    @csrf

                    <!-- Mass Spec ID -->
                    <div class="form-group">
        
                        <div class="col-sm-6">
                            Mass Spec ID : 
                            {{ $massspec_id }}
                            <input type="hidden" name="msid_mgf" id="msid_mgf" class="form-control" value="{{ $massspec_id }}" required>
                        </div>
                    </div>


                    <!-- Upload file -->
                    <div class="form-group">
                        <label for="mgf_file">MGF File</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="mgf_file" id="mgf_file" required>
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add MGF File
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>