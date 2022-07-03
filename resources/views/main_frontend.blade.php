<!DOCTYPE html>
<html>
    @include('frontend.layouts.head')


    {{-- Settings for mini sidebar --}}

        <body class="hold-transition skin-black-light sidebar-mini fixed">

    <!-- Site wrapper -->
    <div class="wrapper">

        @include('frontend.layouts.header')

            <!-- =============================================== -->
                <!-- Left side column. contains the logo and sidebar -->

        @include('frontend.layouts.sidebar')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @if(Session::has('message'))
                <div class="alert_span">
                    <div class="alert alert-{{Session::get('flash_type','info')}} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong><i
                                class="icon fa fa-{{Session::get('flash_icon','fa-ban')}}"></i> {{Session::get('flash_type','Alert')}}
                            !</strong> {{ Session::get('message') }}.
                    </div>
                </div>
            @endif
            <div id="alert_span" class="alert_span no-print" style="display: none;"></div>

            @yield('content')

            {{-- <div class="modal fade" id="CurrentOffice">
                <div class="modal-dialog modal-sm">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <button type="button" id="close" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <br>
                            <h3 class="box-title">Set Current Office</h3>
                        </div>
                        <div class="box-body ">


                            <div class="form-group col-md-12">
                                <select class="form-control select2 " id="belong_office_list" name="office_id"
                                        required="" style="width: 100%;">
                                    <option value="">Select Office</option>


                                    @foreach (\Auth::user()->office as $office)
                                        <option value="{{ $office->id}}" @if(\Auth::user()->active_office() && \Auth::user()->active_office()->office_id ==  $office->id) selected @endif>{{ $office->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                             <div class="form-group col-md-12">
                                <select class="form-control select2 " id="belong_roles_list" name="role_id"
                                        required="" style="width: 100%;">
                                    <option value="">Select Roles</option>

                                    @foreach (\Auth::user()->roles as $roles)
                                        <option value="{{ $roles->id}}" @if(\Auth::user()->active_office() && \Auth::user()->active_office()->role_id ==  $roles->id) selected @endif>{{ $roles->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                  <div class="form-group col-md-12">
                                <button class="btn btn-primary prevent-resubmit-button btn-block" id="office_change"> <i class="fa fa-refresh"></i> Change Role , Office</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
                <!-- /.content-wrapper -->
    

        @include('frontend.layouts.footer')
        @include('frontend.layouts.aside')

    </div>

        @include('frontend.layouts.scripts')
        @yield('js')

</body>
</html>
