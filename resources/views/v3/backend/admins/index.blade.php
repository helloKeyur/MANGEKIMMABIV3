@extends('v3.backend.layouts.app')

@section('title') Staffs | {{\App\Models\SysConfig::set()['system_title']}} @endsection

@section('css')
<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
    td.p-0 img.img-thumbnail{
      width: 140px;
    }
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <i class="ik ik-user-check bg-blue"></i>
        <div class="d-inline">
          <h5>{{ $vars['title'] }}</h5>
          <span>{{ $vars['sub_title'] }}</span>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <nav class="breadcrumb-container" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ route('management.dashboard') }}"><i class="ik ik-home"></i></a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('admins.index') }}">Staffs</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">List of Staffs</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 col-md-12 mt-4">
      <div class="card">

        <!--Tab content-->
        <div class="loader br-4">
          <i class="ik ik-refresh-cw loading"></i>
          <span class="loader-text">Data Fetching....</span>
        </div>
        <div class="tabs_contant">
          <div class="card-header">
            <h5 class="mb-0">List of Staffs</h5>
          </div>
          <div class="card-header">
            <div class="col-md-3">
                <a href="#" class="btn btn-sm btn-dark float-left" data-toggle="modal" data-target="#createFormModelId">
                    <i class="ik plus-square ik-plus-square"></i> 
                    Create New Staff
                </a>
            </div>
            <div class="col-md-9 text-right" id="dataTableButtons">
            </div>
        </div>
        <div class="card-body table-responsive">
                <table class="table table-striped dataTable" id="user_table">
                    <thead>
                        <tr>
                            <th>Sr no.</th>
                            <th>Name</th>
                            <th>Gender</th>
                            {{--  <th>Email </th> --}}
                            <th>Phone</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                <tbody>
                
                   @foreach($vars['users'] as  $k => $row)

                   @if($row->id != 18)

                    <tr>
                        <td class="text-right">{{$k+1}}</td>
                        <td>{{ucfirst($row->name)}}</td>
                        <td>{{
                            $row->gender == "" ? "-" : ucfirst($row->gender) }}</td>
                        {{--   <td>{{$row->email   }}</td> --}}
                        <td>{{$row->phone }}</td>
                        <td>
                            @foreach($row->roles as $role)
                                @if($role->name == 'admin')
                                    <span class="badge badge-sm badge-warning">{{$role->display_name}}</span>
                                @else
                                    <span class="badge badge-sm badge-success arrowed arrowed-right">{{$role->display_name}}</span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                           @if(\Auth::user()->userHasRole('admin')) 
                                <div class="table-actions text-center">
                                    <a href="{{ route("admins.show",encrypt($row->id)) }}" class="show_user" target="_blank"><i class="ik ik-eye text-primary"></i></a>
                                    <a href="#" class="edit_user" onClick="editUser('{{encrypt($row->id)}}')"><i class="ik ik-edit-2 text-dark"></i></a>
                                    <a data-href="{{ route("admins.destroy",$row->id) }}" class="delete"><i class="ik ik-trash-2 text-danger"></i></a>
                                </div>
                            @endif


                      </td>
                    </tr>

                      @endif
               @endforeach

                </tbody>
              </table>
          </div>
        </div>
        <!--End Tab Content-->
      </div>
    </div>
  </div>
  
</div>

<div class="row">
    <div class="col-md-12">
        <form id="deleteForm" method="post">
            @csrf
            @method('DELETE')
            <input type="submit" name="submit" class="hidden">
        </form>
    </div>
</div>

<div class="showModel">
 
</div>

<div class="createOrEditModel">
  @include('v3.backend.admins/_create');
  @include('v3.backend.admins/_edit');
</div>

@endsection

@section('js')

<script type="text/javascript">
  
$(document).ready(function() {
  //show staff
  $(document).on('click','a.show-data',function(){
    var showUrl = $(this).data('href');
    showDetails(showUrl);
  });

  var dataTable = $("table.dataTable").DataTable(commonDataTableProps({title:"List Of Staff"}));
  dataTable.buttons().container().appendTo("#dataTableButtons");
  $("div.loader").addClass('hidden');

  //CRETE USER
  $("#create_user_form").submit(function(event){
    event.preventDefault();
    createForm("#create_user_form");
  });

  //UPDATE USER
  $("#edit_user_form").submit(function(event){
    event.preventDefault();
    editForm("#edit_user_form");
  });

});

function editUser(id){
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