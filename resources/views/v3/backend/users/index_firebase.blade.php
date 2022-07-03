@extends('v3.backend.layouts.app')

@section('title') Users | {{\App\Models\SysConfig::set()['system_title']}} @endsection

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
        <i class="ik ik-users bg-blue"></i>
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
            <a href="#">Users</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">List of Users</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 col-md-12 mt-4">
      
                <div class="card">
            <div class="card-header">
            <span class="card-title mb-0">Filter users</span>
            </div>
            <div class="card-body">
            <form action="#" method="GET" id="send_custom_filter">
                @csrf
                <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label>Subscriptions Filter:</label>
                        <select class="form-control select2 input-custom" name="subscription_type" id="subscription_type">
                            <option value="all" selected>All</option>
                            <option value="true" >Subscribed</option>
                            <option value="false" >Not-Subscribed</option>
                        </select>
                        <small class="text-danger err" id="order_id-err"></small>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label>Verification Filter:</label>
                        <select class="form-control select2 input-custom" name="verification_type" id="verification_type">
                            <option value="all" selected>All</option>
                            <option value="true" >Verified</option>
                            <option value="false" >Not-Verified</option>
                        </select>
                        <small class="text-danger err" id="order_id-err"></small>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label>Status Filter:</label>
                        <select class="form-control select2 input-custom" name="verification_type" id="status_type">
                            <option value="all" selected>All</option>
                            <option value="Banned" >Banned</option>
                            <option value="Active" >Active</option> 
                        </select>
                        <small class="text-danger err" id="order_id-err"></small>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label>Filter by End of Subscription:</label>
                        <input type="text" class="form-control" id="dsplyEndOfSubDateId" placeholder="End Of Subscription Date" autocomplete="off">
                        <input type="hidden" name="time_range" id="endOfSubDateId">
                        <small class="text-danger err" id="time_range-err"></small>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label for="status">Has screenshots</label>
                        <select class="form-control select2 input-custom" name="status" id="screenshot_status">
                            <option value="all" selected>All</option>
                            <option value="has" >Has Screenshots</option>
                            <option value="has_no" >Has No screenshots</option>
                        </select>
                        <small class="text-danger err" id="dates-err"></small>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label>Filter by Registered Date:</label>
                        <input type="text" class="form-control" id="dsplyRegisteredDateId" placeholder="Registered Date" autocomplete="off">
                        <input type="hidden" name="time_range" id="registeredDateId">
                        <small class="text-danger err" id="time_range-err"></small>
                    </div>
                </div>
                <div class="offset-8 col-md-4 col-lg-4 col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block"><i class="ik search ik-search mr-3"></i>Search</button>
                </div>
                </div>
            </form>
            </div>
        </div>

      <div class="card">
        <!--Tab content-->
        <div class="loader br-4">
          <i class="ik ik-refresh-cw loading"></i>
          <span class="loader-text">Data Fetching....</span>
        </div>
        <div class="tabs_contant">
          <div class="card-header">
            <div class="col-md-3">
                <h5 class="mb-0">List of Users</h5>
                {{-- <a href="#" class="btn btn-sm btn-dark float-left" data-toggle="modal" data-target="#createFormModelId">
                    <i class="ik plus-square ik-plus-square"></i> 
                    Create New User
                </a> --}}
            </div>
            <div class="col-md-9 text-right" id="dataTableButtons">
            </div>
        </div>
        <div class="card-body table-responsive">
                <table class="table table-striped dataTable" id="user_table">
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
                        <td class="text-center"> 
                          @if($user->is_verified == "true")  
                            <span class='success-dot' title='VERIFIED'></span>
                          @else 
                            <i class='ik ik-alert-circle text-danger alert-status' title='NOT VERIFIED'></i>  
                          @endif
                        </td>
                        <td class="text-center">
                          @if($user->is_subscribed == "true") 
                            {{ date('M d,Y h.i A',strtotime($user->end_of_subscription_date))  }} 
                          @else 
                            <small class="badge badge-danger">NOT SUBSCRIBED </small>
                          @endif
                        </td>
                        <td> {{ $user->email  }}</td>
                        <td>
                          <div class='table-actions text-center'>
                            <a href="{{ route("userProfile.view_user_route",encrypt($user->id)) }}" data-id="{{ $user->id }}" class='show-user' target="_blank">
                              <i class='ik ik-eye text-primary'></i>
                            </a>
                          </div>
                          {{-- <a href="/management/view_user_route/{{ encrypt($user->id) }}"  data-id="{{ $user->id }}"  title="View User" >
                            <button class="btn btn-success">  
                            <i class="fa fa-eye" ></i> 
                            </button>
                          </a> --}}
                        </td>
                        </tr>
                        @php $index++; @endphp
                       @endforeach
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

@endsection

@section('js')

<script type="text/javascript">
var dataTable;
$(document).ready(function() {
  getDataAndSetDataTable();
  $("div.loader").addClass('hidden');

  setDateRangePicker('dsplyEndOfSubDateId',{
    startDt:moment().startOf('day'),endDt:moment().endOf('day')
  },cbOfEndOfSubDate);
  setDateRangePicker('dsplyRegisteredDateId',{
    startDt:moment().startOf('day'),endDt:moment().endOf('day')
  },cbOfReigsteredDate);
  searchFormSubmitHandler()

  var defaultDateRange = moment().startOf('day').format('YYYY-MM-DD') + "~" + moment().endOf('day').format('YYYY-MM-DD');
  $("#endOfSubDateId,#registeredDateId").val(defaultDateRange);
});

function cbOfEndOfSubDate(start, end){
  $('#endOfSubDateId').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
  $('#dsplyEndOfSubDateId').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'))
}

function cbOfReigsteredDate(start, end){
  $('#registeredDateId').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
  $('#dsplyRegisteredDateId').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'))
}

function getDataAndSetDataTable(){
  dataTable = $("table#user_table").DataTable(commonDataTableProps({title:"List Of Staff"}));
  dataTable.buttons().container().appendTo("#dataTableButtons");
}
function searchFormSubmitHandler(){
  $('#send_custom_filter').on('submit', function (e) {
    e.preventDefault();

    var verification_type = $("#verification_type").val();
    var subscription_type = $("#subscription_type").val();
    var registered_time_range = $("#registeredDateId").val();
    var subscription_time = $("#endOfSubDateId").val();
    var status_type = $("#status_type").val();
    var screenshot_status = $("#screenshot_status").val();

    //'/management/filter_users_report/'+verification_type+'/'+subscription_type+'/'+status_type+'/'+screenshot_status+'/'+subscription_time+'/'+registered_time_range;
    var url  = "{{ env('APP_URL') }}"+ '/management/filter_users_report/'+verification_type+'/'+subscription_type+'/'+status_type+'/'+screenshot_status+'/'+subscription_time+'/'+registered_time_range;;
    console.log(url);
    $.ajax({
        type: "GET",
        url: url,
        beforeSend: function(){ 
          $("div.loader").removeClass('hidden');
        },
        complete: function(){ 
          $("div.loader").addClass('hidden');
        },
        success: function (data) { 
          if ($.fn.DataTable.isDataTable('table.dataTable')) {
              dataTable.destroy();
              $("#user_table_body").html(data);
              getDataAndSetDataTable();
            }
          },
        });
     });
}
</script>
@endsection