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
            {{ __('Ad-hoc Assay Information') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Pure Compound ID: ") }}
                    {{ $derivedpurecomp->derivedpurecomp_id }}
                </div>
            </div>
        </div>
    </div>

    @if ($adhocassays->count() > 0)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <th>Ad-hoc Assays</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($adhocassays[0]), true)) as $colnameArr => $colname)
                                @if($colname != "adhoc_id" and $colname != "Pure Compound ID")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            <td class="table-text"></td>
                            </tr>
                            @foreach ($adhocassays as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                    @if($key == "adhoc_id" or $key == "Pure Compound ID")
                                    @elseif($key == "link_report")
                                    <td class="table-text">
                                    <form action="{{ route('adhocassay.download', ['derivedpurecomp' => $result->{'Pure Compound ID'}, 'adhocassay' => $result->adhoc_id, 'download' => 'PDF']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $result->adhoc_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                    </td>
                                    @else
                                    <td class="table-text"><div>{{ $value }}</div></td>
                                    @endif
                                    @endforeach

                                    @if (in_array(config('global.role_bioassay'), Auth::user()->getRoles()))
                                    <td class="table-text">
                                    <form action="{{ route('adhocassayform.edit', ['derivedpurecomp' => $result->{'Pure Compound ID'}, 'adhocassay' => $result->adhoc_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="edit-{{ $result->adhoc_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Edit
                                        </button>
                                    </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
                   <form action="{{ route('adhocassayform.add', ['derivedpurecomp' => $derivedpurecomp->derivedpurecomp_id]) }}" method="POST">
                        {{ csrf_field() }}
            
                        <button type="submit" id="add-{{ $derivedpurecomp->derivedpurecomp_id }}" class="editBtn">
                            <i class="fa fa-btn fa-trash"></i>Add Ad-hoc Assay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>