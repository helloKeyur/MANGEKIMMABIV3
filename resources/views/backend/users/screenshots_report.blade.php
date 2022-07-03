@extends('main')
@section('css')
<link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
 <style>
   .items-center {
    font-size: 30;
   }
 </style> 
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
     

      <div class="row">

        <div class="col-md-12">
           <div class="box box-primary">
            
            <div class="list-filter" id="toggleble_div2" >
              <div class="form-horizontal">
                <div class="box-body">
                  <div class="container text-center">
                    <form id="send_custom_filter">

                  <!-- Date and time range -->
             <div class="col-md-2">
              <div class="form-group">
                <label>End of Subscriptions:</label>
                  <button type="button" class="btn  btn-default button_daterange" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Select Date range to fillter
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <input type="hidden" value="all" class="time_range" name="time_range" id="time_range" required="" >
              </div>
            </div>

              </form>
              </div>
            </div>
                <!-- /.box-body -->
              </div>
            </div>
              </div>
            </div>
     </div>



    </section>

     <!-- Main content -->
    <section class="content">
      <div class="row" id="whole_div_fill_here">
  
        <div class="col-md-12">
           <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">SCREENSHOTS REPORT FROM {{explode('~', $vars['time'])[0]}} TO {{explode('~', $vars['time'])[1]}}</h3>

       <div class="box-body ">

          <table class="table table-striped data-table" id="user_table">
            <thead>
                <tr>
                  <th width="50">S/N</th>
                  {{-- <th width="300">ID</th> --}}
                  <th width="300">User</th>
                  <th width="300">Name</th>
                  <th width="300">Email</th>
                  <th width="300">Phone</th>
                  <th width="500">Screenshots Date</th>
                </tr>
                </thead>
                <tbody>
                   @foreach($vars["screenshots"] as $index => $sub)
                    <tr>
                        <td>{{$index+1}}</td>
                        {{-- <td>{{$sub->user_id}} </td> --}}
                        <td>@if($sub->user){{ $sub->user->username }} @endif</td>
                        <td>@if($sub->user){{ $sub->user->name }} @endif</td>
                        <td>@if($sub->user){{ $sub->user->email }} @endif</td>
                        <td>@if($sub->user){{ $sub->user->phone }} @endif</td>
                        <td>{{$sub->created_at}} </td>
                    </tr>
                  @endforeach
              
                </tbody>
              </table>
              <br>

            </div>
           </div>
           </div>
            <!-- /.box-body -->
      </div>
    </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection



@section('js')
 <script src="{{ url('/') }}/assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
 <script src="{{ url('/') }}/assets/bower_components/moment/min/moment.min.js"></script>
<script src="{{ url('/') }}/assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript">


 $(function () {
  //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'This Week'  : [moment().startOf('week'), moment().endOf('week')],
          'Last Week'  : [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
          'This Year'  : [moment().startOf('year'), moment().endOf('year')],
          'Last year'  : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        },
        startDate: moment().startOf('month'),
        endDate  : moment().endOf('month')
      },
      function (start, end) {
         $('#time_range').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
        $('#daterange-btn span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'))
        var url = '/management/screenshots_report/'+start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
             window.location = url;
      }
    )
});





  </script>

@endsection
