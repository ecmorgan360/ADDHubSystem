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
            {{ __('Process Information') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach($process_details as $process_detail)
                        @foreach($process_detail as $key => $value)
                            @if ($key == "assigner_id")
                                @if (Auth::id() == $value || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                <form action="{{ route('processform.edit', ['process' => $process_detail->{'Process ID'}]) }}" method="POST">
                                    {{ csrf_field() }}
                        
                                    <button type="submit" id="add-{{ $process_detail->{'Process ID'} }}" class="editBtn">
                                        <i class="fa fa-btn fa-trash"></i>Edit
                                    </button>
                                </form>
                                @endif
                            @else
                            <div>
                                {{ $key }} {{ __(":") }} {{ $value }} 
                            </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @foreach ($ms_details as $ms_detail)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($ms_detail->massspec_id === NULL)
                    <div>
                        {{ __("Mass Spectometry: Not Requested") }}
                    </div>
                    @elseif ($ms_detail->massspec_id > 0 AND $ms_detail->cancelled == 1)
                    <div>
                        {{ __("Mass Spectometry: Cancelled") }} 
                    </div>
                    @else
                    <div>
                    <table class="table">
                        <thead>
                            <th>Mass Spectometry</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="table-text"><div>{{ __("MS ID:") }}</div></td>
                                <td class="table-text"><div>{{ __("Date Requested:") }}</div></td>
                                <td class="table-text"><div>{{ __("Date Submitted:") }}</div></td>
                                <td class="table-text"><div>{{ __("Download Link:") }}</div></td>
                                <td class="table-text"><div></div></td>
                            </tr>
                            <tr>
                                <td class="table-text">
                                    <a class="nav_link" href="{{ route('massspec.index', ['massspec' => $ms_detail->massspec_id, 'process_id' => $process_id]) }}">{{ $ms_detail->massspec_id }}</a>
                                </td>
                                <td class="table-text"><div>{{ $ms_detail->date_requested }}</div></td> 
                                <td class="table-text"><div>{{ $ms_detail->date_submitted }}</div></td> 
                                @if($ms_detail->link_processed_spec != "")
                                <td class="table-text">
                                    <form action="{{ route('process.download', ['id' => $ms_detail->massspec_id, 'process_id' => $process_id, 'supplier_id' => $supplier_id, 'download' => 'MS']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $ms_detail->massspec_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                </td>
                                @else
                                <td class="table-text"><div>{{ $ms_detail->link_processed_spec }}</div></td>
                                @endif
                                <td>
                                    @if (in_array(config('global.role_chemist'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                    <form action="{{ route('massspecform.add', ['massspec' => $ms_detail->massspec_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="add-{{ $ms_detail->massspec_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Edit
                                        </button>
                                    </form>
                                    @endif
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach ($nmr_details as $nmr_detail)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($nmr_detail->nmr_id === NULL)
                    <div>
                        {{ __("NMR: Not Requested") }}
                    </div>
                    @elseif ($nmr_detail->nmr_id > 0 AND $nmr_detail->cancelled == 1)
                    <div>
                        {{ __("NMR: Cancelled") }} 
                    </div>
                    @else
                    <div>
                    <table class="table">
                        <thead>
                            <th>NMR</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="table-text"><div>{{ __("NMR ID:") }}</div></td>
                                <td class="table-text"><div>{{ __("Date Requested:") }}</div></td>
                                <td class="table-text"><div>{{ __("Date Submitted:") }}</div></td>
                                <td class="table-text"><div>{{ __("Download Link:") }}</div></td>
                                <td class="table-text"><div></div></td>
                            </tr>
                            <tr>
                                <td class="table-text"><div>{{ $nmr_detail->nmr_id }}</div></td>
                                <td class="table-text"><div>{{ $nmr_detail->date_requested }}</div></td> 
                                <td class="table-text"><div>{{ $nmr_detail->date_submitted }}</div></td> 
                                @if($nmr_detail->link_folder != "")
                                <td class="table-text">
                                    <form action="{{ route('process.download', ['id' => $nmr_detail->nmr_id, 'process_id' => $process_id, 'supplier_id' => $supplier_id, 'download' => 'NMR']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $nmr_detail->nmr_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                </td>
                                @else
                                <td class="table-text"><div>{{ $nmr_detail->link_folder }}</div></td>
                                @endif
                                <td>
                                    @if (in_array(config('global.role_chemist'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                    <form action="{{ route('nmrform.add', ['nmr' => $nmr_detail->nmr_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="add-{{ $nmr_detail->nmr_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Edit
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach ($bioassay_details as $bioassay_detail)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($bioassay_detail->{"Date Received"} === NULL)
                    <div>
                        {{ __("Bioassay: Not Requested") }}
                    </div>
                    @elseif ($bioassay_detail->process_id != NULL AND $bioassay_detail->cancelled == 1)
                    <div>
                        {{ __("Bioassay: Cancelled") }} 
                    </div>
                    @else
                    <div>
                    <table class="table">
                        <thead>
                            <th>Bioassay</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @php
                            $edit_process_id = NULL;
                            $add_process_id = NULL;
                            @endphp
                            @foreach($bioassay_detail as $key => $value)
                                @if ($key == "process_id" or $key == "supplier_id" or $key == "cancelled" or $key == "assigner_id")
                                @elseif ($key == "PK Requested")
                                <tr>
                                    <td class="table-text"><div>{{ $key }}</div></td>
                                    <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                </tr>
                                @elseif ($key == "submitter_bioassay")
                                    @if (Auth::id() == $value || in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                    @php
                                    $edit_process_id = $bioassay_detail->process_id
                                    @endphp
                                    @endif
                                @elseif ($key == "Responsible PI")
                                    @if ($value === NULL)
                                    @php
                                    $add_process_id = $bioassay_detail->process_id
                                    @endphp
                                    @endif
                                @elseif ($value === NULL)
                                @else
                                <tr>
                                    <td class="table-text"><div>{{ $key }}</div></td>
                                    <td class="table-text"><div>{{ $value }}</div></td>
                                </tr>
                                @endif
                            </tr>
                            @endforeach
                            @if ($edit_process_id != NULL)
                            <tr>
                                <td class="table-text"><div></div></td>
                                <td class="table-text">
                                    <form action="{{ route('bioassayform.add', ['bioassay' => $edit_process_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="add-{{ $edit_process_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Edit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @elseif ((in_array(config('global.role_process'), Auth::user()->getRoles()) || in_array(config('global.role_admin'), Auth::user()->getRoles())) AND $add_process_id != NULL)
                            <tr>
                                <td class="table-text"><div></div></td>
                                <td class="table-text">
                                    <form action="{{ route('bioassayform.add', ['bioassay' => $bioassay_detail->process_id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="add-{{ $bioassay_detail->process_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Add
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if ($hplc_details->count() > 0)
    @foreach ($hplc_details as $hplc_detail)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($hplc_detail->date_requested === NULL)
                    <div>
                        {{ __("HPLC: Not Requested") }}
                    </div>
                    @elseif ($hplc_detail->date_requested != NULL AND $hplc_detail->cancelled == 1)
                    <div>
                        {{ __("HPLC: Cancelled") }} 
                    </div>
                    @else
                    <div>
                    <table class="table">
                        <thead>
                            <th>HPLC</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="table-text"><div>{{ __("HPLC ID:") }}</div></td>
                                <td class="table-text"><div>{{ __("Date Requested:") }}</div></td>
                                <td class="table-text"><div>{{ __("Date Submitted:") }}</div></td>
                                <td class="table-text"><div>{{ __("Diluent:") }}</div></td>
                                <td class="table-text"><div>{{ __("UV Trace Link:") }}</div></td>
                                <td class="table-text"><div>{{ __("Report Link:") }}</div></td>
                                <td class="table-text"><div></div></td>
                            </tr>
                            <tr>
                                <td class="table-text"><div>{{ $hplc_detail->hplc_id }}</div></td>
                                <td class="table-text"><div>{{ $hplc_detail->date_requested }}</div></td> 
                                <td class="table-text"><div>{{ $hplc_detail->date_submitted }}</div></td>
                                <td class="table-text"><div>{{ $hplc_detail->diluent }}</div></td> 
                                @if($hplc_detail->link_uvtrace != "")
                                <td class="table-text">
                                    <form action="{{ route('process.download', ['id' => $hplc_detail->hplc_id, 'process_id' => $process_id, 'supplier_id' => $supplier_id, 'download' => 'UV']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $hplc_detail->hplc_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                </td>
                                @else
                                <td class="table-text"><div>{{ $hplc_detail->link_uvtrace }}</div></td>
                                @endif
                                @if($hplc_detail->link_report != "")
                                <td class="table-text">
                                    <form action="{{ route('process.download', ['id' => $hplc_detail->hplc_id, 'process_id' => $process_id, 'supplier_id' => $supplier_id, 'download' => 'REP']) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="download-{{ $hplc_detail->hplc_id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Download
                                        </button>
                                    </form>
                                </td>
                                @else
                                <td class="table-text"><div>{{ $hplc_detail->link_report }}</div></td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        {{ __("HPLC: Not Requested") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>