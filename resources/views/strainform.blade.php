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
            {{ __('Strain Form') }}
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
                @if ($strain->exists())
                    @if ($strain->cultivation_media == NULL)
                        <form action="{{ route('strainform.store') }}" method="POST">
                    @else
                        <form action="{{ route('strainform.update', $strain) }}" method="POST">
                        @method('put')
                    @endif
                @else
                    <form action="{{ route('strainform.store') }}" method="POST">
                @endif
                    @csrf

                    <!-- Strain Name -->
                    <div class="form-group">
                        <label for="strain_name" class="col-sm-3 text-gray-900">Strain Name</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="strain_name" id="strain_name" class="form-control" value="{{ old('strain_name', $strain->strain_id)}}" required>
                        </div>

                        <x-input-error :messages="$errors->get('strain_name')" class="mt-2" />
                    </div>

                    <!-- Cultivation Media -->
                    <div class="form-group">
                        <label for="media_strain" class="col-sm-3 control-label">Cultivation Media</label>
        
                        <div class="col-sm-6">
                            <input type="text" name="media_strain" list="media_strain" required value={{old('media_strain', $strain->cultivation_media) }}>
                            <datalist id="media_strain">
                                @foreach($medias as $media)
                                <option value="{{ $media }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <!-- Species -->
                    <div class="form-group">
                        <label for="species_strain" class="col-sm-3 control-label">Species</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="species_strain" id="species_strain" class="form-control" value="{{ old('species_strain')}}">
                                @foreach($taxonomies as $taxonomy)
                                    @if ($taxonomy->rank_id == 13)
                                    <option value="{{ $taxonomy->taxonomy_id }}" {{(old('species_strain', $strain->taxonomy_id) == $taxonomy->taxonomy_id) ? 'selected' : ''}}>{{ $taxonomy->taxon_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Strain
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>