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
            {{ __('Location Form') }}
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
                <form action="{{ route('locationform.store') }}" method="POST">
                    @csrf

                    <!-- Country -->
                    <div class="form-group">
                        <label for="country_location" class="col-sm-3 control-label">Country</label>
                        <div class="col-sm-6">
                            <select type="text" name="country_location" id="country_location" class="form-control">
                                <option value="SELECTED">Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->country_id }}" {{(old('country_location')) ? 'selected' : ''}}>{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Region -->
                    <div class="form-group" id="drop_region" style="display: none">
                        <label for="region_location" class="col-sm-3 control-label">Region</label>
                        <div class="col-sm-6">
                            <select type="text" name="region_location" id="region_location" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- City -->
                    <div class="form-group" id="drop_city" style="display: none">
                        <label for="city_location" class="col-sm-3 control-label">City</label>
                        <div class="col-sm-6">
                            <select type="text" name="city_location" id="city_location" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Local Area -->
                    <div class="form-group" id="drop_localarea" style="display: none">
                        <label for="localarea_location" class="col-sm-3 control-label">Local Area</label>
                        <div class="col-sm-6">
                            <select type="text" name="localarea_location" id="localarea_location" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Station -->
                    <div class="form-group" id="drop_station" style="display: none">
                        <label for="station_location" class="col-sm-3 control-label">Station</label>
                        <div class="col-sm-6">
                            <select type="text" name="station_location" id="station_location" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Site -->
                    <div class="form-group" id="drop_site" style="display: none">
                        <label for="site_location" class="col-sm-3 control-label">Site Location</label>
                        <div class="col-sm-6">
                            <select type="text" name="site_location" id="site_location" class="form-control">
                            </select>
                        </div>
                    </div>

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            $('#country_location').on('change', function () {
                                var idCountry = this.value;
                                alert(idCountry);
                                if (idCountry != 'SELECTED') {
                                    $("#region_location").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-regions')}}",
                                        type: "POST",
                                        data: {
                                            country_id: idCountry,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#region_location').html('<option value="SELECTED">Select Region</option>');
                                            $.each(result.regions, function (key, value) {
                                                $("#region_location").append('<option value="' + value
                                                    .region_id + '">' + value.region_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#region_location').on('change', function () {
                                var idRegion = this.value;
                                if (idRegion != 'SELECTED') {
                                    $("#city_location").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-cities')}}",
                                        type: "POST",
                                        data: {
                                            region_id: idRegion,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#city_location').html('<option value=-2>Select City</option>' + '<option value=-1>Other</option>');
                                            $.each(result.cities, function (key, value) {
                                                $("#city_location").append('<option value="' + value
                                                    .city_id + '">' + value.city_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#city_location').on('change', function () {
                                var idCity = this.value;
                                if (idCity > 0) {
                                    $("#localarea_location").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-localareas')}}",
                                        type: "POST",
                                        data: {
                                            city_id: idCity,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#localarea_location').html('<option value=-2>Select Local Area</option>' + '<option value=-1>Other</option>');
                                            $.each(result.localareas, function (key, value) {
                                                $("#localarea_location").append('<option value="' + value
                                                    .localarea_id + '">' + value.localarea_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#localarea_location').on('change', function () {
                                var idLocalarea = this.value;
                                if (idLocalarea != -1) {
                                    $("#station_location").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-stations')}}",
                                        type: "POST",
                                        data: {
                                            localarea_id: idLocalarea,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#station_location').html('<option value=-2>Select Station</option>' + '<option value=-1>Other</option>');
                                            $.each(result.stations, function (key, value) {
                                                $("#station_location").append('<option value="' + value
                                                    .station_id + '">' + value.station_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#station_location').on('change', function () {
                                var idStation = this.value;
                                if (idStation > 0) {
                                    $("#site_location").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-sites')}}",
                                        type: "POST",
                                        data: {
                                            station_id: idStation,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#site_location').html('<option value=-2>Select Site</option>' + '<option value=-1>Other</option>');
                                            $.each(result.sites, function (key, value) {
                                                $("#site_location").append('<option value="' + value
                                                    .site_id + '">' + value.latitude + ' , ' + value.longitude + ' , ' + value.depth_min + ' , ' + value.depth_max + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                        });
                    </script>

                    <div class="form-group" id="see_city" style="display: none">
                        <label for="city_new" class="col-sm-3 control-label" id="city_new_lab">New City</label>
                        <div class="col-sm-6">
                            <input type="text" name="city_new" id="city_new" class="form-control" value="{{ old('city_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_localarea" style="display: none">
                        <label for="localarea_new" class="col-sm-3 control-label" id="localarea_new_lab">New Local Area</label>
                        <div class="col-sm-6">
                            <input type="text" name="localarea_new" id="localarea_new" class="form-control" value="{{ old('localarea_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_station" style="display: none">
                        <label for="station_new" class="col-sm-3 control-label" id="station_new_lab">New Station</label>
                        <div class="col-sm-6">
                            <input type="text" name="station_new" id="station_new" class="form-control" value="{{ old('station_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_site" style="display: none">
                        <label for="latitude_new" class="col-sm-3 control-label" id="latitude_new_lab">Latitude</label>
                        <div class="col-sm-6">
                            <input type="text" name="latitude_new" id="latitude_new" class="form-control" value="{{ old('latitude_new')}}">
                        </div>

                        <label for="longitude_new" class="col-sm-3 control-label" id="longitude_new_lab">Longitude</label>
                        <div class="col-sm-6">
                            <input type="text" name="longitude_new" id="longitude_new" class="form-control" value="{{ old('longitude_new')}}">
                        </div>

                        <label for="depthmin_new" class="col-sm-3 control-label" id="depthmin_new_lab">Minimum Depth</label>
                        <div class="col-sm-6">
                            <input type="text" name="depthmin_new" id="depthmin_new" class="form-control" value="{{ old('depthmin_new')}}">
                        </div>

                        <label for="depthmax_new" class="col-sm-3 control-label" id="depthmax_new_lab">Maximum Depth</label>
                        <div class="col-sm-6">
                            <input type="text" name="depthmax_new" id="depthmax_new" class="form-control" value="{{ old('depthmax_new')}}">
                        </div>
                    </div>

                    <script>
                        let allBoxes = ["country", "region", "city", "localarea", "station", "site"];
                        let country_level = document.getElementById("country_location");
                        let region_level = document.getElementById("region_location");
                        let city_level = document.getElementById("city_location");
                        let localarea_level = document.getElementById("localarea_location");
                        let station_level = document.getElementById("station_location");
                        let site_level = document.getElementById("site_location");
                        country_level.addEventListener("change", function() {
                            if (country_level.value == 'SELECTED') {
                                // window.alert("Select level");
                                let country_see = allBoxes.slice(2);
                                for (see_box of country_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                let country_drop = allBoxes.slice(1);
                                for (see_box of country_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                };
                            } else {
                                // window.alert("Hello");
                                let country_see = allBoxes.slice(2);
                                for (see_box of country_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                document.getElementById("drop_region").style.display='block';
                            }
                        });
                        region_level.addEventListener("change", function() {
                            if (region_level.value == 'SELECTED') {
                                let my_see = allBoxes.slice(2);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                let my_drop = allBoxes.slice(2);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                };
                            } else {
                                let region_see = allBoxes.slice(2);
                                for (see_box of region_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                document.getElementById("drop_city").style.display='block';
                            }
                        });
                        city_level.addEventListener("change", function() {
                            if (city_level.value == -1) {
                                // Show all new textboxes
                                let my_see = allBoxes.slice(2);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                };
                                let my_drop = allBoxes.slice(3);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                };
                            } else if (city_level.value == -2) {
                                let my_see = allBoxes.slice(2);
                                //window.alert(my_see);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                let my_drop = allBoxes.slice(4);
                                for (see_box3 of my_drop) {
                                    document.getElementById("drop_" + see_box3).style.display='none';
                                };
                            } else {
                                let region_see = allBoxes.slice(2);
                                for (see_box of region_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                document.getElementById("drop_localarea").style.display='block';
                            }
                        });
                        localarea_level.addEventListener("change", function() {
                            if (localarea_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(3);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(4);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (localarea_level.value == -2) {
                                my_see = allBoxes.slice(3);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                my_drop = allBoxes.slice(4);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                let region_see = allBoxes.slice(2);
                                for (see_box of region_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                document.getElementById("drop_station").style.display='block';
                            }
                        });
                        station_level.addEventListener("change", function() {
                            if (station_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(4);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(5);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (station_level.value == -2) {
                                my_see = allBoxes.slice(4);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                my_drop = allBoxes.slice(5);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                let region_see = allBoxes.slice(2);
                                for (see_box of region_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                document.getElementById("drop_site").style.display='block';
                            }
                        });
                        site_level.addEventListener("change", function() {
                            if (site_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(5);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                            } else if (site_level.value == -2) {
                                my_see = allBoxes.slice(5);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                my_drop = allBoxes.slice(6);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                let region_see = allBoxes.slice(2);
                                for (see_box of region_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                            }
                        });
                    </script>

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Location
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>