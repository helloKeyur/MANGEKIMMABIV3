@extends('v3.backend.layouts.app')

@section('title') System Configuration | {{\App\Models\SysConfig::set()['system_title']}} @endsection

@section('css')
<style type="text/css">
    .overflow-visible{
        overflow: visible !important;
    }
</style>
@endsection

@section('content')

<div class="page-header">
  <div class="row align-items-end">
     <div class="col-lg-8">
        <div class="page-header-title">
           <i class="ik ik-settings bg-blue"></i>
           <div class="d-inline">
              <h5 class="text-uppercase pt-2">System Configuration</h5>
          </div>
      </div>
  </div>

    @php 
      $SysConfig =   \App\Models\SysConfig::set();
    @endphp

  <div class="col-lg-4">
    <nav class="breadcrumb-container" aria-label="breadcrumb">
       <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{{ route('management.dashboard') }}"><i class="ik ik-home"></i></a>
         </li>
         <li class="breadcrumb-item">
             <a href="#">System Configuration</a>
         </li>
         <li class="breadcrumb-item active" aria-current="page">Create</li>
     </ol>
 </nav>
</div>
</div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xl-6 offset-md-3 offset-xl-3">

        <div class="widget overflow-visible">
            <div class="progress progress-sm progress-hi-3 hidden">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
            </div>
            <div class="widget-body">
                <div class="overlay hidden">
                    <i class="ik ik-refresh-ccw loading"></i>
                    <span class="overlay-text">System Configuration Creating...</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="Color">
                        <h5 class="text-secondary">Please fill all required fields correctly.</h5>
                    </div>
                </div>

                <form action="{{ route('sys_configs.store') }}" method="POST" id="createSysConfig">
                    @csrf
                    <div class="form-group">
                        <label for="app_statusId">App State</label><small class="text-danger">*</small>
                        <select class="form-control select2" name="app_status" id="app_statusId" style="width: 100%;" required>
                            <option selected value disabled>-</option>
                            @foreach(\App\Models\SysConfig::app_state() as $cat)
                                <option value="{{ $cat }}" @if($cat == $SysConfig['app_status']) selected @endif>{{ $cat }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger err" id="app_status-err"></small>
                    </div>
                    <div class="form-group">
                        <label for="app_versionId">App Version</label><small class="text-danger">*</small>
                        <input type="text" class="form-control" id="app_versionId" value="{{ $SysConfig['app_version'] }}" name="app_version" placeholder="App Version" autocomplete="off">
                        <small class="text-danger err" id="name-err"></small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i class="ik save ik-save"></i>Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function($) {
  $("#createSysConfig").submit(function(event){
    event.preventDefault();
    createForm("#createSysConfig");
  });
});
</script>
@endsection