@extends('main')
@section('css')
   <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{{ $vars['title'] }}}
        <small>{{{ $vars['sub_title'] }}}</small>
      </h1>
      {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="/users">Staffs</a></li>
        <li class="active">Staff</li>
      </ol> --}}
    </section>

     <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-10">
         <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Change User Passwords</h3>
            </div>
                <div class="box-body">
                    <form method="POST" action="update_password">
                       {{ csrf_field() }}
                            <div class="form-group" >
                                 <select class="btn btn-default form-control select2" name="user_id">
                                       <option disabled selected> Select Staff</option>
                                         @foreach ($vars['staffs'] as $var)
                                             <option  value="{{ $var->id }}" >{{ $var->name }}</option>
                                         @endforeach
                                 </select>
                            </div>    

                         <div class="form-group">
                            <label for="exampleInputEmail1">New Password:</label>
                            <input  type="password" class="form-control" placeholder="New Password" name="passwordIsNew" required>
                          </div>
                           <div class="form-group">
                            <label for="exampleInputEmail1">Confirm Password:</label>
                            <input  type="password" class="form-control" placeholder="Confirm Password" name="passwordIs_confirmation" required>
                          </div>            
                 </div>
              <div class="box-footer">
               <button type="submit" class="btn btn-primary prevent-resubmit-button">Submit</button>
              </div>
                    </form>
      </div>
    </div>
  </div>

      <!-- /.row -->
    </section>

@endsection



@section('js')


<script src="{{ url('/') }}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>

 <script type="text/javascript">
$(function () {
    $('.select2').select2()
  })
</script>

@endsection