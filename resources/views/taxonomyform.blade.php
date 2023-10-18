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
            {{ __('Taxonomic ID Form') }}
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
                <form action="{{ route('taxonomyform.store') }}" method="POST">
                    @csrf

                    <!-- Kingdom -->
                    <div class="form-group">
                        <label for="kingdom" class="col-sm-3 control-label">Kingdom</label>
                        <div class="col-sm-6">
                            <select type="text" name="kingdom" id="kingdom" class="form-control">
                                <option value=-2>Select Kingdom</option>
                                @foreach($taxonomies as $taxonomy)
                                @if($taxonomy->rank_id == 1)
                                <option value="{{ $taxonomy->taxonomy_id }}" {{(old('kingdom')) ? 'selected' : ''}}>{{ $taxonomy->taxon_name }}</option>
                                @endif
                                @endforeach
                                <option value=-1  {{(old('kingdom')) ? 'selected' : ''}}>Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Phylum -->
                    <div class="form-group" id="drop_phylum" style="display: none">
                        <label for="phylum" class="col-sm-3 control-label">Phylum</label>
                        <div class="col-sm-6">
                            <select type="text" name="phylum" id="phylum" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Subphylum -->
                    <div class="form-group" id="drop_subphylum" style="display: none">
                        <label for="subphylum" class="col-sm-3 control-label">Subphylum</label>
                        <div class="col-sm-6">
                            <select type="text" name="subphylum" id="subphylum" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Class -->
                    <div class="form-group" id="drop_class" style="display: none">
                        <label for="tax_class" class="col-sm-3 control-label">Class</label>
                        <div class="col-sm-6">
                            <select type="text" name="tax_class" id="tax_class" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Subclass -->
                    <div class="form-group" id="drop_subclass" style="display: none">
                        <label for="subclass" class="col-sm-3 control-label">Subclass</label>
                        <div class="col-sm-6">
                            <select type="text" name="subclass" id="subclass" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Superorder -->
                    <div class="form-group" id="drop_superorder" style="display: none">
                        <label for="superorder" class="col-sm-3 control-label">Superorder</label>
                        <div class="col-sm-6">
                            <select type="text" name="superorder" id="superorder" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Order -->
                    <div class="form-group" id="drop_order" style="display: none">
                        <label for="order" class="col-sm-3 control-label">Order</label>
                        <div class="col-sm-6">
                            <select type="text" name="order" id="order" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Suborder -->
                    <div class="form-group" id="drop_suborder" style="display: none">
                        <label for="suborder" class="col-sm-3 control-label">Suborder</label>
                        <div class="col-sm-6">
                            <select type="text" name="suborder" id="suborder" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Family -->
                    <div class="form-group" id="drop_family" style="display: none">
                        <label for="family" class="col-sm-3 control-label">Family</label>
                        <div class="col-sm-6">
                            <select type="text" name="family" id="family" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Subfamily -->
                    <div class="form-group" id="drop_subfamily" style="display: none">
                        <label for="subfamily" class="col-sm-3 control-label">Subfamily</label>
                        <div class="col-sm-6">
                            <select type="text" name="subfamily" id="subfamily" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Genus -->
                    <div class="form-group" id="drop_genus" style="display: none">
                        <label for="genus" class="col-sm-3 control-label">Genus</label>
                        <div class="col-sm-6">
                            <select type="text" name="genus" id="genus" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Subgenus -->
                    <div class="form-group" id="drop_subgenus" style="display: none">
                        <label for="subgenus" class="col-sm-3 control-label">Subgenus</label>
                        <div class="col-sm-6">
                            <select type="text" name="subgenus" id="subgenus" class="form-control">
                            </select>
                        </div>
                    </div>

                    <!-- Species -->
                    <div class="form-group" id="drop_species" style="display: none">
                        <label for="species" class="col-sm-3 control-label">Species</label>
                        <div class="col-sm-6">
                            <select type="text" name="species" id="species" class="form-control">
                            </select>
                        </div>
                    </div>

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            $('#kingdom').on('change', function () {
                                var idKingdom = this.value;
                                if (idKingdom > -1) {
                                    $("#phylum").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-phylums')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idKingdom,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#phylum').html('<option value=-2>Select Phylum</option>' + '<option value=-1>Other</option>');
                                            $.each(result.phylums, function (key, value) {
                                                $("#phylum").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#phylum').on('change', function () {
                                var idPhylum = this.value;
                                if (idPhylum != -1) {
                                    $("#subphylum").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-subphylums')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idPhylum,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#subphylum').html('<option value=-2>Select Subphylum</option>' + '<option value=-1>Other</option>' + '<option value=0>None</option>');
                                            $.each(result.subphylums, function (key, value) {
                                                $("#subphylum").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                    $("#tax_class").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-classes')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idPhylum,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#tax_class').html('<option value=-2>Select Class</option>' + '<option value=-1>Other</option>');
                                            $.each(result.classes, function (key, value) {
                                                $("#tax_class").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#subphylum').on('change', function () {
                                var idSubphylum = this.value;
                                if (idSubphylum > 0) {
                                    $("#tax_class").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-classes')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idSubphylum,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#tax_class').html('<option value=-2>Select Class</option>' + '<option value=-1>Other</option>');
                                            $.each(result.classes, function (key, value) {
                                                $("#tax_class").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#tax_class').on('change', function () {
                                var idTaxclass = this.value;
                                if (idTaxclass != -1) {
                                    $("#subclass").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-subclasses')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idTaxclass,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#subclass').html('<option value=-2>Select Subclass</option>' + '<option value=-1>Other</option>' + '<option value=0>None</option>');
                                            $.each(result.subclasses, function (key, value) {
                                                $("#subclass").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                    $("#superorder").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-superorders')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idTaxclass,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#superorder').html('<option value=-2>Select Superorder</option>' + '<option value=-1>Other</option>' + '<option value=0>None</option>');
                                            $.each(result.superorders, function (key, value) {
                                                $("#superorder").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                    $("#order").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-orders')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idTaxclass,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#order').html('<option value=-2>Select Order</option>' + '<option value=-1>Other</option>');
                                            $.each(result.orders, function (key, value) {
                                                $("#order").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#subclass').on('change', function () {
                                var idSubclass = this.value;
                                if (idSubclass > 0) {
                                    $("#superorder").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-superorders')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idSubclass,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#superorder').html('<option value=-2>Select Superorder</option>' + '<option value=-1>Other</option>' + '<option value=0>None</option>');
                                            $.each(result.superorders, function (key, value) {
                                                $("#superorder").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                    $("#order").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-orders')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idSubclass,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#order').html('<option value=-2>Select Order</option>' + '<option value=-1>Other</option>');
                                            $.each(result.orders, function (key, value) {
                                                $("#order").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#superorder').on('change', function () {
                                var idSuperorder = this.value;
                                if (idSuperorder > 0) {
                                    $("#order").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-orders')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idSuperorder,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#order').html('<option value=-2>Select Order</option>' + '<option value=-1>Other</option>');
                                            $.each(result.orders, function (key, value) {
                                                $("#order").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#order').on('change', function () {
                                var idOrder = this.value;
                                if (idOrder != -1) {
                                    $("#suborder").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-suborders')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idOrder,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#suborder').html('<option value=-2>Select Suborder</option>' + '<option value=-1>Other</option>' + '<option value=0>None</option>');
                                            $.each(result.suborders, function (key, value) {
                                                $("#suborder").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                    $("#family").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-families')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idOrder,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#family').html('<option value=-2>Select Family</option>' + '<option value=-1>Other</option>');
                                            $.each(result.families, function (key, value) {
                                                $("#family").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#suborder').on('change', function () {
                                var idSuborder = this.value;
                                if (idSuborder > 0) {
                                    $("#family").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-families')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idSuborder,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#family').html('<option value=-2>Select Family</option>' + '<option value=-1>Other</option>');
                                            $.each(result.families, function (key, value) {
                                                $("#family").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#family').on('change', function () {
                                var idFamily = this.value;
                                if (idFamily != -1) {
                                    $("#subfamily").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-subfamilies')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idFamily,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#subfamily').html('<option value=-2>Select Subfamily</option>' + '<option value=-1>Other</option>' + '<option value=0>None</option>');
                                            $.each(result.subfamilies, function (key, value) {
                                                $("#subfamily").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                    $("#genus").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-geni')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idFamily,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#genus').html('<option value=-2>Select Genus</option>' + '<option value=-1>Other</option>');
                                            $.each(result.geni, function (key, value) {
                                                $("#genus").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#subfamily').on('change', function () {
                                var idSubfamily = this.value;
                                if (idSubfamily > 0) {
                                    $("#genus").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-geni')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idSubfamily,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#genus').html('<option value=-2>Select Genus</option>' + '<option value=-1>Other</option>');
                                            $.each(result.geni, function (key, value) {
                                                $("#genus").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#genus').on('change', function () {
                                var idGenus = this.value;
                                if (idGenus != -1) {
                                    $("#subgenus").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-subgeni')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idGenus,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#subgenus').html('<option value=-2>Select Subgenus</option>' + '<option value=-1>Other</option>' + '<option value=0>None</option>');
                                            $.each(result.subgeni, function (key, value) {
                                                $("#subgenus").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                    $("#species").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-species')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idGenus,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#species').html('<option value=-2>Select Species</option>' + '<option value=-1>Other</option>');
                                            $.each(result.species, function (key, value) {
                                                $("#species").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
                                            });
                                        },
                                        error: function(jqxhr, status, exception) {
                                            alert('Exception:', exception);
                                        }
                                    });
                                }
                            });
                            $('#subgenus').on('change', function () {
                                var idSubgenus = this.value;
                                if (idSubgenus > 0) {
                                    $("#species").html('');
                                    $.ajax({
                                        url: "{{url('api/fetch-species')}}",
                                        type: "POST",
                                        data: {
                                            taxonomy_id: idSubgenus,
                                            _token: '{{csrf_token()}}'
                                        },
                                        dataType: 'json',
                                        success: function (result) {
                                            $('#species').html('<option value=-2>Select Species</option>' + '<option value=-1>Other</option>');
                                            $.each(result.species, function (key, value) {
                                                $("#species").append('<option value="' + value
                                                    .taxonomy_id + '">' + value.taxon_name + '</option>');
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

                    <div class="form-group" id="see_kingdom" style="display: none">
                        <label for="kingdom_new" class="col-sm-3 control-label" id="kingdom_new_lab">New Kingdom</label>
                        <div class="col-sm-6">
                            <input type="text" name="kingdom_new" id="kingdom_new" class="form-control" value="{{ old('kingdom_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_phylum" style="display: none">
                        <label for="phylum_new" class="col-sm-3 control-label" id="phylum_new_lab">New Phylum</label>
                        <div class="col-sm-6">
                            <input type="text" name="phylum_new" id="phylum_new" class="form-control" value="{{ old('phylum_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_subphylum" style="display: none">
                        <label for="subphylum_new" class="col-sm-3 control-label" id="subphylum_new_lab">New Subphylum</label>
                        <div class="col-sm-6">
                            <input type="text" name="subphylum_new" id="subphylum_new" class="form-control" value="{{ old('subphylum_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_class" style="display: none">
                        <label for="class_new" class="col-sm-3 control-label" id="class_new_lab">New Class</label>
                        <div class="col-sm-6">
                            <input type="text" name="class_new" id="class_new" class="form-control" value="{{ old('class_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_subclass" style="display: none">
                        <label for="subclass_new" class="col-sm-3 control-label" id="subclass_new_lab">New Subclass</label>
                        <div class="col-sm-6">
                            <input type="text" name="subclass_new" id="subclass_new" class="form-control" value="{{ old('subclass_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_superorder" style="display: none">
                        <label for="superorder_new" class="col-sm-3 control-label" id="superorder_new_lab">New Superorder</label>
                        <div class="col-sm-6">
                            <input type="text" name="superorder_new" id="superorder_new" class="form-control" value="{{ old('superorder_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_order" style="display: none">
                        <label for="order_new" class="col-sm-3 control-label" id="order_new_lab">New Order</label>
                        <div class="col-sm-6">
                            <input type="text" name="order_new" id="order_new" class="form-control" value="{{ old('order_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_suborder" style="display: none">
                        <label for="suborder_new" class="col-sm-3 control-label" id="suborder_new_lab">New Suborder</label>
                        <div class="col-sm-6">
                            <input type="text" name="suborder_new" id="suborder_new" class="form-control" value="{{ old('suborder_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_family" style="display: none">
                        <label for="family_new" class="col-sm-3 control-label" id="family_new_lab">New Family</label>
                        <div class="col-sm-6">
                            <input type="text" name="family_new" id="family_new" class="form-control" value="{{ old('family_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_subfamily" style="display: none">
                        <label for="subfamily_new" class="col-sm-3 control-label" id="subfamily_new_lab">New Subfamily</label>
                        <div class="col-sm-6">
                            <input type="text" name="subfamily_new" id="subfamily_new" class="form-control" value="{{ old('subfamily_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_genus" style="display: none">
                        <label for="genus_new" class="col-sm-3 control-label" id="genus_new_lab">New Genus</label>
                        <div class="col-sm-6">
                            <input type="text" name="genus_new" id="genus_new" class="form-control" value="{{ old('genus_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_subgenus" style="display: none">
                        <label for="subgenus_new" class="col-sm-3 control-label" id="subgenus_new_lab">New Subgenus</label>
                        <div class="col-sm-6">
                            <input type="text" name="subgenus_new" id="subgenus_new" class="form-control" value="{{ old('subgenus_new')}}">
                        </div>
                    </div>

                    <div class="form-group" id="see_species" style="display: none">
                        <label for="species_new" class="col-sm-3 control-label" id="species_new_lab">New Species</label>
                        <div class="col-sm-6">
                            <input type="text" name="species_new" id="species_new" class="form-control" value="{{ old('species_new')}}">
                        </div>
                    </div>


                    <script>
                        let allBoxes = ["kingdom", "phylum", "subphylum", "class", "subclass", "superorder", "order", "suborder", "family", "subfamily", "genus", "subgenus", "species"];
                        let kingdom_level = document.getElementById("kingdom");
                        let phylum_level = document.getElementById("phylum");
                        let subphylum_level = document.getElementById("subphylum");
                        let class_level = document.getElementById("tax_class");
                        let subclass_level = document.getElementById("subclass");
                        let superorder_level = document.getElementById("superorder");
                        let order_level = document.getElementById("order");
                        let suborder_level = document.getElementById("suborder");
                        let family_level = document.getElementById("family");
                        let subfamily_level = document.getElementById("subfamily");
                        let genus_level = document.getElementById("genus");
                        let subgenus_level = document.getElementById("subgenus");
                        let species_level = document.getElementById("species");
                        kingdom_level.addEventListener("change", function() {
                            if (kingdom_level.value == -1) {
                                // Show all new textboxes
                                // allSees.slice(1);
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                };
                                let king_drop = allBoxes.slice(1);
                                for (see_box of king_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                };
                            } else if (kingdom_level.value == -2) {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                let king_drop = allBoxes.slice(1);
                                for (see_box of king_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                };
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                document.getElementById("drop_phylum").style.display='block';
                            }
                        });
                        phylum_level.addEventListener("change", function() {
                            if (phylum_level.value == -1) {
                                // Show all new textboxes
                                let my_see = allBoxes.slice(1);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                };
                                let my_drop = allBoxes.slice(2);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                };
                            } else if (phylum_level.value == -2) {
                                let my_see = allBoxes.slice(1);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                let my_drop = allBoxes.slice(2);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                };
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                document.getElementById("drop_subphylum").style.display='block';
                                document.getElementById("drop_class").style.display='block';
                            }
                        });
                        subphylum_level.addEventListener("change", function() {
                            if (subphylum_level.value == -1) {
                                // Show all new textboxes
                                let my_see = allBoxes.slice(2);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                };
                                let my_drop = allBoxes.slice(3);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                };
                            } else if (subphylum_level.value == -2) {
                                let my_see = allBoxes.slice(2);
                                //window.alert(my_see);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                let before_drop = allBoxes.slice(1, 4);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                
                                let my_drop = allBoxes.slice(4);
                                for (see_box3 of my_drop) {
                                    document.getElementById("drop_" + see_box3).style.display='none';
                                };
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                };
                                document.getElementById("drop_class").style.display='block';
                            }
                        });
                        class_level.addEventListener("change", function() {
                            if (class_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(3);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(4);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (class_level.value == -2) {
                                my_see = allBoxes.slice(3);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                my_drop = allBoxes.slice(4);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_subclass").style.display='block';
                                document.getElementById("drop_superorder").style.display='block';
                                document.getElementById("drop_order").style.display='block';
                            }
                        });
                        subclass_level.addEventListener("change", function() {
                            if (subclass_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(4);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(5);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (subclass_level.value == -2) {
                                my_see = allBoxes.slice(4);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 7);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(7);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_superorder").style.display='block';
                                document.getElementById("drop_order").style.display='block';
                            }
                        });
                        superorder_level.addEventListener("change", function() {
                            if (superorder_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(5);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(6);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (superorder_level.value == -2) {
                                my_see = allBoxes.slice(5);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 7);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(7);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_order").style.display='block';
                            }
                        });
                        order_level.addEventListener("change", function() {
                            if (order_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(6);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(7);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (order_level.value == -2) {
                                my_see = allBoxes.slice(6);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 7);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(7);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_suborder").style.display='block';
                                document.getElementById("drop_family").style.display='block';
                            }
                        });
                        suborder_level.addEventListener("change", function() {
                            if (suborder_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(7);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(8);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (suborder_level.value == -2) {
                                my_see = allBoxes.slice(7);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 9);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(9);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_family").style.display='block';
                            }
                        });
                        family_level.addEventListener("change", function() {
                            if (family_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(8);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(9);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (family_level.value == -2) {
                                my_see = allBoxes.slice(8);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 9);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(9);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_subfamily").style.display='block';
                                document.getElementById("drop_genus").style.display='block';
                            }
                        });
                        subfamily_level.addEventListener("change", function() {
                            if (subfamily_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(9);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(10);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (subfamily_level.value == -2) {
                                my_see = allBoxes.slice(9);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 11);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(11);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_genus").style.display='block';
                            }
                        });
                        genus_level.addEventListener("change", function() {
                            if (genus_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(10);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(11);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (genus_level.value == -2) {
                                my_see = allBoxes.slice(10);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 11);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(11);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_subgenus").style.display='block';
                                document.getElementById("drop_species").style.display='block';
                            }
                        });
                        subgenus_level.addEventListener("change", function() {
                            if (subgenus_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(11);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                                my_drop = allBoxes.slice(12);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else if (subgenus_level.value == -2) {
                                my_see = allBoxes.slice(11);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 13);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(13);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                document.getElementById("drop_species").style.display='block';
                            }
                        });
                        species_level.addEventListener("change", function() {
                            if (species_level.value == -1) {
                                // Show all new textboxes
                                my_see = allBoxes.slice(12);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='block';
                                }
                            } else if (species_level.value == -2) {
                                my_see = allBoxes.slice(12);
                                for (see_box of my_see) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                                let before_drop = allBoxes.slice(1, 13);
                                for (see_box2 of before_drop) {
                                    document.getElementById("drop_" + see_box2).style.display='block';
                                };
                                my_drop = allBoxes.slice(13);
                                for (see_box of my_drop) {
                                    document.getElementById("drop_" + see_box).style.display='none';
                                }
                            } else {
                                for (see_box of allBoxes) {
                                    document.getElementById("see_" + see_box).style.display='none';
                                }
                            }
                        });
                    </script>

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Taxonomy
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>