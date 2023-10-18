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
            {{ __('Mass Spectometry Information') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Process ID: ") }}
                    {{ $process_id }}
                </div>
            </div>
        </div>
    </div>

    @if ($msmgfs->count() > 0)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <th>MGF Files</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($msmgfs[0]), true)) as $colnameArr => $colname)
                                @if($colname != "mgf_id" and $colname != "submitter_fraction" and $colname != "submitter_derivedpurecomp" )
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            <td class="table-text"></td>
                            </tr>
                            @foreach ($msmgfs as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                    @if($key == "mgf_id")
                                    @elseif($key == "MGF File")
                                    <td class="table-text">
                                    <form action="{{ route('massspec.download', ['id' => $result->mgf_id, 'process_id' => $process_id, 'download' => 'MGF']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $value }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                    </td>
                                    @else
                                    <td class="table-text"><div>{{ $value }}</div></td>
                                    @endif
                                    @endforeach

                                    @if (in_array(config('global.role_chemist'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                    <td class="table-text">
                                    <form action="{{ route('msmgfform.edit', ['massspec_id' => $result->{'MS ID'}, 'massspecmgf' => $result->mgf_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="edit-{{ $result->mgf_id }}" class="editBtn">
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

    @if ($mscsvs->count() > 0)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <th>CSV/TSV Files</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($mscsvs[0]), true)) as $colnameArr => $colname)
                                @if($colname != "csv_id")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            <td class="table-text"></td>
                            </tr>
                            @foreach ($mscsvs as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                    @if($key == "csv_id")
                                    @elseif($key == "CSV/TSV File")
                                    <td class="table-text">
                                    <form action="{{ route('massspec.download', ['id' => $result->csv_id, 'process_id' => $process_id, 'download' => 'CSV']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $value }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                    </td>
                                    @else
                                    <td class="table-text"><div>{{ $value }}</div></td>
                                    @endif
                                    @endforeach

                                    @if (in_array(config('global.role_chemist'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                    <td class="table-text">
                                    <form action="{{ route('mscsvform.edit', ['massspec_id' => $result->{'MS ID'}, 'massspeccsv' => $result->csv_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="edit-{{ $result->csv_id }}" class="editBtn">
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

    @if (in_array(config('global.role_chemist'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles()))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   <form action="{{ route('msmgfform.add', ['massspec_id' => $massspec->massspec_id]) }}" method="POST">
                        {{ csrf_field() }}
            
                        <button type="submit" id="add-{{ $massspec->massspec_id }}" class="editBtn">
                            <i class="fa fa-btn fa-trash"></i>Add MGF File
                        </button>
                    </form>
                    </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('mscsvform.add', ['massspec_id' => $massspec->massspec_id]) }}" method="POST">
                        {{ csrf_field() }}
            
                        <button type="submit" id="add-{{ $massspec->massspec_id }}" class="editBtn">
                            <i class="fa fa-btn fa-trash"></i>Add CSV/TSV File
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>