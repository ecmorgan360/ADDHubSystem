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
            {{ __('NMR Folder Submission Form') }}
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
                @if ($nmr->exists)
                    @if ($nmr->date_submitted == NULL)
                        <form action="{{ route('nmrform.store') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('nmrform.update', $nmr) }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                    @endif
                @else
                <form action="{{ route('nmrform.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                    @csrf

                    <!-- Process -->
                    <div class="form-group">
                        <label for="nmr_process" class="col-sm-3 control-label">Process ID</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="nmr_process" id="nmr_process" class="form-control" value="{{ old('nmr_process', $nmr->process_id)}}" autofocus required>
                        </div>
                    </div>


                    <!-- Upload file -->
                    <div class="form-group">
                        <label for="nmr_file">Zipped NMR folder</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="nmr_file" id="nmr_file" required>
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add NMR
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    $.ajax({
        type: "POST",
        url: "{{ route('massspecform.store')", 
        data: dataString,
        dataType: 'json',
        beforeSend: function () {
            $("#submit").prop('disabled', true); // this will disable button
        },
        success:function(response) {
            }
    });
</script>
</x-app-layout>