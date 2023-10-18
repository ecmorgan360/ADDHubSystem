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
            {{ __('Orphan Fractions Page') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                {{ __("Search by date:") }}
                    <form action="{{ route('report.orphanfractionResult') }}" method="POST">
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

    @if ($result_fractions->count() > 0)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                            <th>Orphan fractions - source IDs have not been added as extracts or fractions</th>
                            <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($result_fractions[0]), true)) as $colnameArr => $colname)
                                @if($colname != "Bioassay ID")
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            <td class="table-text"><div></div></td>
                            </tr>
                            @foreach ($result_fractions as $result)
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
                <div>
                    <form action="{{ route('exportOrphanFractions') }}" method="POST" target= "__blank">
                        @csrf
                    <div class="form-group">
                        <input type="hidden" name="start_date" id="start_date" class="form-control" value="{{$startDate}}">
                        <input type="hidden" name="end_date" id="end_date" class="form-control" value="{{$endDate}}">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn" id="mybutton">
                                <i class="fa fa-plus"></i> Export Orphan Fractions
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>