@extends('v3.backend.layouts.app')

@section('title') Profile ({{ ucwords($vars['user']->name) }}) | {{\App\Models\SysConfig::set()['system_title']}} @endsection

@section('css')

<style type="text/css">

</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
     <div class="col-lg-8">
        <div class="page-header-title">
           <i class="ik user ik-user bg-blue"></i>
           <div class="d-inline">
              <h5>{{ $vars['title'] }}</h5>
              <span>Here you can view and edit Staff User profile detailes.</span>
          </div>
      </div>
  </div>
  <div class="col-lg-4">
    <nav class="breadcrumb-container" aria-label="breadcrumb">
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="#"><i class="ik ik-home"></i></a>
         </li>
         <li class="breadcrumb-item">
             <a href="#">Profile</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">{{ ucwords($vars['user']->name) }}</li>
     </ol>
 </nav>
</div>
</div>
</div>

<div class="row">
    <div class="col-lg-5 col-md-5">
        <div class="card new-cust-card">
            <div class="card-body">
                <div class="text-center"> 
                    <img src="{{ url('/v3/avatars/admin/admin.png') }}" class="rounded-circle" width="150">
                    <h4 class="card-title mt-10">{{ ucwords($vars['user']->name) }}</h4>
                    <p class="text-muted">
                      {{ ucwords($vars['position']) }}
                    </p>
                    <div class="list-group mt-3">
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-4 text-right my-auto">
                                <b>Gender : </b>
                            </div>
                            <div class="col-md-8 text-left">
                                {{ ucwords($vars['user']->gender) }}
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-4 text-right my-auto">
                                <b>Email : </b>
                            </div>
                            <div class="col-md-8 text-left">
                                {{ ucwords($vars['user']->email) }}
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-4 text-right my-auto">
                                <b>Phone No. : </b>
                            </div>
                            <div class="col-md-8 text-left">
                                {{ ucwords($vars['user']->phone) }}
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-4 text-right my-auto">
                                <b>Living Area : </b>
                            </div>
                            <div class="col-md-8 text-left">
                                {{ ucwords($vars['user']->address) }}
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-4 text-right my-auto">
                                <b>Description : </b>
                            </div>
                            <div class="col-md-8 text-left">
                                {{ ucwords($vars['user']->description) }}
                            </div>
                            </div>
                        </a>
                    </div>
                    <button class="btn btn-primary btn-block mt-3" onClick="editUser('{{encrypt($vars['user']->id)}}')">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-7">
        <div class="card">
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="pills-setting-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="pills-setting" aria-selected="false">Roles</a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="pills-setting" aria-selected="false">Permissions</a>
                </li>
            </ul>
            <div class="tab-content" id="tabs-div">
                <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="{{ route('admins.update',encrypt($vars['user']->id)) }}">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <label for="role_id">Roles</label>
                                <input type="hidden" name="type" value="role_id">
                                <input type="hidden" name="editRolesOrPermissions" value="true">
                                <select class="form-control select2" id="role_id" name="role_id[]" multiple="multiple" data-placeholder="Select Roles" style="width: 100%;">
                                    @foreach ($vars['roles'] as $var)
                                        <option  value="{{ $var->id }}" {{ in_array($var->id, $vars['user']->roles->pluck('id')->toArray())? 'selected' : '' }} >{{ $var->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">Assign Roles</button>
                            </div>
                        </form>
                        @if(count($vars['user']->roles))
                            <hr/>
                            <p>User's Current Roles</p>
                            <ul>
                                @foreach ($vars['user']->roles as $role)
                                    <li>{{ ucwords($role->display_name) }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body">
                        <form class="form-horizontal" method="post" id="add_permission_form" action="{{ route('admins.update',encrypt($vars['user']->id)) }}">
                            @csrf
                            @method("PUT")
                            <div class="form-group">
                                <label for="role_id">Permissions</label>
                                <input type="hidden" name="type" value="permission_id">
                                <input type="hidden" name="editRolesOrPermissions" value="true">
                                <select class="form-control select2" id="permission_id" name="permission_id[]" multiple="multiple" data-placeholder="Select Clinic" style="width: 100%;">
                                    @foreach ($vars['permissions'] as $var)
                                        <option  value="{{ $var->id }}" {{ in_array($var->id, $vars['user']->permissions->pluck('id')->toArray())? 'selected' : '' }} >{{ $var->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">Assign Permission</button>
                            </div>
                        </form>
                        @if(count($vars['user']->permissions))
                            <hr/>
                            <p>User's Current Roles</p>
                            <ul>
                                @foreach ($vars['user']->permissions as $permission)
                                    <li>{{ ucwords($permission->name) }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="showModel">
 
</div>

<div class="createOrEditModel">
  @include('v3.backend.admins/_edit');
</div>

@endsection

@section('js')
<script type="text/javascript">
$("#role_id, #permission_id").select2({multiple:!0});
$(document).ready(function(e){
    $("div.loader").addClass('hidden');

    //UPDATE USER
    $("#edit_user_form").submit(function(event){
        event.preventDefault();
        editForm("#edit_user_form");
    });
})

function editUser(id){
  $(document).find("#_editFrom").val("show")
  
  updateFormUrl = "{{ route('admins.update',':id') }}"; //"/management/admins/"+id;
  updateFormUrl = updateFormUrl.replace(':id', id);

  editFormUrl = "{{ route('admins.edit',':id') }}"; //"/management/admins/"+id;
  editFormUrl = editFormUrl.replace(':id', id);

  $.ajax({
    type: "GET",
    url: editFormUrl,
    success: function (data) {
      // console.log(data);
        $("#edit_user_form input[name=name]").val(data.users.name);
        $("#edit_user_form input[name=gender]").val(data.users.gender);
        $("#edit_user_form input[name=phone]").val(data.users.phone);
        $("#edit_user_form input[name=email]").val(data.users.email);
        $("#edit_user_form ").attr("action", updateFormUrl);
        $('#editFormModelId').modal('show');
    },
  });
}
</script>
@endsection