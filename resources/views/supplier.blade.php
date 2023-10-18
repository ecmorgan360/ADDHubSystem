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
            {{ __('Supplier Page') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Supplier ID: ") }}
                    {{ $result_name }}
                </div>
            </div>
        </div>
    </div>

    @if ($results_type == "Collection")
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <th>Collection Sample</th>
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
                <div class="p-6 text-gray-900">
                    {{ __("Collectors:") }}
                    @php
                    $edit_collection = False;
                    @endphp
                    @foreach($results_collectors as $collector)
                    <div>
                        @foreach($collector as $key => $value)
                            @if ($key == "Collectors")
                            {{ $value }}
                            @else
                                @if (Auth::id() == $value || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                @php
                                $edit_collection = True;
                                @endphp
                                @endif
                            @endif
                        @endforeach
                    </div>
                    @endforeach
                    <div>
                    @if ($edit_collection)
                        <form action="{{ route('collectionform.edit', ['collection' => $result_name]) }}" method="POST">
                            {{ csrf_field() }}
                
                            <button type="submit" id="edit-{{ $result_name }}" class="editBtn">
                                <i class="fa fa-btn fa-trash"></i>Edit
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @elseif($results_type == "Strain")
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <th>Strain Sample</th>
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
                <div class="p-6 text-gray-900">
                    @if (in_array(config('global.role_collector'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                        <form action="{{ route('strainform.edit', ['strain' => $result_name]) }}" method="POST">
                            {{ csrf_field() }}
                
                            <button type="submit" id="edit-{{ $result_name }}" class="editBtn">
                                <i class="fa fa-btn fa-trash"></i>Edit
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @else
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("No Current Sample or Strain Associated with this ID") }}
                </div>
            </div>
        </div>
    </div>
    @endif

    
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($results_gen16s->isEmpty())
                    <div>
                        {{ __("16sRNA not performed yet") }}
                    </div>
                    @else
                    <div>
                    @foreach ($results_gen16s as $result_gen16s)
                    <table class="table">
                        <thead>
                            <th>16sRNA</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach($result_gen16s as $key => $value)
                                @if ($key == "gen16s_id")
                                @elseif ($key == "Link Forward")
                                <td class="table-text"><div>{{ $key }}</div></td>
                                <td class="table-text">
                                    <form action="{{ route('supplier.download', ['id' => $result_gen16s->gen16s_id, 'supplier_id' => $result_name, 'download' => '16SF']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $result_gen16s->gen16s_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                </td>
                                @elseif ($key == "Link Reverse")
                                <td class="table-text"><div>{{ $key }}</div></td>
                                <td class="table-text">
                                    <form action="{{ route('supplier.download', ['id' => $result_gen16s->gen16s_id, 'supplier_id' => $result_name, 'download' => '16SR']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $result_gen16s->gen16s_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                </td>
                                @else
                                <tr>
                                    <td class="table-text"><div>{{ $key }}</div></td>
                                    <td class="table-text"><div>{{ $value }}</div></td>
                                </tr>
                                @endif
                            </tr>
                            @endforeach
                            @if (in_array(config('global.role_genomics'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                            <tr>
                                <td class="table-text"><div></div></td>
                                <td class="table-text">
                                    <form action="{{ route('gen16sform.edit', ['gen16s' => $result_gen16s->gen16s_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="edit-{{ $result_gen16s->gen16s_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Edit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($results_metagenome->isEmpty())
                    <div>
                        {{ __("Metagenomics not performed yet") }}
                    </div>
                    @else
                    <div>
                    @foreach ($results_metagenome as $result_metagenome)
                    <table class="table">
                        <thead>
                            <th>Metagenomics</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach($result_metagenome as $key => $value)
                                @if ($key == "process_id" or $key == "supplier_id" or $key == "cancelled" or $key == "metagenome_id")
                                @elseif ($key == "Link BAM")
                                <td class="table-text"><div>{{ $key }}</div></td>
                                <td class="table-text">
                                    <form action="{{ route('supplier.download', ['id' => $result_metagenome->metagenome_id, 'supplier_id' => $result_name, 'download' => 'META']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $result_metagenome->metagenome_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                </td>
                                @else
                                <tr>
                                    <td class="table-text"><div>{{ $key }}</div></td>
                                    <td class="table-text"><div>{{ $value }}</div></td>
                                </tr>
                                @endif
                            </tr>
                            @endforeach
                            @if (in_array(config('global.role_genomics'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                            <tr>
                                <td class="table-text"><div></div></td>
                                <td class="table-text">
                                    <form action="{{ route('metagenomeform.edit', ['metagenome' => $result_metagenome->metagenome_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="edit-{{ $result_metagenome->metagenome_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Edit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>