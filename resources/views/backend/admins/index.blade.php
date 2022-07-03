@extends('main')
@section('css')
<link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{{ $vars['title'] }}}
        <small>{{{ $vars['sub_title'] }}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="/users">Staffs</a></li>
        <li class="active">Staff</li>
      </ol>
    </section>

     <!-- Main content -->
    <section class="content">
      <div class="row">
         <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Staff</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="prevent-resubmit-form" id="create_user_form" enctype="multipart/form-data">
             @csrf
             <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Name:</label>
                  <input type="text" name="name" class="form-control"  placeholder="Full Name.."  required >
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Gender:</label>
                   <select class="form-control"  name="gender" required>
                    <option value="Male"> Male</option>
                    <option value="Female"> Female</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Email:</label>
                  <input type="text" name="email" class="form-control"  placeholder="Email.." >

                     @if ($errors->has('email'))
                            <span class="invalid-feedback text-red" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                        @endif
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Phone:</label>
                  <input type="text" name="phone" class="form-control"  placeholder="Phone.."  required >

                  @if ($errors->has('phone'))
                            <span class="invalid-feedback text-red" role="alert">
                                      <strong>{{ $errors->first('phone') }}</strong>
                                  </span>
                        @endif
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Password:</label>
                  <input  type="password" class="form-control" placeholder="Password" name="password" required >
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
               <button type="submit" class="btn btn-primary prevent-resubmit-button">Submit</button>
              </div>
              </form>
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-8">
           <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Staffs List</h3>

            <div class="box-body ">
              <table class="table table-striped data-table" id="user_table">
                  <thead>
                <tr>
                  <th>Name</th>
                  <th>Gender</th>
                 {{--  <th>Email </th> --}}
                  <th>Phone</th>
                  <th>Roles</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                
                   @foreach($vars['users'] as  $row)

                   @if($row->id != 18)

                    <tr>
                         <td>{{ucfirst($row->name)}}</td>
                          <td>{{ucfirst($row->gender)   }}</td>
                        {{--   <td>{{$row->email   }}</td> --}}
                          <td>{{$row->phone }}</td>
                          <td>
                            @foreach($row->roles as $role)
                                      @if($role->name == 'admin')
                                       <span class="label label-sm label-warning">{{$role->display_name}}</span>
                                       @else
                                        <span class="label label-sm label-success arrowed arrowed-right">{{$role->display_name}}</span>
                                     @endif
                               @endforeach
                          </td>
                        <td>
                           @if(\Auth::user()->userHasRole('admin')) 
                        <a href="{{ url('/management/admins/'.encrypt($row->id) ) }}" class="btn-default " type="button" data-toggle="tooltip" title="View User" data-original-title="View"><i class="fa fa-eye" style="color:#00a65a"></i></a> &nbsp; | &nbsp;
                   {{-- @if( Auth::user()->hasRole('admin') ||Auth::user()->hasRole('management') ||Auth::user()->hasRole('headmaster')) --}}

                        <a href="javascript:void(0)" class="btn-default edit_user" data-id="{{encrypt($row->id)}}"  type="button" data-toggle="tooltip" title="Edit User" data-original-title="Edit"><i class="fa fa-pencil" style="color:#3c8dbc"></i></a> &nbsp; | &nbsp;


                        <a href="#" class="btn-default deleteTr" data-address="admins" data-id="{{$row->id}}" type="button" data-toggle="tooltip" title="Delete User" data-original-title="View"><i class="fa fa-trash" style="color:red"></i></a>

                    @endif


                      </td>
                    </tr>

                      @endif
               @endforeach

                </tbody>
              </table>
            </div>
           </div>
           </div>
            <!-- /.box-body -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@include('backend.admins/_edit');
@endsection



@section('js')
 <script src="{{ url('/') }}/assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript">




     $(function () {
      //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'yyyy/mm/dd'
    })
  })
          //CREATE USER AJAX SCRIPT

          $(document).on('submit', '#create_user_form', function(e){
       e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formdata = new FormData(this);

            $.ajax({
                type: "POST",
                url: '/management/admins',
                processData: false,
                contentType: false,
                data: formdata,
              success: function (data) {

                    console.log(data);
                    $('#user_table').prepend(data);
                    document.getElementById("create_user_form").reset();
                    $('.prevent-resubmit-button').prop("disabled", false);
                    $('.prevent-resubmit-button').html('Submit');
                    close_modal('guardian_create_model');
                    // show_alert('warning', 'User created successful, use your latest four digits of your phone number as initial password');
                      swal({
                title: 'User created Succesfully',
                text: "Keep safe the password for security maintainances",
                type: 'success',
                confirmButtonText: 'Ok',
                confirmButtonClass: 'btn btn-success',
                buttonsStyling: false
            })
                 },
                error: function (xhr, ajaxOptions, thrownError){
                   $('.prevent-resubmit-button').prop("disabled", false);
                   $('.prevent-resubmit-button').html('Submit');
                    close_modal('guardian_create_model');
                     show_alert('danger', xhr.responseText);
            }
            });
          });
          //END CREATE USER


          //EDIT USER SCRIPT
       $(document).on('click', '.edit_user', function(){
     var id = $(this).data("id");
     url = "/management/admins/"+id;
    $.ajax({
        type: "GET",
        url: '/management/admins/'+ id +'/edit',
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
