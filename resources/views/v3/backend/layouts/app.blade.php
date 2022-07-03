<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title')</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('v3/favicon.ico') }}" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('v3/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/icon-kit/dist/css/iconkit.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/ionicons/dist/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/jquery-toast-plugin/dist/jquery.toast.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/summernote/dist/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('v3/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/jquery-minicolors/jquery.minicolors.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/c3/c3.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
        <link rel="stylesheet" href="{{ asset('v3/plugins/sweetalert/dist/bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <link rel="stylesheet" href="{{ asset('v3/dist/css/theme.min.css') }}">
        <script src="{{ asset('v3/src/js/vendor/modernizr-2.8.3.min.js') }}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css"/>
        <link rel="stylesheet" href="{{ asset('v3/plugins/daterangepicker-master/daterangepicker.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('v3/dist/css/site-style.css') }}">
        @yield('css')

    </head>

    <body>
        
        <div class="wrapper">
            <header class="header-top" header-theme="light">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                            {{-- <div class="header-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                                    <input type="text" class="form-control">
                                    <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                                </div>
                            </div> --}}
                            @if(\Auth::user()->userHasRole('admin'))
                            <div class="header-search-select">
                                <div class="form-group mb-0">
                                    <select class="form-control ajax_users_all_search" data-url="{{ route("userProfile.view_user_route",':id') }}">
                                        <option disabled value selected>Search User...</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
                        </div>
                        <div class="top-menu d-flex align-items-center">
                            <div class="">
                                <span class="text-secondary mr-2">Hi,  {{ Auth::user()->name }}</span>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(Auth::user()->img_url != null && trim(Auth::user()->img_url) != "")
                                        <img class="avatar" src="{{ Auth::user()->img_url }}" alt="">
                                    @else 
                                        <img class="avatar" src="{{ asset('v3/avatars/admin/admin.png') }}" alt="">
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown" style="min-width:150px">
                                    <h4 class="header">Profile</h4>
                                    <div class="notifications-wrap">
                                        <a href="#" class="media">
                                            <span class="d-flex">
                                                <i class="ik ik-shield"></i> 
                                            </span>
                                            <span class="media-body">
                                                <span class="heading-font-family media-heading">Roles</span><br>
                                                
                                                @foreach(\Auth::user()->roles as $role)
                                                <span class="media-content" title="{{$role->display_name}}">{{ $role->name }}</span><br>
                                                @endforeach
                                                
                                            </span>
                                        </a>
                                    </div>
                                    <div class="footer"><a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></div>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </header>

            <div class="page-wrap">
                <div class="app-sidebar colored">
                    <div class="sidebar-header">
                        <a class="header-brand" href="/">
                            <div class="logo-img">
                               <h5>MK</h5>
                            </div>
                            <small class="text pl-2">{{{\App\Models\SysConfig::set()['system_title']}}}</small>

                        </a>
                        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                    </div>
                    
                    <div class="sidebar-content">
                        @include('v3.backend.layouts.menu')
                    </div>
                </div>
                <div class="main-content">
                    <div class="container-fluid">
                       
                        @yield('content')
                        
                    </div>
                </div>

                

                <footer class="footer">
                    <div class="w-100 clearfix">
                        <div class="row">
                            <div class="col-8">
                                <span class="text-center text-sm-left d-md-inline-block">
                                    Copyright &copy; {{ date('Y') }} {{{\App\Models\SysConfig::set()['system_description']}}}</strong> 
                                    All rights reserved.
                                </span>
                            </div>
                            <div class="col-4 text-right">
                                <b>Version</b> {{\App\Models\SysConfig::set()['version']}}
                            </div>
                        </div>
                        
                    </div>
                </footer>
                
            </div>
        </div>
        
        
        

        
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>window.jQuery || document.write('<script src="src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
        <script src="{{ asset('v3/plugins/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/select2/dist/js/select2.min.js') }}" ></script>
        <script src="{{ asset('v3/plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/ckeditor5/build/ckeditor.js') }}"></script>
        <script src="{{ asset('v3/plugins/screenfull/dist/screenfull.js') }}"></script>
        <script src="{{ asset('v3/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.jss"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="{{ asset('v3/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('v3/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/d3/dist/d3.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/c3/c3.min.js') }}"></script>
        <script src="{{ asset('v3/js/tables.js') }}"></script>
        <script src="{{ asset('v3/js/widgets.js') }}"></script>
        <script src="{{ asset('v3/js/charts.js') }}"></script>
        <script src="{{ asset('v3/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
        <script src="{{ asset('v3/plugins/JQuery-mask-plugin/jquery.mask.min.js')}}"></script>
        <script src="{{ asset('v3/plugins/owl.carousel/dist/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('v3/plugins/jquery.repeater/jquery.form-repeater.min.js')}}"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script src="{{ asset('v3/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('v3/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script src="{{ asset('v3/dist/js/theme.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
        <script src="{{ asset('v3/plugins/daterangepicker-master/daterangepicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('v3/src/js/site-scripts.js') }}"></script>

        @yield('js')
    </body>
</html>
