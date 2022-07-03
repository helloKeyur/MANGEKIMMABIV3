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
      <div id="enter_new_password_load_view">
      <div class="row">
      <div class="form-group col-md-3">
                <select class="btn btn-default form-control ajax_users_all_search" id="ajax_users_all_search" name="ajax_users_all_search_id" style="width:250px;">
                                                <option value="">Search Users</option>

                </select>
      </div>
      {{-- <div class="form-group col-md-3">
         <button class="btn btn-success" id="sort_datatable">Sort Table</button>
      </div> --}}
      </div>

   
      </div>


      <div class="row">

        <div class="col-md-12">
           <div class="box box-primary">
               <div class="box-header">
              <div class="btn-group btn-xs pull-right">
                <a href="javascript:;" type="button" class="btn btn-warning btn-sm toggle-div2" id="filter_show"> <i class="fa fa-filter"></i> List Filter</a>
              </div>
            </div>

            <div class="list-filter" id="toggleble_div2" >
              <div class="form-horizontal">
                <div class="box-body">
                  <div class="container text-center">
                    <form id="send_custom_filter">


             <div class="col-md-2">
              <div class="form-group">
                <label>Subscriptions Filter:</label>
                    <select class="form-control select2 input-custom" name="subscription_type" id="subscription_type">
                      <option value="all" selected>All</option>
                      <option value="true" >Subscribed</option>
                      <option value="false" >Not-Subscribed</option>
                    </select>
              </div>
            </div>

              <div class="col-md-2">
              <div class="form-group">
                <label>Verification Filter:</label>
                    <select class="form-control select2 input-custom" name="verification_type" id="verification_type">
                      <option value="all" selected>All</option>
                      <option value="true" >Verified</option>
                      <option value="false" >Not-Verified</option>
                    </select>
              </div>
              </div>

               <div class="col-md-2">
              <div class="form-group">
                <label>Status Filter:</label>
                    <select class="form-control select2 input-custom" name="verification_type" id="status_type">
                      <option value="all" selected>All</option>
                      <option value="Banned" >Banned</option>
                      <option value="Active" >Active</option> 
                    </select>
              </div>
              </div>

            <div class="col-md-2">
              <div class="form-group">
                <label>Filter by Registered Date:</label>
                  <button type="button" class="btn  btn-default button_daterange" id="registered_daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Select Date range to fillter
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <input type="hidden" value="all" class="time_range" name="time_range" id="registered_time_range" required="" >
              </div>
            </div>


             <div class="col-md-2">
              <div class="form-group">
                  <label for="status">Has screenshots</label>
                    <select class="form-control select2 input-custom" name="status" id="screenshot_status">
                           <option value="all" selected>All</option>
                           <option value="has" >Has Screenshots</option>
                           <option value="has_no" >Has No screenshots</option>
                        </select>

                </div>
             </div>

         {{--     <div class="col-md-2">
              <div class="form-group">
                  <label for="payment_method_id">Select Payment Method</label>
                    <select class="form-control select2 input-custom" name="payment_method_id" id="payment_method_id">
                           <option value="all" selected>All</option>
                           <option value="vodacom">VODACOM</option>
                           <option value="vodacom">AIRTELL</option>
                           <option value="selcom">SELCOM</option>                        
                        </select>
                </div>
             </div> --}}

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

              <div class="col-md-2 pull-right" >
              <div class="form-group">
                 &nbsp;&nbsp; <button  type="submit" class="btn bg-navy  submit_search_daterange"> <i class="fa fa-hand-o-right"></i>&nbsp; Search  &nbsp; <i class="fa fa-search"></i> &nbsp;</button>
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
              <h3 class="box-title">Users List <b style="font-size: 15px; color: red; font-style: italic;"></b></h3>

            <div class="box-body ">
              <table class="table table-striped data-table" id="user_table">
                  <thead>
                <tr>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>User Name</th>
                  <th>Phone</th>
                  <th>Verified</th>
                  <th>End of Subscriptions</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody id="user_table_body">
                    @php $index = 0 @endphp
                    @foreach($vars['users']->chunk(1000) as $users)
                       @foreach($users as $user) 
                        <tr>
                        <td>{{$index+1}}</td>
                        <td>@if(isset($user->name)) {{ucfirst($user->name)}} @endif</td>
                        <td>@if(isset($user->username)) {{ucfirst($user->username)   }} @endif</td>
                        <td>@if(isset($user->phone)) {{ucfirst($user->phone)   }} @endif</td>
                        <td> @if($user->is_verified == "true") <i class="fa fa-check-circle-o" style="color: #009bf5;"></i> VERIFIED @else NOT VERIFIED  @endif</td>
                        <td>@if($user->is_subscribed == "true") {{ $user->end_of_subscription_date  }} @else NOT SUBSCRIBED @endif</td>
                        <td> {{ $user->email  }}</td>
                        <td><a href="/management/view_user_route/{{ encrypt($user->id) }}"  data-id="{{ $user->id }}"  title="View User" >
                        <button class="btn btn-success">  
                        <i class="fa fa-eye" ></i> </button></a>
                        </td>
                        </tr>
                        @php $index++; @endphp
                       @endforeach
                    @endforeach
   
                </tbody>
              </table>
              <br>

            @if ($vars['users']->hasPages())
            <div class="pagination">
            {{ $vars['users']->links() }}
            </div>
            @endif

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


      $('#send_custom_filter').on('submit', function (e) {
    e.preventDefault();

    var verification_type = $("#verification_type").val();
    var subscription_type = $("#subscription_type").val();
    var registered_time_range = $("#registered_time_range").val();
    var subscription_time = $("#time_range").val();
    var status_type = $("#status_type").val();
    var screenshot_status = $("#screenshot_status").val();

     var url  = '/management/filter_users_report/'+verification_type+'/'+subscription_type+'/'+status_type+'/'+screenshot_status+'/'+subscription_time+'/'+registered_time_range;
      $.ajax({
                        type: "GET",
                        url: url,
                        beforeSend: function(){ run_waitMe('ios','whole_div_fill_here',''); },
                        complete: function(){ $('#whole_div_fill_here').waitMe("hide");},
                        success: function (data) { 
                                $("#user_table_body").html(data);
                          },
                        });

     });





  function reDeclerDataTable() {

        $('#user_table').DataTable( {

        dom: 'Bfrtip',
        buttons: [{
            text: 'copy',
            extend: "copy",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'csv',
            extend: "csv",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'excel',
            extend: "excel",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'pdf',
            extend: "pdf",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }, {
            text: 'print',
            extend: "print",
            className: 'btn bg-navy margin',
            exportOptions: {
                columns: "thead th:not(.noExport)"
            }
        }],
    });
}

  @foreach($period as $key => $date)

                  // $.ajax({
                  //       type: "GET",
                  //       url: '/management/get_user_all_of_them/{{$date->format("Y-m-d")}}',
                  //       beforeSend: function(){ run_waitMe('ios','whole_div_fill_here',''); },
                  //       complete: function(){ $('#whole_div_fill_here').waitMe("hide");},
                  //       success: function (data) { 
                  //               $("#user_table").append(data);
                                
                  //         },
                  //       });
           
  @endforeach

  $(document).on("click","#sort_datatable",function(){
                                    $div = $(this).closest('div');
                                    $div.fadeOut(500, function () {
                                    $div.remove();
                                    });
    reDeclerDataTable();
  })



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
      }
    )
});


  $(function () {
  //Date range as a button
    $('#registered_daterange-btn').daterangepicker(
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
        startDate: moment(),
        endDate  : moment(),
      },
      function (start, end) {
         $('#registered_time_range').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
        $('#registered_daterange-btn span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'))
      }
    )
});






   $('.toggle-div2').click(function(){
        $('#toggleble_div2').slideToggle("slow");
    });






  </script>

@endsection
