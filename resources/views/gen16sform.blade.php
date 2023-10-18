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
            {{ __('Genomics 16sRNA Forward and Reverse Reads Form') }}
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
                @if ($gen16s->exists)
                    @if ($gen16s->supplier_id == NULL)
                        <form action="{{ route('gen16sform.store') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('gen16sform.update', $gen16s) }}" method="POST" enctype="multipart/form-data">
                        @method('put')
                    @endif
                @else
                <form action="{{ route('gen16sform.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                    @csrf

                    <!-- Process -->
                    <div class="form-group">
                        <label for="gen_supplier" class="col-sm-3 control-label">Supplier ID</label>
                        @if ($gen16s->exists)
                        <div class="col-sm-6">
                            <input type="hidden" name="gen_supplier" id="gen_supplier" class="form-control" value="{{ old('gen_supplier', $gen16s->supplier_id)}}" autofocus required>
                            {{ $gen16s->supplier_id }}
                        </div>
                        @else
                        <div class="col-sm-6">
                            <input type="text" name="gen_supplier" id="gen_supplier" class="form-control" value="{{ old('gen_supplier', $gen16s->supplier_id)}}" autofocus required>
                        </div>
                        @endif
                    </div>


                    <!-- Upload file -->
                    <div class="form-group">
                        <label for="gen_forward">Forward Read</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="gen_forward" id="gen_forward" required>
                        </div>
                    </div>

                    <!-- Upload file -->
                    <div class="form-group">
                        <label for="gen_reverse">Reverse Read</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="gen_reverse" id="gen_reverse" required>
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Reads
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