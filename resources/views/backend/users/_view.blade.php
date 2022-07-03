 @extends('main')


 @section('css')
<link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/select2/dist/css/select2.min.css">
 @endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $vars['title'] }}
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ url('/') }}/assets/dist/img/user.png" alt="User profile picture">

              <h3 class="profile-username text-center">{{ ucwords($vars['user']->name) }}</h3>

              <p class="text-muted text-center">{{ ucwords($vars['position']) }}</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Gender</b> <a class="pull-right">{{ ucwords($vars['user']->gender) }}</a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right" style="font-size: 13px;">{{ ucwords($vars['user']->email) }}</a>
                </li>
                 <li class="list-group-item">
                  <b>Phone Number</b> <a class="pull-right">{{ ucwords($vars['user']->phone) }}</a>
                </li>
                 <li class="list-group-item">
                  <b>Living Area</b> <a class="pull-right">{{ ucwords($vars['user']->address) }}</a>
                </li>
                 <li class="list-group-item">
                  <b>Description</b> <a class="pull-right">{{ ucwords($vars['user']->description) }}</a>
                </li>
              </ul>

              <a href="javascript:void(0)" class="btn btn-primary btn-block  editTr" data-id="{{ $vars['user']->id }}" ><li class="fa fa-pencil-square-o"></li><b>Edit Profile</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.Roles Tab pane   -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
             {{-- @if( Auth::user()->hasRole('admin') ||Auth::user()->hasRole('management') ||Auth::user()->hasRole('headmaster')) --}}
              <li class="active"><a href="#role" data-toggle="tab">Roles</a></li>
          
               <li><a href="#permissions" data-toggle="tab">Permissions</a></li>

            </ul>
            <div class="tab-content">
               <!-- /.Roles Tab pane   -->
                {{-- @if( Auth::user()->hasRole('admin') ||Auth::user()->hasRole('management') ||Auth::user()->hasRole('headmaster')) --}}
              <div class="active tab-pane" id="role">
                <div class="timeline-body">
                  <div class="box">
                      <div class="box-header">
                         <h4 class="timeline-header">Roles for {{ ucwords($vars['user']->name) }}</h4>
                      </div>

           <div class="box-body">
               <form class="prevent-resubmit-form " method="POST" id="asign_role" action="/users/{{ $vars['user']->id }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                     {{ method_field('PATCH') }}
                    <div class="row">
                          <div class="form-group">
                          <label> Asign Roles</label>
                          <input type="hidden" name="type" value="role_id">
                          <select class="form-control select2" id="role_id[]" name="role_id[]" multiple="multiple" data-placeholder="Select Roles" style="width: 100%;">
                          @foreach ($vars['roles'] as $var)
                          <option  value="{{ $var->id }}" {{ in_array($var->id, $vars['user']->roles->pluck('id')->toArray())? 'selected' : '' }} >{{ $var->display_name }}</option>
                          @endforeach
                          </select>
                          </div>
                          <input type="submit" value="Asign User Roles" class="btn btn-primary" name="submit" >
                   </div>
               </form>

                <br>

                <h5>User's Currently Roles</h5>
              <table id="work_station_table" class="table table-bordered table-striped">
                  @if(count($vars['user']->roles))
                      @foreach ($vars['user']->roles as $role)
                        <tfoot>
                            <tr>
                                 <th>
                                {{ ucwords($role->display_name) }}
                                 </th>
                            </tr>
                        </tfoot>
                      @endforeach
                  @endif
               </table>

              </div>

            </div>
          </div>
        </div>

  

                <div class="tab-pane" id="permissions">
                    <div class="timeline-body">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="timeline-header">Permission For {{ ucwords($vars['user']->name) }}</h4>
                            </div>

                            <div class="box-body">
                                <form class="prevent-resubmit-form" method="POST"  id="add_permission_form" action="/users/{{ $vars['user']->id }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="row">
                                        <div class="form-group">
                                            <label> Assign Permission</label>
                                            <input type="hidden" name="type" value="permission_id">
                                            <select class="form-control select2" id="permission_id" name="permission_id[]" multiple="multiple" data-placeholder="Select Clinic" style="width: 100%;">
                                                @foreach ($vars['permissions'] as $var)
                                                    <option  value="{{ $var->id }}" {{ in_array($var->id, $vars['user']->permissions->pluck('id')->toArray())? 'selected' : '' }} >{{ $var->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="submit" value="Asign Permission" class="btn btn-primary" name="submit" >
                                    </div>
                                </form>
                                <br>
                                <h5>User's Currently Permissions</h5>
                                <table id="work_station_table" class="table table-bordered table-striped">

                                    @if(count($vars['user']->permissions))
                                        @foreach ($vars['user']->permissions as $permission)
                                            <tfoot>
                                            <tr>
                                                <th>
                                                    {{ ucwords($permission->name) }}
                                                </th>
                                            </tr>
                                            </tfoot>
                                        @endforeach
                                    @endif
                                </table>

                            </div>

                        </div>
                    </div>
                </div>

              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      {{-- </div> --}}
      <!-- /.row -->

    </section>
  {{--    @include('students/_guardian/_edit_guardian') --}}
     @include('backend.users/_edit')
     @include('backend.users/partials/_add')

@endsection



@section('js')
<script src="{{ url('/') }}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>

 <script type="text/javascript">

        $(function () {
    $('#payments').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })


    $(document).on('click', '.editTr', function(){
     var id = $(this).data("id");
     url = "/users/"+id;
    $.ajax({
        type: "GET",
        url: '/users/'+ id +'/edit',
        success: function (data) {
          // console.log(data);
            $("#edit_user_form input[name=name]").val(data.users.name);
            $("#edit_user_form input[name=gender]").val(data.users.gender);
            $("#edit_user_form input[name=phone]").val(data.users.phone);
            $("#edit_user_form input[name=email]").val(data.users.email);
            $("#edit_user_form ").attr("action", url);
            $('#Edit_user_class_modal').modal('show');
        },
            });
        });

 </script>



@endsection
