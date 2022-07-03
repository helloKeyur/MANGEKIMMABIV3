@extends('v3.backend.layouts.app')

@section('title') Subscribed Payments | {{\App\Models\SysConfig::set()['system_title']}} @endsection

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
        <i class="ik ik-dollar-sign bg-blue"></i>
        <div class="d-inline">
          <h5>Subscribed Payments</h5>
          <span>Subscribed payments report from {{explode('~', $vars['time'])[0]}} TO {{explode('~', $vars['time'])[1]}}</span>
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
            <a href="#">Payments</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Subscribed Payments</li>
        </ol>
      </nav>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12 col-md-12 mt-4">

      <div class="card-group mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                    <h3 class="text-dark">
                        {{ number_format($vars["payments"]->where('currency','TSH')->sum('amount'))  }}
                    </h3>
                    <p class="card-subtitle text-muted fw-500">TSH</p>
                    </div>
                    <div class="icon"><i class="ik ik-credit-card"></i></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h3 class="text-danger">
                        {{ number_format($vars["payments"]->where('currency','USD')->sum('amount'))  }}
                    </h3>
                    <p class="card-subtitle text-muted fw-500">USD</p>
                </div>
                <div class="icon"><i class="ik ik-dollar-sign"></i></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                <h3 class="text-info">
                    {{ $vars["payments"]->count()  }}
                </h3>
                <p class="card-subtitle text-muted fw-500">Total Users</p>
                </div>
                <div class="icon"><i class="ik ik-users"></i></div>
            </div>
            </div>
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
            <h5 class="mb-0">List of Subscribed Payments</h5>
          </div>
          <div class="card-header">
            <div class="col-md-6">
                <div class="input-group mb-0">
                    <span class="input-group-prepend">
                        <label for="dates" class="input-group-text"><i class="ik ik-search"></i></label>
                    </span>
                    <input type="text" name="dates" class="form-control br5" id="dates" placeholder="dates" autocomplete="off">
                    <input type="hidden" class="time_range" name="time_range" id="time_range" value="">
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
                                <span class="badge badge-info">{{ $pays->currency }}</span>
                            @else
                                <span class="badge badge-danger">{{ $pays->currency }}</span>
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
  var time = start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
  var url = "{{ route('payments.complete_payments',':time') }}";// '/management/complete_payments/'+start.format('YYYY-MM-DD') + '~' + end.format('YYYY-MM-DD');
  url = url.replace(":time",time);
  window.location = url;
}

$(document).ready(function() {
  var dataTable = $("table.dataTable").DataTable(commonDataTablePropsWithAllCols({title:"List of Subscribed Payments"}));
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