@extends('main')


@section('css')
    <link rel="stylesheet" href="{{ url('/') }}/assets/bower_components/select2/dist/css/select2.min.css">
    <style type="text/css">
         table td,th ,tr,thead,tbody {
            border: solid 1px black;
        }
    .data-table {
        border: solid 1px black;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 17px;

    }
    </style>
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

       

        <div class="row" id="whole_div_fill_here">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">


           
                 <img @if(isset($vars['user']->img_url)) src="{{$vars['user']->img_url}}" @else src="/no_image" @endif onerror="this.src='{{ url('/') }}/assets/dist/img/user.png';" class="profile-user-img img-responsive img-circle" width="150" height="150" style="width:150px;height:150px;" alt="User profile picture">
                
                    
                        <h3 class="profile-username text-center">@if(isset($vars['user']->name)) {{ ucwords($vars['user']->name) }} @endif  @if(isset($vars['user']->username)) ({{ $vars['user']->username }}) @endif</h3>

                         <p class="text-muted text-center">@if(isset($vars['user']->email)){{ ucwords($vars['user']->email) }} @endif</p>


                          <p class="text-muted text-center"> @if(isset($vars['user']->phone)){{ ucwords($vars['user']->phone) }} @endif</p>

                        <ul class="list-group list-group-unbordered">
                        
                            <li class="list-group-item" style="cursor: pointer;">
                                <b>End of Subscription Details</b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                            </li>
                             
                            <li class="list-group-item">
                                <b style="color:blue;">@if($vars['user']->is_subscribed == "true") {{ $vars['user']->end_of_subscription_date  }}  @else No Subscriptions @endif</b> <a class="pull-right" style="font-size: 13px;"> <i class="fa fa-chevron-right"></i>    </a>
                                
                            </li>
                            <li class="list-group-item" style="cursor: pointer;">
                                <b>Verification Status</b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                            </li>
                             <li class="list-group-item">
                                 @if($vars['user']->is_verified == "true") <i class="fa fa-check-circle-o" style="color: #009bf5;"></i> VERIFIED @else  NOT VERIFIED  @endif
                            </li>
                        </ul>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#Edit_user_class_modal" class="btn btn-success btn-block" ><i class="fa fa-pencil-square-o"></i> <b>Add Subscription Time </b></a>
                        @if($vars['user']->end_of_subscription_date)
                        <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-danger btn-block" id="remove_subscription_clciked"><i class="fa fa-trash-o"></i> <b>Remove Subriscription</b></a>
                        @endif
                         @if($vars['user']->is_verified == "true")
                         <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-info btn-block" data-status="false" id="verify_user_clciked"><i class="fa fa-check-circle-o"></i> <b>Unverify User </b></a>
                         @else
                         <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-info btn-block" data-status="true" id="verify_user_clciked"><i class="fa fa-check-circle-o"></i> <b>Verify User </b></a>
                         @endif

                         @if($vars['user']->status == "Active")
                         <a href="javascript:void(0)" data-toggle="modal" data-target="#block_user_model_class_modal"   class="btn btn-warning btn-block"  ><i class="fa fa-close"></i> <b>Block this User </b></a>
                         @else
                           <ul class="list-group list-group-unbordered">
                        
                            <li class="list-group-item" style="cursor: pointer;">
                                <b>User Blocked By:: @if($vars['user']->user) {{ $vars['user']->user->name }} @endif  </b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                            </li>

                             <li class="list-group-item" style="cursor: pointer;">
                                <b>Reason:: <i style="color:red;font-size: 12px;">{{ $vars['user']->banned_reason }} </i>  </b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                            </li>


                           </ul> 
                         <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-warning btn-block" data-status="Active" id="block_user_login"><i class="fa fa-check-circle-o"></i> <b>Unblock this User </b></a>
                         @endif

                         @if($vars['user']->comment_status == "Active")
                         <a href="javascript:void(0)"    class="btn btn-warning btn-block block_user_login_comment"  data-type="Banned"  ><i class="fa fa-close"></i> <b>Block Comment this User </b></a>
                         @else
                           <ul class="list-group list-group-unbordered">
                        
                            <li class="list-group-item" style="cursor: pointer;">
                                <b>User Comment Blocked By:: @if($vars['user']->commet_user) {{ $vars['user']->commet_user->name }} @endif  </b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                            </li>
                           </ul> 
                         <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-warning btn-block block_user_login_comment" data-status="Active"  data-type="Active"><i class="fa fa-check-circle-o"></i> <b>Unblock Comment this User </b></a>
                         @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-9">
                 <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                     {{-- @if( Auth::user()->hasRole('admin') ||Auth::user()->hasRole('management') ||Auth::user()->hasRole('headmaster')) --}}
                        <li class="active" ><a href="#payments_role" data-toggle="tab">Payment Transactions</a></li>
                        <li ><a href="#comments_role" data-toggle="tab">User Comments Management </a></li>
                        <li ><a href="#transaction_role" data-toggle="tab">Custom Subscriptions</a></li>
                      
                        
                        <li><a href="#screenshots_table" data-toggle="tab">Screenshots Details</a></li>
                    </ul>
                         <div class="tab-content">
              
                        <div class="tab-pane" id="transaction_role">
                            <div class="timeline-body">
                               <div class="box">
                                  <div class="box-header">
                                     <h6 class="timeline-header">Custom Subscriptions</h6>
                                  </div>

                                   <div class="box-body">
                                          <table class="table table-striped data-table" id="user_table">
                                              <thead>
                                            <tr>
                                              <th>S/N</th>
                                              <th>Done By</th>
                                              <th>Type</th>
                                              <th>From</th>
                                              <th>To</th>
                                              <th>Days</th>
                                              <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($vars["subscriptions"] as $index => $sub)
                                                 
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>@if($sub->user){{ $sub->user->name }} @endif</td>
                                                    <td>@if($sub->status == "Removed")
                                                        <span class="label label-danger"> Subscription Removed</span>
                                                     @else 
                                                       <span class="label label-success"> Subscription Added</span> 
                                                     @endif
                                                    </td>
                                                    <td>{{$sub->start_date}} </td>
                                                    <td>{{$sub->end_date}} </td>
                                                    <td>{{$sub->amount_days}} </td>
                                                    <td>{{$sub->created_at }} </td>
                                                </tr>
                                              @endforeach
                                          
                                            </tbody>
                                          </table>
                                    </div>
                               </div>
                            </div>
                        </div>

                    <div class="tab-pane" id="screenshots_table">
                            <div class="timeline-body">
                                      <div class="box">
                                          <div class="box-header">
                                             <h6 class="timeline-header">List Of Screenshots User take</h6>
                                          </div>

                                            <div class="box-body">

                                                <table class="table table-striped data-table" id="user_table">
                                                <thead>
                                                <tr>
                                                <th>S/N</th>
                                                <th>Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($vars["screenshots"]  as $index => $screen)
                                             
                                                <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$screen->date}}</td>
                                                </tr>
                                                @endforeach

                                                </tbody>
                                                </table>

                                             </div>
                                      </div>
                            </div>
                     </div>

                             <div class="tab-pane" id="comments_role">
                            <div class="timeline-body">
                              <div class="box">
                                  <div class="box-header">
                                     <h6 class="timeline-header">List Of Users Comments</h6>
                                  </div>

                              <div class="box-body">

                                   <table class="table table-striped data-table" id="user_table">
                                    <thead>
                                    <tr>
                                    <th>S/N</th>
                                    <th width="800">Comment</th>
                                    <th width="200">Post</th>
                                    <th>Date</th>
                                    <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($vars["comments"]))
                                    @foreach($vars["comments"] as $index => $comment)
                                 
                                    <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$comment->content}}</td>
                                    <td>
                                        @if($comment->post)POST:: <i style="color: blue; font-size: 14px;"> {{$comment->post->name}}</i> @elseif($comment->comment)
                                    COMMENT:: <i style="color: blue; font-size: 14px;"> {{$comment->comment->content}} </i> @endif
                                    </td>
                                    <td>{{$comment->created_at}}</td>
                                     <td>
                                      <button type="button" title="Delete This Comments" data-table="comments" class="btn btn-xs btn-danger deleteComment" data-id='{{$comment->id}}'>
                                      <i class="ace-icon fa fa-trash-o bigger-100"></i>
                                      </button> 
                                     </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    </tbody>
                                    </table>


                            </div>

                            </div>
                            </div>
                            </div>


                             <div class="active tab-pane" id="payments_role">
                            <div class="timeline-body">
                              <div class="box">
                                  <div class="box-header">
                                     <h6 class="timeline-header">Payment Transactions</h6>
                                  </div>

                              <div class="box-body">

                                    <table class="table table-striped data-table" id="user_table">
                                    <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Response Data</th>
                                        <th>Date</th>
                                        <th>Payment Token</th>
                                        <th>Status</th>
                                        <th> From</th>
                                        <th> To</th>
                                        <th>Reference</th>
                                        <th>phone</th>
                                        <th>Amount</th>
                                        <th>Channel</th>
                                         <th>Message</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vars["payments"] as $index => $pays)
                                
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>@if($pays->data)  {{ $pays->data }}  @endif

@if($pays->payment_status != 'COMPLETED')

            @if(isset($pays->channel) && $pays->channel == 'Vodacom')
                <button class="btn btn-primary btn-sm voda_payment_status" data-id="{{ $pays->order_id }}">Angalia Muamala</button>
            @elseif(isset($pays->channel) && $pays->channel == 'Vodacom')
            @else
                <button class="btn btn-primary btn-sm check_payment_status" data-id="{{ $pays->order_id }}" data-link="{{ $pays->payment_gateway_url }}"> Angalia Muamala</button>
            @endif

  @endif
                                        </td>
                                        <td>@if($pays->created_at) {{ $pays->created_at   }} @endif</td>
                                        <td>@if($pays->payment_token){{$pays->payment_token}} @endif</td>
                                        <td>@if($pays->payment_status){{$pays->payment_status}} @endif</td>
                                         <td>{{$pays->start_date}} </td>
                                         <td>{{$pays->end_date}} </td>
                                        <td>@if($pays->reference){{$pays->reference}} @endif</td>
                                        <td>{{$pays->phone}} </td>
                                        <td>{{$pays->amount}} </td>
                                        <td>{{$pays->channel}} </td>
                                        <td>{{$pays->message}} </td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                    </table>


                            </div>

                            </div>
                            </div>
                            </div>

                         </div>   

                 </div>
            </div>
        
        </div>
        <!-- /.row -->
    </section>
 


   <div class="modal fade" id="block_user_model_class_modal">
          <div class="modal-dialog">
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                   
                </div>
                  <form method="POST"  class="prevent-resubmit-form"  action="/management/block_user_submit" enctype="multipart/form-data">
                   @csrf
                  <div class="box-body">

                            <div class="form-group ">
                            <label for="exampleInputEmail1">Enter Reason to Block This User</label>
                            <textarea class="form-control" name="banned_reason" rows="2" required></textarea>
                            </div>
                            <input type="hidden" name="id" value="{{$vars['user']->id}}">
                            <input type="hidden" name="status" value="Banned">
                            <input type="hidden" name="banned_by_id" value="{{Auth::user()->id}}">
                 </div>
                   
                <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right prevent-resubmit-button" >Submit</button> 
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
              </form> 
          </div>
     </div>
 </div>



  <div class="modal fade" id="Edit_user_class_modal">
          <div class="modal-dialog modal-sm">
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <br>
                   
                </div>
                  <form method="POST"  class="prevent-resubmit-form"  action="/management/submit_days_in_payment" enctype="multipart/form-data">
                   @csrf
                  <div class="box-body">

                            <div class="form-group ">
                            <label for="exampleInputEmail1">Enter number of Days You want to add to the User:</label>
                            <input type="number" name="days" min="1" class="form-control" placeholder="Number Of Days"  required >
                            </div>
                            <input type="hidden" name="id" value="{{$vars['user']->id}}">
                 </div>
                   
                <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right prevent-resubmit-button" >Submit</button> 
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
              </form> 
          </div>
     </div>
 </div>

@endsection



@section('js')
    <script src="{{ url('/') }}/assets/bower_components/select2/dist/js/select2.full.min.js"></script>

    <!-- InputMask -->
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{ url('/') }}/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
 
    <script type="text/javascript">

        $(document).on('click', '.voda_payment_status', function(){
         var id = $(this).data('id');

          $.ajax({
                  type: "get",
                  url: '/vodacom_web_verification/{{$vars['user']->id}}/'+id,
                  processData: false,
                  contentType: false,
                   beforeSend: function(){ run_waitMe('ios','PendingPayments',''); },
                   complete: function(){ $('#PendingPayments').waitMe("hide");},
                   success: function (data) {
                      if(data.error){
                        swal(
                            'Error',
                            data.error,
                            'error'
                        );
                     
                      
                      }else{
                        swal(
                            'Done',
                            data.done,
                            'success'
                        );

                           setTimeout(
                            function() {
                               window.location.reload();
                            }, 400);
                      }
                  
                   },error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
        });

     });



$(document).on('click', '.check_payment_status', function(){
         var id = $(this).data('id');
         var link = $(this).data('link');

          $.ajax({
                  type: "get",
                  url: '/management/admin_check_payments/'+id,
                  processData: false,
                  contentType: false,
                   beforeSend: function(){ run_waitMe('ios','PendingPayments',''); },
                   complete: function(){ $('#PendingPayments').waitMe("hide");},
                   success: function (data) {
                      if(data.error){
                        swal(
                            'Error',
                            data.error,
                            'error'
                        );
                      }else if(data.push){
                         swal(
                            'Request in progress',
                             data.push,
                            'warning'
                        );
                      }else if(data.pending){
                        swal(
                            'Pending',
                            'Muamala huu bado haujalipiwa subiri tukuunganishe Kwenye Page Yamalipo',
                            'warning'
                        );
                         setTimeout(
                            function() {
                                window.location.href= link;
                            }, 600);
                        
                      
                      }else{
                        swal(
                            'Done',
                            data.done,
                            'success'
                        );

                           setTimeout(
                            function() {
                               window.location.reload();
                            }, 300);
                      }
                  
                   },error: function (xhr, ajaxOptions, thrownError){
                  console.log(xhr.responseText);
              }
        });

     });



        $(document).on('click', '.deleteComment', function () {
    var id = $(this).data("id");
    var table = $(this).data("table");
    var $tr = $(this).closest("tr");
    swal({
        title: 'Are you sure you want to Delete this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
       confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it !!",
            cancelButtonText: "No, cancel it !!",
    }).then(function () {
        $.ajax({
            type: "GET",
            url: "/management/delete_comment/" + id,
            success: function (data) {
                $tr.fadeOut(500, function () {
                    $tr.remove();
                    swal(
                        'Deleted!',
                        'Deletion was made successfully ',
                        'success'
                    )
                });
                $('.tooltip').hide();
            },
        });

    }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
            )
        }
    })
});
           

        $(document).on('click', '#remove_subscription_clciked', function () {

    var $tr = $(this).closest("tr");
    swal({
        title: 'Are you sure you want to Remove Subscription for this user  ?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#9e0008",
            confirmButtonText: "Yes, Remove it !!",
            cancelButtonText: "No, cancel !!",
    }).then(function () {

         run_waitMe('ios','whole_div_fill_here','');

       $.ajax({
        type: "GET",
        url: '/management/remove_subscriptions/{{$vars['user']->id}}',       
        success: function (data) {
         location.reload();
        },
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Action cancelled',
                'error'
            )
        }
    })
});


        

        $(document).on('click', '.block_user_login_comment', function () {

    var status = $(this).data("type");


    if(status == "Active"){
      var title = "Are you sure you want to Unblock this User for comments?";
      var sutitle = "Yes Unblock";  
    }else{
       var title = "'Are you sure you want to block this User for comments?";
       var sutitle = "Yes Block";   
    }
    swal({
        title: title,
        text: "You will be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#9e0008",
            confirmButtonText: sutitle,
            cancelButtonText: "No, cancel !!",
    }).then(function () {

         run_waitMe('ios','whole_div_fill_here','');

       $.ajax({
        type: "GET",
        url: '/management/chenge_comment_banned_status/{{$vars['user']->id}}/'+status,       
        success: function (data) {
         location.reload();
        },
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Action cancelled',
                'error'
            )
        }
    })
});

 $(document).on('click', '#verify_user_clciked', function () {

    var status = $(this).data("status");

    if(status == "true"){
      var title = "Are you sure you want to Verify this User?";
      var sutitle = "Yes Verify";  
    }else{
       var title = "'Are you sure you want to Unverify this User?";
       var sutitle = "Yes Unverify";   
    }
    swal({
        title: title,
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#9e0008",
            confirmButtonText: sutitle,
            cancelButtonText: "No, cancel !!",
    }).then(function () {

         run_waitMe('ios','whole_div_fill_here','');

       $.ajax({
        type: "GET",
        url: '/management/verify_status_sent/{{$vars['user']->id}}/'+status,       
        success: function (data) {
         location.reload();
        },
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Action cancelled',
                'error'
            )
        }
    })
});

  $(document).on('click', '#block_user_login', function () {

    var status = $(this).data("status");


    if(status == "Active"){
      var title = "Are you sure you want to Unblock this User?";
      var sutitle = "Yes UnBlock";  
    }else{
       var title = "'Are you sure you want to Block this User?";
       var sutitle = "Yes Block";   
    }
    swal({
        title: title,
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
          confirmButtonColor: "#9e0008",
            confirmButtonText: sutitle,
            cancelButtonText: "No, cancel !!",
    }).then(function () {

         run_waitMe('ios','whole_div_fill_here','');

       $.ajax({
        type: "GET",
        url: '/management/verify_block_status_sent/{{$vars['user']->id}}/'+status,       
        success: function (data) {
         location.reload();
        },
            });

    }, function (dismiss) {

        if (dismiss === 'cancel') {
            swal(
                'Cancelled',
                'Action cancelled',
                'error'
            )
        }
    })
});

 

        


    </script>



@endsection
