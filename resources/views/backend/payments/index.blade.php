@extends('main')
@section('css')
    <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- Theme style -->
@endsection
@section('content')
	<section class="content-header">
      <h1>
       SUBSCRIBED PAYMENTS REPORT FROM {{explode('~', $vars['time'])[0]}} TO {{explode('~', $vars['time'])[1]}}
          <div class="box-header pull-right">
                        
                               <button type="button" class="btn  btn-default button_daterange" id="daterange-btn">
                                                    <span>
                                                      <i class="fa fa-calendar"></i> Select Date range to filter
                                                    </span>
                                   <i class="fa fa-caret-down"></i>
                               </button>
                               <input type="hidden" class="time_range" name="time_range" id="time_range" value="">
                          
               </div>
      </h1>
     
    </section>

    <section class="content">



      <div class="row">
        <div class="col-lg-3 col-xs-6 pull-center">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
               <h3>{{ number_format($vars["payments"]->where('currency','TSH')->sum('amount'))  }}</h3>

              <p>TSH</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
    
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 pull-center">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ number_format($vars["payments"]->where('currency','USD')->sum('amount'))  }}</h3>

              <p>USD</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->

       <div class="col-lg-3 col-xs-6 pull-center">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{ $vars["payments"]->count()  }}</h3>

              <p>USERS</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>

      </div>

 <div class="row" >

  
        <div class="col-md-12">
           <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Staffs List</h3>

            <div class="box-body ">
               <table class="table table-striped data-table" id="user_table">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>User</th>
                                        {{-- <th>Status</th> --}}
                                        <th> From</th>
                                        <th> To</th>
                                        <th>Reference</th>
                                        <th>phone</th>
                                        <th>Currency</th>
                                        <th>Amount</th>
                                        <th>Channel</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vars["payments"] as $index => $pays)
                                
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>@if($pays->user) {{ $pays->user->name   }} <em style="color:blue">({{ $pays->user->username }}) </em> @endif </td>
                                       
                                        {{-- <td>@if($pays->payment_status){{$pays->payment_status}} @endif</td> --}}
                                         <td>{{$pays->start_date}} </td>
                                         <td>{{$pays->end_date}} </td>
                                        <td>@if($pays->reference){{$pays->reference}} @endif</td>
                                        <td>{{$pays->phone}} </td>
                                        <td>@if($pays->currency == "TSH")
                                             <span class="label label-info">{{ $pays->currency }}</span>
                                            @else
                                             <span class="label label-danger">{{ $pays->currency }}</span>
                                            @endif
                                        </td>
                                        <td>{{$pays->amount}} </td>
                                        <td>{{$pays->channel}} </td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                    </table>
            </div>
           </div>
           </div>
            <!-- /.box-body -->
      </div>
     
</div>


    </section>

  

@endsection


@section('js')
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
             startDate: moment().startOf('day'),
             endDate  : moment().endOf('day')
         },
         function (start, end) {
             $('#time_range').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
             $('#daterange-btn span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
             var url = '/management/complete_payments/'+start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
             window.location = url;
         }
     )
 });
</script>



@endsection
