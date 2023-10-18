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
            {{ __('HPLC Submission Form') }}
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
                @if ($hplc->exists)
                    <form action="{{ route('hplcform.update', $hplc) }}" method="POST" enctype="multipart/form-data">
                    @method('put')
                @else
                <form action="{{ route('hplcform.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                    @csrf

                    <!-- UV Trace -->
                    <div class="form-group">
                        <label for="hplc_uvtrace">UV Trace File</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="hplc_uvtrace" id="hplc_uvtrace" required>
                        </div>
                    </div>

                    <!-- Report -->
                    <div class="form-group">
                        <label for="hplc_report">Report File</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" name="hplc_report" id="hplc_report" required>
                        </div>
                    </div>

                    <!-- Diluent -->
                    <div class="form-group">
                        <label for="diluent_hplc" class="col-sm-3 control-label">Diluent used during HPLC</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="diluent_hplc" list="diluent_hplc" required value={{old('diluent_hplc', $hplc->diluent) }}>
                            <datalist id="diluent_hplc">
                                @foreach($diluents as $diluent)
                                <option value="{{ $diluent }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Requested HPLCS -->
                    <div class="form-group">
                        <label for="requests_hplc" class="col-sm-3 control-label">Associated Processes (Ctrl and Click all)</label>
                        <div class="col-sm-6">
                            <select type="text" name="requests_hplc[]" id="requests_hplc" class="form-control" multiple required>
                            @foreach($results as $result)
                                @if($myProcesses != null)
                                    @php 
                                    $found = false;
                                    @endphp
                                    @foreach($myProcesses as $res)
                                        @if((collect(old('requests_hplc', $res->process_id))->contains($result)))
                                        <option value="{{ $result }}" selected>{{ $result }}</option>
                                        @php 
                                        $found = true;
                                        @endphp
                                        @endif
                                    @endforeach
                                    @if(!$found)
                                    <option value="{{ $result }}">{{ $result }}</option>
                                    @endif
                                @else
                                <option value="{{ $result }}" {{(old('requests_hplc') == $result) ? 'selected' : ''}}>{{ $result }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Date submitted -->
                    <div class="form-group">
                        <label for="date_submitted" class="col-sm-3 control-label">Date HPLC Submitted</label>
        
                        <div class="col-sm-6">
                            <input type="date" name="hplc_date" id="hplc_date" class="form-control" value="{{ old('hplc_date', $hplc->date_submitted)}}" required>
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add HPLC
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