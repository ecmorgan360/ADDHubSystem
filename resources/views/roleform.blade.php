<x-app-layout>
<style>
    div.form-group {
        padding: 5px 20px;
    }
    select, input[type="text"]{
      width:25%;
      box-sizing:border-box;
    }

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
            {{ __('Assign Roles Form') }}
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
                <form action="{{ route('roleform.store') }}" method="POST">

                    @csrf

                    <!-- Role Name -->
                    <div class="form-group">
                        <label for="group_name" class="col-sm-3 control-label">Role Name</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="role_assign" id="role_assign" class="form-control">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{old('role_assign') ? 'selected' : ''}}>{{ $role->role }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- User Name -->
                    <div class="form-group">
                        <label for="group_name" class="col-sm-3 control-label">User Name</label>
        
                        <div class="col-sm-6">
                            <select type="text" name="user_assign" id="user_assign" class="form-control">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{old('user_assign') ? 'selected' : ''}}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
        
                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="editBtn">
                                <i class="fa fa-plus"></i> Add Role
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($assignedRoles->count() > 0)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <th>Currently Assigned Roles</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                            <tr>
                            @foreach (array_keys(json_decode(json_encode($assignedRoles[0]), true)) as $colnameArr => $colname)
                                @if($colname != "mgf_id" and $colname != "submitter_fraction" and $colname != "submitter_derivedpurecomp" )
                                <td class="table-text"><div>{{ $colname }}</div></td>
                                @endif
                            @endforeach
                            <td class="table-text"></td>
                            </tr>
                            @foreach ($assignedRoles as $result)
                                <tr>
                                    @foreach($result as $key => $value)
                                    @if($key == "mgf_id")
                                    @elseif($key == "Existing Literature" or $key == "Synthesis Potential" or $key == "Existing Patent")
                                    <td class="table-text"><div>{{ $value ? 'Yes' : 'No' }}</div></td>
                                    @else
                                    <td class="table-text"><div>{{ $value }}</div></td>
                                    @endif
                                    @endforeach

                                    @if (in_array(config('global.role_admin'), Auth::user()->getRoles()))
                                    <td class="table-text">
                                    <form action="{{ route('roleform.remove', ['roleuser' => $result->id]) }}" method="POST">
                                        {{ csrf_field() }}
                            
                                        <button type="submit" id="remove-{{ $result->id }}" class="editBtn">
                                            <i class="fa fa-btn fa-trash"></i>Remove
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
</x-app-layout>