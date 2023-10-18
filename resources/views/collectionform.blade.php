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
            {{ __('Collection Form') }}
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
                @if ($collection->exists())
                    @if ($collection->date_collected == NULL)
                        <form action="{{ route('collectionform.store') }}" method="POST">
                    @else
                        <form action="{{ route('collectionform.update', $collection) }}" method="POST">
                        @method('put')
                    @endif
                @else
                    <form action="{{ route('collectionform.store') }}" method="POST">
                @endif
                    @csrf

                    <!-- Sample Name -->
                    <div class="form-group">
                        <label for="sample_name" class="col-sm-3 text-gray-900">Sample Name</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="sample_name" id="sample_name" class="form-control" value="{{ old('sample_name', $collection->sample_id)}}" required>
                        </div>

                        <x-input-error :messages="$errors->get('sample_name')" class="mt-2" />
                    </div>

                    <!-- Other IDs -->
                    <div class="form-group">
                        <label for="other_id_collect" class="col-sm-3 text-gray-900">Other IDs</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="other_id_collect" id="other_id_collect" class="form-control" value="{{ old('other_id_collect', $collection->other_ids)}}">
                        </div>
                    </div>

                    <!-- Collector Name -->
                    <div class="form-group">
                        <label for="collector_name" class="col-sm-3 control-label">Collector Names (Ctrl and Click all)</label>
                        <div class="col-sm-6">
                            <select type="text" name="collector_name[]" id="collector_name" class="form-control" multiple required>
                            @foreach($collectors as $collector)
                                @if($myCollectors != null)
                                    @php 
                                    $found = false;
                                    @endphp
                                    @foreach($myCollectors as $res)
                                        @if((collect(old('collector_name', $res->user_id))->contains($collector->id)))
                                        <option value="{{ $collector->id }}" selected>{{ $collector->name }}</option>
                                        @php 
                                        $found = true;
                                        @endphp
                                        @endif
                                    @endforeach
                                    @if(!$found)
                                    <option value="{{ $collector->id }}">{{ $collector->name }}</option>
                                    @endif
                                @else
                                <option value="{{ $collector->id }}" {{(old('collector_name') == $collector->id) ? 'selected' : ''}}>{{ $collector->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>

                     <!-- Date collected -->
                     <div class="form-group">
                        <label for="date_collected" class="col-sm-3 control-label">Date Sample Collected</label>
        
                        <div class="col-sm-6">
                            <input type="date" name="date_collected" id="date_collected" class="form-control" value="{{ old('date_collected', $collection->date_collected)}}" required>
                        </div>
                    </div>

                    <!-- Station and Site -->
                    <div class="form-group">
                        <label for="location_collection" class="col-sm-3 control-label">Location information</label>
        
                        <div class="col-sm-6">
                            <select id="location_collection" name="location_collection">
                                @foreach($stations as $station)
                                    <optgroup label="{{ $station->station_name }}">
                                    @foreach($sites as $site)
                                        @if ($site->station_id == $station->station_id)
                                        <option value="{{ $site->site_id }}" {{(old('location_collection', $collection->site_id) == $site->site_id) ? 'selected' : ''}}>Latitude: {{ $site->latitude }}, Longitude: {{ $site->longitude }}, Depth min: {{ $site->depth_min }}, Depth max: {{ $site->depth_max }}</option>
                                        @endif
                                    @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <!-- Identifier Name -->
                    <div class="form-group">
                        <label for="identifier_name" class="col-sm-3 control-label">Identifier Name</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="identifier_name" id="identifier_name" class="form-control" value="{{ old('identifier_name')}}">
                                @foreach($identifiers as $identifier)
                                <option value="{{ $identifier->id }}" {{(old('identifier_name', $collection->identifier_id) == $identifier->id) ? 'selected' : ''}}>{{ $identifier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Classification -->
                    <div class="form-group">
                        <label for="classification_collection" class="col-sm-3 control-label">Classification</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="classification_collection" list="classification_collection" required value={{old('classification_collection', $collection->classification) }}>
                            <datalist id="classification_collection">
                                @foreach($classifications as $classification)
                                <option value="{{ $classification }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Other Descriptions -->
                    <div class="form-group">
                        <label for="other_description" class="col-sm-3 control-label">Other Descriptions</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="other_description" id="other_description" class="form-control" value="{{ old('other_description', $collection->other_description)}}">
                        </div>
                    </div>

                    <!-- Species -->
                    <div class="form-group">
                        <label for="species_collection" class="col-sm-3 control-label">Species</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="species_collection" id="species_collection" class="form-control" value="{{ old('species_collection')}}">
                                @foreach($taxonomies as $taxonomy)
                                    @if ($taxonomy->rank_id == 13)
                                    <option value="{{ $taxonomy->taxonomy_id }}" {{(old('species_collection', $collection->taxonomy_id) == $taxonomy->taxonomy_id) ? 'selected' : ''}}>{{ $taxonomy->taxon_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Permit No -->
                    <div class="form-group">
                        <label for="permit_collection" class="col-sm-3 control-label">Permit Number</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="permit_collection" list="permit_collection" required value={{old('permit_collection', $collection->permit_no) }}>
                            <datalist id="permit_collection">
                                @foreach($permits as $permit)
                                <option value="{{ $permit }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Sample
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>