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
            {{ __('Process Form') }}
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
                @if ($process->exists)
                    <form action="{{ route('processform.update', $process) }}" method="POST">
                    @method('put')
                @else
                <form action="{{ route('processform.store') }}" method="POST">
                @endif
                    @csrf

                    <!-- Supplier ID -->
                    <div class="form-group">
                        <label for="supplier_process" class="col-sm-3 control-label">Supplier ID</label>
        
                        <div class="col-sm-6">
                        <input type="hidden" name="supplier_process" id="supplier_process" class="form-control" value="{{ old('supplier_process', $supplier_id)}}" required>
                            {{ $supplier_id }}
                        </div>
                    </div>
        
                    <!-- Process ID -->
                    <div class="form-group">
                        <label for="process_name" class="col-sm-3 text-gray-900">Process ID</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="process_name" id="process_name" class="form-control" required>
                        </div>

                        <x-input-error :messages="$errors->get('process_name')" class="mt-2" />
                    </div>

                    @if ($process->exists)
                    <script>
                        var processID = {!! json_encode($process_id, JSON_HEX_TAG) !!};
                        document.getElementById("process_name").value = processID;
                    </script>
                    @else
                    <script>
                        var processID = {!! json_encode($process_id->process_id, JSON_HEX_TAG) !!};
                        header = processID.substr(0, 3);
                        nums = Number(processID.substr(-5));
                        newID = header + String(nums + 1).padStart(5, '0');
                        document.getElementById("process_name").value = newID;
                    </script>
                    @endif

                    <!-- Date assigned -->
                    <div class="form-group">
                        <label for="date_assigned" class="col-sm-3 control-label">Date Assigned</label>
        
                        <div class="col-sm-6">
                            <input type="date" name="date_assigned" id="date_assigned" class="form-control" value="{{ old('date_assigned', $process_date)}}" required>
                        </div>
                    </div>

                    <!-- Schedule MS -->
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="checkbox" name="ms_process" id="ms_process" class="form-control" @checked(old('ms_process', $process_ms))>
                            <label for="ms_process" class="col-sm-3 control-label">Schedule for MS</label>
                        </div>
                    </div>

                    <!-- Schedule NMR -->
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="checkbox" name="nmr_process" id="nmr_process" class="form-control" @checked(old('nmr_process', $process_nmr))>
                            <label for="nmr_process" class="col-sm-3 control-label">Schedule for NMR</label>
                        </div>
                    </div>

                    <!-- Schedule HPLC -->
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="checkbox" name="hplc_process" id="hplc_process" class="form-control" @checked(old('hplc_process', $process_nmr))>
                            <label for="hplc_process" class="col-sm-3 control-label">Schedule for HPLC</label>
                        </div>
                    </div>

                    <!-- Schedule Bioassay -->
                    <div class="form-group">
                        <div class="col-sm-6">
                            <input type="checkbox" name="bioassay_process" id="bioassay_process" class="form-control" @checked(old('bioassay_process', $process_bioassay))>
                            <label for="bioassay_process" class="col-sm-3 control-label">Schedule for Bioassay</label>
                        </div>
                    </div>

                    <script>
                        let checkbox = document.getElementById("bioassay_process");

                        checkbox.addEventListener( "change", () => {
                            if ( checkbox.checked ) {
                                document.getElementById('pk_switch').style.display = 'block';
                            } else {
                                document.getElementById('pk_switch').style.display = 'none';
                            }
                        });
                    </script>

                    <!-- Schedule PK assay -->
                    <div class="form-group"  id="pk_switch" style="display: none">
                        <div class="col-sm-6">
                            <input type="checkbox" name="pk_process" id="pk_process" class="form-control" @checked(old('pk_process', $process_pk))>
                            <label for="pk_process" class="col-sm-3 control-label">Schedule for PK Assay</label>
                        </div>
                    </div>

                    <!-- Sample Level -->
                    <div class="form-group">
                        <label for="supplier_level" class="col-sm-3 control-label">Sample Level</label>
        
                        <div class="col-sm-6">
                            <input type="hidden" name="supplier_level" id="supplier_level" class="form-control" value="{{ old('supplier_level', $supplier_type)}}">
                            {{ $supplier_type }}
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Process
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>