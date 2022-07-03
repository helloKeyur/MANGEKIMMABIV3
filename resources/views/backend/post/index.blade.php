@extends('main')
@section('css')
 <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
@endsection
@section('content')
	<section class="content-header">
        <div class="row">
            <div class="col-md-12">
                 <div class="box box-primary">
    
       <div class="box-header">

           <h3 class="box-title"> {{{ $vars['title'] }}}</h3>
        <div class="pull-right ">
             
                  <button type="button" class="btn  btn-primary button_daterange" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Select Date range to fillter 
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <input type="hidden" class="time_range" name="time_range" id="time_range" required="" value="{{ $vars['time'] }}">
              </div>
          </div>
  </div>
     </div>
 </div>
    </section>

    <section class="content">
    	<div class="col-md-12">
           <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Posts List</h3>

            <div class="box-body ">
              <table class="table table-striped data-table" id="user_table">
                  <thead>
                <tr>
                  <th>Blog</th>
                  <th>Status</th>
                  <th>Publish DateTime </th>
                  <th>Created By</th>
               {{--    <th>Clicks</th>
                  <th>Comments</th>
                  <th>Reactions</th> --}}
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                
                   @foreach($vars['posts'] as $key => $row)
                    <tr id="post_tr{{ $row->id }}">
                    <td>{{ $row->name }} </td>
                    <td>
                      @if($row->status == "Draft")
                      <span class="label label-warning">{{ $row->status }}</span>
                      @elseif($row->status == "Published")
                      <span class="label label-success">{{ $row->status }}</span>
                      @else
                      <span class="label label-danger">{{ $row->status }}</span>
                      @endif
                    </td>
                    <td>{{ $row->published_at }}</td>
                    <td>@if($row->enteredBy){{ $row->enteredBy->name }}@endif</td>
                 {{--    <td>{{ $row->post_viewers->count() }}</td>
                    <td>{{ $row->post_comments->count() }}</td>
                    <td>{{ $row->post_reactions->count() }}</td> --}}
                    <td>

                         @if(\Auth::user()->userHasRole('admin') || \Auth::user()->userHasRole('author'))
                        @if(!$row->notification_id)
                      
                             <a href="javascript:sendNoticationCustom({{ $row->id }})" class="btn btn-warning btn-sm sentnotification_{{ $row->id }}"  type="button" data-toggle="tooltip" title="Notfication Sent" data-original-title="Notfication Sent" title="Notfication Sent">
                                   <i class="glyphicon glyphicon-volume-up" style="color:white"></i>
                            </a>
                        @endif
                           
                         @endif


                          <a href="javascript:void(0)" class="btn btn-success btn-sm viewTr" data-id="{{ encrypt($row->id) }}" type="button" data-toggle="tooltip"
                                   title="View Post" data-original-title="View">
                                   <i class="fa fa-eye" style="color:white"></i>
                            </a>
                            @if(\Auth::user()->userHasRole('admin') || $row->author_id == \Auth::user()->id ) 
                                <a href="/management/post/{{ encrypt($row->id) }}/edit" class="btn btn-primary btn-sm " type="button" data-toggle="tooltip"
                                   title="Edit Post" data-original-title="Edit">
                                   <i class="fa fa-pencil" style="color:white"></i>
                                 </a>
                           
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteTr"
                                   data-address="post" data-id="{{$row->id}}" type="button" data-toggle="tooltip"
                                   title="Delete Class" data-original-title="View">
                                   <i class="fa fa-trash"  style="color:white"></i>
                                </a>

                         @endif
                    </td>
                  </tr>
                  
                   @endforeach

                </tbody>
              </table>
            </div>
           </div>
           </div>
            <!-- /.box-body -->
      </div>
    <div class="modal fade" id="viewClassModal">
        <div class="modal-dialog modal-lg">
            <div class="box box-primary">
                <div class="box-header">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                  {{--   <br>
                    <h3 class="box-title">View Item</h3> --}}
                </div>

                <div class="box-footer" id="rendered_view_item">
                </div>

            </div>
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
        startDate: moment(),
        endDate  : moment().endOf('month')
      },
      function (start, end) {
         $('#time_range').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
        $('#daterange-btn span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'))

            ColoredLoader('user_table',"Opening...");

         window.location.href = "/management/post_list/"+start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
      }
    )
});




   $(document).on('click', '.viewTr', function () {
            var id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: '/management/post/' + id,
                success: function (data) {
                    $('#rendered_view_item').replaceWith(data);
                    $('#viewClassModal').modal('show');
                },
            });
        });




 $(document).on('click', '.deleteComment', function () {
    var id = $(this).data("id");
    var address = $(this).data("address");
    var token = $('meta[name="csrf-token"]').attr('content');
    var force = $(this).data("force");
    var $tr = $(this).closest("div#comment_list_"+id);
    swal({
        title: 'Are you sure you want to Delete this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it !!",
            cancelButtonText: "No, cancel it !!",
    }).then(function () {

        $.ajax(
            {
                url: "/management/" + address + "/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                    "_force": force,
                },
                success: function () {
                    $tr.fadeOut(500, function () {
                        $tr.remove();
                        swal(
                            'Deleted!',
                            'Emoji has been deleted successful',
                            'success'
                        )
                    });
                    $('.tooltip').hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert(xhr.responseText);
                }
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Your file is safe :)',
                'error'
            )
        }
    })
});

</script>
@endsection
