@extends('v3.backend.layouts.app')

@section('title') User Profile ({{ $vars['user']->username }}) | {{\App\Models\SysConfig::set()['system_title']}} @endsection

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
         <li class="breadcrumb-item active" aria-current="page">{{ $vars['user']->username }}</li>
     </ol>
 </nav>
</div>
</div>
</div>

<div class="full-loader br-4 hidden">
    <i class="ik ik-refresh-cw loading"></i>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="card new-cust-card">
            <div class="card-body">
                <div class="text-center"> 
                    <img src="{{ url('/v3/avatars/admin/admin.png') }}" class="rounded-circle" width="150">
                    <h4 class="card-title mt-10">
                        @if(isset($vars['user']->name)) {{ ucwords($vars['user']->name) }} @endif  @if(isset($vars['user']->username)) ({{ $vars['user']->username }}) @endif
                    </h4>
                    @if(isset($vars['user']->email))
                        <p class="text-muted">
                            {{ ucwords($vars['user']->email) }} 
                        </p>
                    @endif
                     @if(isset($vars['user']->phone))
                        <p class="text-muted">
                            {{ ucwords($vars['user']->phone) }} 
                        </p>
                    @endif
                    <div class="list-group mt-3">
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-12 my-auto">
                                <b>End of Subscription Details </b>
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-12 my-auto">
                                <b>
                                    @if($vars['user']->is_subscribed == "true") 
                                        {{ $vars['user']->end_of_subscription_date  }}  
                                    @else 
                                        No Subscriptions 
                                    @endif
                                </b>
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-12 my-auto">
                                <b>Verification Status </b>
                            </div>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="row">
                            <div class="col-md-12 my-auto">
                                <b>
                                    @if($vars['user']->is_verified == "true") 
                                        <i class="ik ik-arrow-right" style="color: #009bf5;"></i> VERIFIED 
                                    @else  
                                        NOT VERIFIED  
                                    @endif 
                                </b>
                            </div>
                            </div>
                        </a>
                    </div>
                    {{-- <button class="btn btn-primary btn-block mt-3" onClick="editUser('{{encrypt($vars['user']->id)}}')">Edit Profile</button> --}}
                    
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#Edit_user_class_modal" class="btn btn-success btn-block mt-2" ><i class="ik ik-edit"></i> <b>Add Subscription Time </b></a>
                    
                    @if($vars['user']->end_of_subscription_date)
                        <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-danger btn-block" id="remove_subscription_clciked"><i class="ik ik-trash"></i> <b>Remove Subriscription</b></a>
                    @endif

                    @if($vars['user']->is_verified == "true")
                        <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-info btn-block" data-status="false" id="verify_user_clciked"><i class="ik ik-minus-circle"></i> <b>Unverify User </b></a>
                    @else
                        <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-info btn-block" data-status="true" id="verify_user_clciked"><i class="ik ik-check-circle"></i> <b>Verify User </b></a>
                    @endif

                    @if($vars['user']->status == "Active")
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#block_user_model_class_modal"   class="btn btn-warning btn-block"  ><i class="ik ik-user-minus"></i> <b>Block this User </b></a>
                    @else
                        <ul class="list-group list-group-unbordered">
                    
                        <li class="list-group-item" style="cursor: pointer;">
                            <b>User Blocked By:: @if($vars['user']->user) {{ $vars['user']->user->name }} @endif  </b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                        </li>

                            <li class="list-group-item" style="cursor: pointer;">
                            <b>Reason:: <i style="color:red;font-size: 12px;">{{ $vars['user']->banned_reason }} </i>  </b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                        </li>


                        </ul> 
                        <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-warning btn-block" data-status="Active" id="block_user_login"><i class="ik ik-arrow-right"></i> <b>Unblock this User </b></a>
                    @endif

                    @if($vars['user']->comment_status == "Active")
                        <a href="javascript:void(0)"    class="btn btn-warning btn-block block_user_login_comment"  data-type="Banned"  ><i class="ik ik-message-square"></i> <b>Block Comment this User </b></a>
                    @else
                        <ul class="list-group list-group-unbordered">
                    
                        <li class="list-group-item" style="cursor: pointer;">
                            <b>User Comment Blocked By:: @if($vars['user']->commet_user) {{ $vars['user']->commet_user->name }} @endif  </b> <a class="pull-right"> <i class="fa fa-chevron-right"></i> </a>
                        </li>
                        </ul> 
                        <a href="javascript:void(0)" data-toggle="modal"  class="btn btn-warning btn-block block_user_login_comment" data-status="Active"  data-type="Active"><i class="ik ik-arrow-right"></i> <b>Unblock Comment this User </b></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8">
        <div class="card">
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="pills-setting-tab" data-toggle="pill" href="#paymentTransection" role="tab" aria-controls="pills-setting" aria-selected="false">
                        Payment Transactions
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#userCommentMng" role="tab" aria-controls="pills-setting" aria-selected="false">
                        User Comments Management 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#customSubs" role="tab" aria-controls="pills-setting" aria-selected="false">
                        Custom Subs.
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#ssDtls" role="tab" aria-controls="pills-setting" aria-selected="false">
                        Screenshots Details 
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="tabs-div">
                <div class="tab-pane fade active show" id="paymentTransection" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body">
                        <div class="loader br-4">
                            <i class="ik ik-refresh-cw loading"></i>
                            <span class="loader-text">Data Fetching....</span>
                        </div>
                        <div class="text-center mt-2 mb-4" id="table1Buttons">
                        </div>
                        <table class="table table-striped data-table" id="dataTable1">
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
                <div class="tab-pane fade" id="userCommentMng" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body">
                        <div class="loader br-4">
                            <i class="ik ik-refresh-cw loading"></i>
                            <span class="loader-text">Data Fetching....</span>
                        </div>
                        <div class="text-center mt-2 mb-4" id="table2Buttons">
                        </div>
                        <table class="table table-striped data-table" id="dataTable2">
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
                <div class="tab-pane fade" id="customSubs" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body">
                        <div class="loader br-4">
                            <i class="ik ik-refresh-cw loading"></i>
                            <span class="loader-text">Data Fetching....</span>
                        </div>
                        <div class="text-center mt-2 mb-4" id="table3Buttons">
                        </div>
                        <table class="table table-striped data-table" id="dataTable3">
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
                <div class="tab-pane fade" id="ssDtls" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body table-responsive">
                        <div class="loader br-4">
                            <i class="ik ik-refresh-cw loading"></i>
                            <span class="loader-text">Data Fetching....</span>
                        </div>
                        <div class="text-center mt-2 mb-4" id="table4Buttons">
                        </div>
                        <table class="table table-striped data-table" id="dataTable4">
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

<div class="extraModals">

    {{-- START::ADD SUBSCRIPTION TIME MODAL --}}
    <div class="modal fade" id="Edit_user_class_modal" tabindex="-1" role="dialog" aria-labelledby="Edit_user_class_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Edit_user_class_modalLabel">Add Subscription Time</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST"  class="prevent-resubmit-form"  action="{{ route("userProfile.submitDaysInPayment") }}" enctype="multipart/form-data">
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
    </div>
    {{-- END::ADD SUBSCRIPTION TIME MODAL --}}

    {{-- START::BLOCK THIS USER MODAL --}}
    <div class="modal fade" id="block_user_model_class_modal" tabindex="-1" role="dialog" aria-labelledby="block_user_model_class_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="block_user_model_class_modalLabel">Block this User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST"  class="prevent-resubmit-form"  action="{{ route('userProfile.block_user_submit') }}" enctype="multipart/form-data">
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
    </div>
    {{-- END::BLOCK THIS USER MODAL --}}
</div>
@endsection

@section('js')
<script type="text/javascript">
$("#role_id, #permission_id").select2({multiple:!0});
$(document).ready(function(e){
    getDataAndSetDataTable();
    $("div.loader").addClass('hidden');
})

function getDataAndSetDataTable(){
  dataTable = $("table#dataTable1").DataTable(commonDataTableProps({title:"List of Payment Transactions"}));
  dataTable.buttons().container().appendTo("#table1Buttons");
  dataTable = $("table#dataTable2").DataTable(commonDataTableProps({title:"User Comments Management"}));
  dataTable.buttons().container().appendTo("#table2Buttons");
  dataTable = $("table#dataTable3").DataTable(commonDataTableProps({title:"Custom Subscriptions"}));
  dataTable.buttons().container().appendTo("#table3Buttons");
  dataTable = $("table#dataTable4").DataTable(commonDataTableProps({title:"Screenshots Details"}));
  dataTable.buttons().container().appendTo("#table4Buttons");
}

//PAYMENT TRANSECTION - VODA PAYMENT STATUS HANDLER
$(document).on('click', '.voda_payment_status', function(){
    var id = $(this).data('id');

    var url = '{{ route("voda.getStatus",[":userId",":orderId"]) }}';       
    url = url.replace(':userId', "{{ $vars['user']->id }}");
    url = url.replace(':orderId', id);
    
    $.ajax({
        type: "get",
        url: url, //"/vodacom_web_verification/{{$vars['user']->id}}/"+id,
        processData: false,
        contentType: false,
        beforeSend: function(){ run_waitMe('ios','PendingPayments',''); },
        complete: function(){ $('#PendingPayments').waitMe("hide");},
        success: function (data) {
            if(data.error){
                showToast(
                    'Error',
                    data.error,
                    'error'
                    );
            }else{
                showToast(
                    'Done',
                    data.done,
                    'success'
                    );
                setTimeout(
                    function() {
                        window.location.reload();
                    }, 400);
            }
        },
        error: function (xhr, ajaxOptions, thrownError){
            console.log(xhr.responseText);
        }
    });
});

//PAYMENT TRANSECTION - PAYMENT STATUS HANDLER
$(document).on('click', '.check_payment_status', function(){
    var id = $(this).data('id');
    var link = $(this).data('link');

    var url = '{{ route("payments.show",[":id"]) }}';       
    url = url.replace(':id', id);
    
    $.ajax({
        type: "get",
        url: url,//'/management/admin_check_payments/'+id,
        processData: false,
        contentType: false,
        beforeSend: function(){ run_waitMe('ios','PendingPayments',''); },
        complete: function(){ $('#PendingPayments').waitMe("hide");},
        success: function (data) {
            if(data.error){
                showToast(
                    'Error',
                    data.error,
                    'error'
                    );
            }else if(data.push){
                showToast(
                    'Request in progress',
                    data.push,
                    'warning'
                    );
            }else if(data.pending){
                showToast(
                    'Pending',
                    'Muamala huu bado haujalipiwa subiri tukuunganishe Kwenye Page Yamalipo',
                    'warning'
                    );
                setTimeout(
                    function() {
                        window.location.href= link;
                    }, 600);
            }else{
                showToast(
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

// USER COMMENTS MANAGEMENTS - DELETE COMMENTS HANDLER
$(document).on('click', '.deleteComment', function () {
    var id = $(this).data("id");
    var table = $(this).data("table");
    var $tr = $(this).closest("tr");
    swalWithBootstrapButtons.fire({
        title: 'Are you sure you want to Delete this?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete it !!",
        cancelButtonText: "No, cancel it !!",
    }).then(function (result) {
        if(result.value == true){
            deleteFormUrl = "{{ route('comment.deleteComment',':id') }}";
            deleteFormUrl = deleteFormUrl.replace(":id",id);
            $.ajax({
                type: "GET",
                url: deleteFormUrl, //"/management/delete_comment/" + id,
                success: function (data) {
                    $tr.fadeOut(500, function () {
                        $tr.remove();
                        showToast(
                            'Deleted!',
                            'Deletion was made successfully ',
                            'success'
                            )
                    });
                    $('.tooltip').hide();
                },
            });
        }
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            showToast(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
        }
    })
});

//REMOVE SUBSCRIPTION HANDLER
$(document).on('click', '#remove_subscription_clciked', function () {
    var $tr = $(this).closest("tr");
    swalWithBootstrapButtons.fire({
        title: 'Are you sure you want to Remove Subscription for this user  ?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#9e0008",
        confirmButtonText: "Yes, Remove it !!",
        cancelButtonText: "No, cancel !!",
    }).then(function (result) {
        if(result.value == true){
            $(document).find(".full-loader").removeClass('hidden');
            $.ajax({
                type: "GET",
                url: '/management/remove_subscriptions/{{$vars['user']->id}}',       
                success: function (data) {
                    location.reload();
                },
            });
        }
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            showToast(
                'Cancelled',
                'Action cancelled',
                'error'
                )
        }
    })
});

//BLOCK COMMENT THIS USER HANDLER
$(document).on('click', '.block_user_login_comment', function () {
    var status = $(this).data("type");
    if(status == "Active"){
        var title = "Are you sure you want to Unblock this User for comments?";
        var sutitle = "Yes Unblock";  
    }else{
        var title = "'Are you sure you want to block this User for comments?";
        var sutitle = "Yes Block";   
    }
    swalWithBootstrapButtons.fire({
        title: title,
        text: "You will be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#9e0008",
        confirmButtonText: sutitle,
        cancelButtonText: "No, cancel !!",
    }).then(function (result) {
        if(result.value == true){
            $(document).find(".full-loader").removeClass('hidden');
            var getDataUrl = `{{ route('userProfile.chenge_comment_banned_status',[$vars['user']->id,':status']) }}`;
            getDataUrl = getDataUrl.replace(":status",status);
            $.ajax({
                type: "GET",
                url: getDataUrl, //'/management/chenge_comment_banned_status/{{$vars['user']->id}}/'+status,       
                success: function (data) {
                    location.reload();
                },
            });
        }
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            showToast(
                'Cancelled',
                'Action cancelled',
                'error'
                )
        }
    })
});

//VERIFY/UNVERIFY USER HANDLER
$(document).on('click', '#verify_user_clciked', function () {
    var status = $(this).data("status");
    if(status == "true"){
        var title = "Are you sure you want to Verify this User?";
        var sutitle = "Yes Verify";  
    }else{
        var title = "'Are you sure you want to Unverify this User?";
        var sutitle = "Yes Unverify";   
    }
    swalWithBootstrapButtons.fire({
        title: title,
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#9e0008",
        confirmButtonText: sutitle,
        cancelButtonText: "No, cancel !!",
    }).then(function (result) {
        if(result.value == true){
            $(document).find(".full-loader").removeClass('hidden');
            var getDataUrl = `{{ route('userProfile.verify_status_sent',[$vars['user']->id,':status']) }}`;
            getDataUrl = getDataUrl.replace(":status",status);
            $.ajax({
                type: "GET",
                url: getDataUrl, //'/management/verify_status_sent/{{$vars['user']->id}}/'+status,       
                success: function (data) {
                    location.reload();
                },
            });
        }
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            showToast(
                'Cancelled',
                'Action cancelled',
                'error'
                )
        }
    })
});

//UNBLOCK USER HANDLER
$(document).on('click', '#block_user_login', function () {
    var status = $(this).data("status");
    if(status == "Active"){
        var title = "Are you sure you want to Unblock this User?";
        var sutitle = "Yes UnBlock";  
    }else{
        var title = "'Are you sure you want to Block this User?";
        var sutitle = "Yes Block";   
    }
    swalWithBootstrapButtons.fire({
        title: title,
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#9e0008",
        confirmButtonText: sutitle,
        cancelButtonText: "No, cancel !!",
    }).then(function (result) {
        if(result.value == true){
            $(document).find(".full-loader").removeClass('hidden');
            var getDataUrl = `{{ route('userProfile.verify_block_status_sent',[$vars['user']->id,':status']) }}`;
            getDataUrl = getDataUrl.replace(":status",status);
            $.ajax({
                type: "GET",
                url: getDataUrl,//'/management/verify_block_status_sent/{{$vars['user']->id}}/'+status,       
                success: function (data) {
                    location.reload();
                },
            });
        }
    }, function (dismiss) {
        if (dismiss === 'cancel') {
            showToast(
                'Cancelled',
                'Action cancelled',
                'error'
                )
        }
    })
});
</script>
@endsection