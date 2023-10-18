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

</style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                {{ __("Search by process type:") }}
                    <form action="{{ route('search.index') }}" method="GET">
                    {{ csrf_field() }}
                        <br>
                            <select name="process" id="process">
                                <option value="extracts" selected>Extracts</option>
                                <option value="fractions">Fractions</option>
                                <option value="purecompounds">Pure Compounds</option>
                            </select> 
                        <br>
                        <table class="table">
                            <tr>
                                <td>
                                <label for="submitter_name" class="col-sm-3 control-label">Submitter Name</label>
                                </td>

                                <td>
                                <label for="group_name" class="col-sm-3 control-label">Group Name</label>
                                </td>

                                <td>
                                <label for="start_date" class="col-sm-3 control-label">Start Date</label>
                                </td>

                                <td>
                                <label for="end_date" class="col-sm-3 control-label">End Date</label>
                                </td>
                            </tr>
                            <tr>

                                <td class="col-sm-6">
                                <select type="text" name="submitter_name[]" id="submitter_name" class="form-control" multiple>
                                    @foreach($submitters as $submitter)
                                    <option value="{{ $submitter->id }}">{{ $submitter->name }}</option>
                                    @endforeach
                                </select>
                                </td>

                                <td>
                                <select type="text" name="group_name[]" id="group_name" class="form-control" multiple>
                                    @foreach($groups as $group)
                                    <option value="{{ $group->group_id }}">{{ $group->group_name }}</option>
                                    @endforeach
                                </select>
                                </td>
        
                                <td>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date')}}">
                                </td>

                                <td>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date')}}">
                                </td>


                                <td>
                                <input type="checkbox" name="proc_check" id="proc_check" class="form-control" value="{{ old('nmr_extract')}}">
                                <label for="proc_check" class="col-sm-3 control-label">Show Process</label>
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

    @if ($results->count() > 0)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Tasks
            </div>
            {{ $results->links() }}
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <th>Results</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        <tr>
                        @foreach (array_keys(json_decode(json_encode($results[0]), true)) as $colnameArr => $colname)
                            @if($colname != "submitter_extract" and $colname != "submitter_fraction" and $colname != "submitter_derivedpurecomp" )
                            <td class="table-text"><div>{{ $colname }}</div></td>
                            @endif
                        @endforeach
                        </tr>
                        @foreach ($results as $result)
                            <tr>
                                @foreach($result as $key => $value)
                                @if($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                @elseif ($key == "Source of Extract")
                                <td>
                                    <a class="nav_link" href="{{ route('supplier.index', $value) }}">{{ $value }}</a>
                                </td>
                                @elseif($key == "Pure Compound ID")
                                <td>
                                    <a class="nav_link" href="{{ route('adhocassay.index', $value) }}">{{ $value }}</a>
                                </td>
                                @elseif($key == "Process Extract ID")
                                <td>
                                    @if ((in_array(config('global.role_process'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles())) AND $value === NULL)
                                    <form action="{{ route('processform.index', ['supplier_id' => $result->{'Extract ID'}, 'supplier_type' => 'Extract']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="add-{{ $result->{'Extract ID'} }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Process
                                        </button>
                                    </form>
                                    @elseif ($value === NULL)
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                    @else
                                    <a class="nav_link" href="{{ route('process.index', ['process_id' => $value, 'supplier_id' => $result->{'Extract ID'}, 'supplier_type' => 'Extract']) }}">{{ $value }}</a>
                                    @endif
                                </td>
                                @elseif($key == "Process Fraction ID")
                                <td>
                                    @if ((in_array(config('global.role_process'), Auth::user()->getRoles())|| in_array(config('global.role_admin'), Auth::user()->getRoles())) AND $value === NULL)
                                    <form action="{{ route('processform.index', ['supplier_id' => $result->{'Fraction ID'}, 'supplier_type' => 'Fraction']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="add-{{ $result->{'Fraction ID'} }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Process
                                        </button>
                                    </form>
                                    @elseif ($value === NULL)
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                    @else
                                    <a class="nav_link" href="{{ route('process.index', ['process_id' => $value, 'supplier_id' => $result->{'Fraction ID'}, 'supplier_type' => 'Fraction']) }}">{{ $value }}</a>
                                    @endif
                                </td>
                                @elseif($key == "Process Compound ID")
                                <td>
                                    @if ((in_array(config('global.role_process'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles())) AND $value === NULL)
                                    <form action="{{ route('processform.index', ['supplier_id' => $result->{'Pure Compound ID'}, 'supplier_type' => 'Pure Compound']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="add-{{ $result->{'Pure Compound ID'} }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Process
                                        </button>
                                    </form>
                                    @elseif ($value === NULL)
                                        <td class="table-text"><div>{{ $value }}</div></td>
                                    @else
                                    <a class="nav_link" href="{{ route('process.index', ['process_id' => $value, 'supplier_id' => $result->{'Process Compound ID'}, 'supplier_type' => 'Pure Compound']) }}">{{ $value }}</a>
                                    @endif
                                </td>
                                @elseif($key == "submitter_extract")
                                <td>
                                    @if(Auth::id() == $value || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                    <form action="{{ route('extractform.edit', $result->{'Extract ID'}) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="edit-{{ $result->{'Extract ID'} }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Edit
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                @elseif($key == "submitter_fraction")
                                <td>
                                    @if(Auth::id() == $value || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                    <form action="{{route('fractionform.edit', $result->{'Fraction ID'})}}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="edit" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Edit
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                @elseif($key == "submitter_derivedpurecomp")
                                <td>
                                    @if(Auth::id() == $value || in_array(config('global.role_admin'), Auth::user()->getRoles()))
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
        </div>
    </div>
    @endif
    
</x-app-layout>