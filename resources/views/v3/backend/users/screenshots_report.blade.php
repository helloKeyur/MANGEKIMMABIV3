@extends('v3.backend.layouts.app')

@section('title') Screenshort Report | {{\App\Models\SysConfig::set()['system_title']}} @endsection

@section('css')
<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
    td.p-0 img.img-thumbnail{
      width: 140px;
    }
    .br5{
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
    <div class="col-lg-8">
      <div class="page-header-title">
        <i class="ik ik-aperture bg-blue"></i>
        <div class="d-inline">
          <h5>Screenshort Report</h5>
          <span>Screenshort report from {{explode('~', $vars['time'])[0]}} to {{explode('~', $vars['time'])[1]}}</span>
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
            <a href="#">Report</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Screenshort Report</li>
        </ol>
      </nav>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12 col-md-12 mt-4">

        <div class="card">

        <!--Tab content-->
        <div class="loader br-4">
          <i class="ik ik-refresh-cw loading"></i>
          <span class="loader-text">Data Fetching....</span>
        </div>
        <div class="tabs_contant">
          <div class="card-header">
            <h5 class="mb-0">List for reports</h5>
          </div>
          <div class="card-header">
            <div class="col-md-6">
                <div class="input-group mb-0">
                    <span class="input-group-prepend">
                        <label for="dates" class="input-group-text"><i class="ik ik-search"></i></label>
                    </span>
                    <input type="text" name="dates" class="form-control br5" id="dates" placeholder="dates" autocomplete="off">
                    <input type="hidden" class="time_range" name="time_range" id="time_range" value="all">
                    <small class="text-danger err" id="dates-err"></small>
                </div>
            </div>
            <div class="col-md-6 text-right" id="dataTableButtons">
            </div>
        </div>
        <div class="card-body table-responsive">
                <table class="table table-striped dataTable" id="user_table">
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
          </div>
        </div>
        <!--End Tab Content-->
      </div>
    </div>
  </div>
  
</div>

<div class="showModel">
 
</div>

@endsection

@section('js')
<script type="text/javascript">


function cb(start, end) {
    // $('input[name="dates"]').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
    $('#time_range').val(start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD'));
    $('input[name="dates"]').val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    // var url = '/management/screenshots_report/'+start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
    var time = start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
    var url = "{{ route('userProfile.screenshots_report',':time') }}";
    url = url.replace(":time",time);
    window.location = url;
}

$(document).ready(function() {
  var dataTable = $("table.dataTable").DataTable(commonDataTablePropsWithAllCols({title:"List of reports"}));
  dataTable.buttons().container().appendTo("#dataTableButtons");
  $("div.loader").addClass('hidden');
  
  var start = moment().subtract(29, 'days');
  var end = moment();

  setDateRangePicker('dates',{
    startDt:"{{ date('M d, Y', strtotime(explode('~', $vars['time'])[0]))  }}",
    endDt:"{{ date('M d, Y', strtotime(explode('~', $vars['time'])[1]))  }}"
  },
  cb);
});
</script>
@endsection