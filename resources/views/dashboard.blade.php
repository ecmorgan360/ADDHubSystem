<x-app-layout>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.table-wrapper {
    display:block;
    overflow-x:auto;
    white-space:nowrap;
}

</style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                {{ __("Search by date:") }}
                    <form action="{{ route('dashboard.result') }}" method="POST">
                    {{ csrf_field() }}
                        <table class="table">
                            <tr>
                                <td>
                                <label for="start_date" class="col-sm-3 control-label">Start Date</label>
                                </td>

                                <td>
                                <label for="end_date" class="col-sm-3 control-label">End Date</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $startDate)}}">
                                </td>

                                <td>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $endDate)}}">
                                </td>
                            </tr>
                        </table>
                        <br>
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i>Search
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (in_array(config('global.role_extract'), Auth::user()->getRoles()))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("New Samples to Extract") }}
                    @if ($result_collections->count() > 0)
                    <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <th>Collections</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_collections[0]), true)) as $colnameArr => $colname)
                                @if($colname != "Bioassay ID")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            <td class="table-text"><div></div></td>
                            </tr>
                            @foreach ($result_collections as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                        <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                        @else
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                </div>
                @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (in_array(config('global.role_process'), Auth::user()->getRoles()))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("New Products to Process") }}
                    @if ($result_extracts->count() > 0)
                    <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <th>Extracts</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_extracts[0]), true)) as $colnameArr => $colname)
                                @if($colname != "submitter_extract")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            </tr>
                            @foreach ($result_extracts as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                        <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                        @elseif($key == "Process Extract ID")
                                        <td>
                                            @if (in_array(config('global.role_process'), Auth::user()->getRoles()) AND $value === NULL)
                                            <form action="{{ route('processform.index', ['supplier_id' => $result->{'Extract ID'}, 'supplier_type' => 'Extract']) }}" method="POST">
                                                {{ csrf_field() }}
                                    
                                                <button type="submit" id="add-{{ $result->{'Extract ID'} }}" class="editBtn">
                                                    <i class="fa fa-btn fa-trash"></i>Process
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        @elseif($key == "submitter_extract")
                                        <td>
                                            @if(Auth::id() == $value)
                                            <form action="{{ route('extractform.edit', $result->{'Extract ID'}) }}" method="POST">
                                                {{ csrf_field() }}
                                    
                                                <button type="submit" id="edit-{{ $result->{'Extract ID'} }}" class="editBtn">
                                                    <i class="fa fa-btn fa-trash"></i>Edit
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        @else
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                        @endif
                                    @endforeach   
                                </tr>
                            @endforeach
                    </tbody>
                    </table>
                    </div>
                    @endif
                    @if ($result_fractions->count() > 0)
                    <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <th>Fractions</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_fractions[0]), true)) as $colnameArr => $colname)
                                @if($colname != "submitter_fraction")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            </tr>
                            @foreach ($result_fractions as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                        <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                        @elseif($key == "Process Fraction ID")
                                        <td>
                                            @if (in_array(config('global.role_process'), Auth::user()->getRoles()) AND $value === NULL)
                                            <form action="{{ route('processform.index', ['supplier_id' => $result->{'Fraction ID'}, 'supplier_type' => 'Fraction']) }}" method="POST">
                                                {{ csrf_field() }}
                                    
                                                <button type="submit" id="add-{{ $result->{'Fraction ID'} }}" class="editBtn">
                                                    <i class="fa fa-btn fa-trash"></i>Process
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        @elseif($key == "submitter_fraction")
                                        <td>
                                            @if(Auth::id() == $value)
                                            <form action="{{route('fractionform.edit', $result->{'Fraction ID'})}}" method="POST">
                                                {{ csrf_field() }}
                                    
                                                <button type="submit" id="edit" class="editBtn">
                                                    <i class="fa fa-btn fa-trash"></i>Edit
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        @else
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                        @endif
                                    @endforeach   
                                </tr>
                            @endforeach
                    </tbody>
                    </table>
                    </div>
                    @endif
                    @if ($result_purecomps->count() > 0)
                    <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <th>Pure Compounds</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_purecomps[0]), true)) as $colnameArr => $colname)
                                @if($colname != "submitter_derivedpurecomp")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            </tr>
                            @foreach ($result_purecomps as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                        <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                        @elseif($key == "Process Compound ID")
                                        <td>
                                            @if (in_array(config('global.role_process'), Auth::user()->getRoles()) AND $value === NULL)
                                            <form action="{{ route('processform.index', ['supplier_id' => $result->{'Pure Compound ID'}, 'supplier_type' => 'Pure Compound']) }}" method="POST">
                                                {{ csrf_field() }}
                                    
                                                <button type="submit" id="add-{{ $result->{'Pure Compound ID'} }}" class="editBtn">
                                                    <i class="fa fa-btn fa-trash"></i>Process
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        @elseif($key == "submitter_derivedpurecomp")
                                        <td>
                                            @if(Auth::id() == $value)
                                            <form action="{{route('derivedpurecompform.edit', $result->{'Pure Compound ID'})}}" method="POST">
                                                {{ csrf_field() }}
                                    
                                                <button type="submit" id="edit" class="editBtn">
                                                    <i class="fa fa-btn fa-trash"></i>Edit
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        @else
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                        @endif
                                    @endforeach   
                                </tr>
                            @endforeach
                    </tbody>
                    </table>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (in_array(config('global.role_bioassay'), Auth::user()->getRoles()))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("New Products to Bioassay") }}
                    @if ($result_proc_bioassays->count() > 0)
                    <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <th>Processes</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_proc_bioassays[0]), true)) as $colnameArr => $colname)
                                @if($colname != "Bioassay ID")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            <td class="table-text"><div></div></td>
                            </tr>
                            @foreach ($result_proc_bioassays as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                        <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                        @else
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                        @endif
                                    @endforeach
                                    <td>
                                        <form action="{{ route('bioassayform.add', ['bioassay' => $result->{'Process ID'}]) }}" method="POST">
                                            {{ csrf_field() }}
                                
                                            <button type="submit" id="add-{{ $result->{'Process ID'} }}" class="editBtn">
                                                <i class="fa fa-btn fa-trash"></i>Add Bioassay
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                </div>
                @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (in_array(config('global.role_chemist'), Auth::user()->getRoles()))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("New Products for Chemical Analysis") }}
                    @if ($result_proc_massspecs->count() > 0)
                    <table class="table">
                        <thead>
                            <th>Mass Spectometry</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_proc_massspecs[0]), true)) as $colnameArr => $colname)
                                @if($colname != "MS ID")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            </tr>
                            @foreach ($result_proc_massspecs as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                        <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                        @elseif($key == "MS ID")
                                        <td>
                                            @if (in_array(config('global.role_chemist'), Auth::user()->getRoles()))
                                            <form action="{{ route('massspecform.add', ['massspec' => $result->{'MS ID'}]) }}" method="POST">
                                                {{ csrf_field() }}
                                    
                                                <button type="submit" id="add-{{ $result->{'MS ID'} }}" class="editBtn">
                                                    <i class="fa fa-btn fa-trash"></i>Add MS
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        @else
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                        @endif
                                    @endforeach   
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                @endif
                @if ($result_proc_nmrs->count() > 0)
                    <table class="table">
                        <thead>
                            <th>NMR</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_proc_nmrs[0]), true)) as $colnameArr => $colname)
                                @if($colname != "NMR ID")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            </tr>
                            @foreach ($result_proc_nmrs as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                        <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                        @elseif($key == "NMR ID")
                                        <td>
                                            @if (in_array(config('global.role_chemist'), Auth::user()->getRoles()))
                                            <form action="{{ route('nmrform.add', ['nmr' => $result->{'NMR ID'}]) }}" method="POST">
                                                {{ csrf_field() }}
                                    
                                                <button type="submit" id="add-{{ $result->{'NMR ID'} }}" class="editBtn">
                                                    <i class="fa fa-btn fa-trash"></i>Add NMR
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                        @else
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                        @endif
                                    @endforeach   
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                @endif
                @if ($result_proc_hplcs->count() > 0)
                    <table class="table">
                        <thead>
                            <th>HPLC</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_proc_hplcs[0]), true)) as $colnameArr => $colname)
                                @if($colname != "Extract ID")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            </tr>
                            @foreach ($result_proc_hplcs as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                        @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                        <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                        @else
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                        @endif
                                    @endforeach   
                                </tr>
                            @endforeach
                    </tbody>
                </table>
                @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    
</x-app-layout>
