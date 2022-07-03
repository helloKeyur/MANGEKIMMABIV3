<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->img_url }}" onerror="this.src='{{ url('/') }}/assets/dist/img/user.png';"
                     width="5" height="5" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">


                <small onclick="changeOffice()" style="cursor: pointer;">
                    {{-- <i class="fa fa-circle text-success"></i> --}}
                       <i class="fa fa-home "></i>
                        {{-- <i class="fa fa-dashboard"></i> --}}
                  {{--   @if(\Auth::user()->active_office() && \Auth::user()->active_office()->office) {{ \Auth::user()->active_office()->office->name }}

                    @else
                        Branch Not Selected
                     @endif --}}

                </small>
            </div>
        </div>
        <!-- search form -->
      @if(\Auth::user()->userHasRole('admin'))
        <form action="#" method="get" class="sidebar-form">
            <div>
                <select class="btn btn-default  form-control input-custom ajax_users_all_search" 
                        style="width:100%;">
                    <option value="">Search Users</option>
                </select>

            
            </div>
        </form>

          @endif
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
                <li class="{{Request::is('management/dashboard') ? 'active' : '' }}"><a href="/management/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a></li>


      


           

                 
                 {{-- <li> <a href="{{ url('/management/oders') }}"><i class="fa fa-user-md"></i><span>Orders</span></a></li> --}}

                



              @if(\Auth::user()->userHasRole('admin'))

                <li class="header">IT/Admin</li>

           <li> <a href="{{ url('/management/admins') }}"><i class="fa fa-user-secret"></i><span>Staff</span></a></li>


           <li class="{{Request::is('management/users') ? 'active' : '' }}"><a href="/management/users"><i class="fa fa-users"></i> <span>Users</span> </a></li>
                <li class="{{Request::is('management/categories') ? 'active' : '' }}"><a href="/management/categories"><i class="fa fa-bars"></i> <span>Categories</span> </a></li>
               <li class="{{Request::is('management/food') ? 'active' : '' }}"><a href="/management/food"><i class="fa fa-cutlery"></i><span>Food</span></a></li>
               <li class="{{Request::is('management/workouts') ? 'active' : '' }}"><a href="/management/workouts"><i class="fa fa-street-view"></i><span>Workouts</span></a></li>
                 <li class="{{Request::is('management/emojis') ? 'active' : '' }}"><a href="/management/emojis"><i class="fa fa-smile-o"></i> <span>Emojis</span> </a></li>


                  <li> <a href="{{ url('/management/sys_configs') }}"><i class="fa  fa-wrench"></i><span>System Configuration</span></a></li>


                   <li class="{{Request::is('/management/complete_payments/*') ? 'active' : '' }}"> <a href="/management/complete_payments/{{ date('Y-m-d').'~'. date('Y-m-d') }}"><i class="fa fa-money"></i><span>Subscribed Payments</span></a></li>

                    <li class="{{Request::is('/management/customs_subscriptions/*') ? 'active' : '' }}"> <a href="/management/customs_subscriptions/{{ date('Y-m-d').'~'. date('Y-m-d') }}"><i class="fa fa-calendar"></i><span>Custom Subscriptions</span></a></li>

                    <li class="{{Request::is('/management/screenshots_report/*') ? 'active' : '' }}"> <a href="/management/screenshots_report/{{ date('Y-m-d').'~'. date('Y-m-d') }}"><i class="fa fa-calendar"></i><span>Screenshots Report</span></a></li>

                    @endif

               @if(\Auth::user()->userHasRole('author'))

                     <li class="treeview {{ Request::is('management/post') || Request::is('management/post/create') || Request::is('management/categories') || Request::is('management/tags')  ? 'active menu-open' : '' }}">
                <a href="javascript:void(0)">
                    <i class="fa fa-newspaper-o"></i>
                    <span>Blog Management </span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>

                <ul class="treeview-menu">
                    <li class="{{Request::is('management/post/create') ? 'active' : '' }}">
                        <a href="/management/post/create"><i class="fa fa-pencil-square-o"></i>Create post</a>
                    </li>
                    <li class="{{Request::is('management/post_list/*') ? 'active' : '' }}">
                        <a href="/management/post_list/{{Carbon\Carbon::now()->subDays(3)->toDateString().'~'.Carbon\Carbon::now()->toDateString()}}"><i class="fa fa-reorder"></i>Blog list</a>
                    </li>
                </ul>
                </li>
                     @endif



           {{--  @if(\Auth::check())
                @if($operated_role)
                @if($operated_role->name == 'underwriter')
                    @include('sidebars.underwriter')
                @endif
                    @if($operated_role->name == 'ict')
                        @include('sidebars.ict')
                    @endif
                  
                    @if($operated_role->name == 'pharmacist')
                        @include('sidebars.pharmacist')
                    @endif

                    @if($operated_role->name == 'procurement')
                        @include('sidebars.procurement')
                    @endif

                    @if($operated_role->name == 'management')
                        @include('sidebars.management')
                    @endif
                    @if($operated_role->name == 'doctor')
                        @include('sidebars.doctor')
                    @endif
                    @if($operated_role->name == 'receptionist')
                        @include('sidebars.receptionist')
                    @endif
                    @if($operated_role->name == 'cashier')
                        @include('sidebars.cashier')
                    @endif
                    @if($operated_role->name == 'radiologist')
                        @include('sidebars.radiologist')
                    @endif
                    @if($operated_role->name == 'laboratory')
                        @include('sidebars.laboratory')
                    @endif
                    @if($operated_role->name == 'radiographer')
                        @include('sidebars.radiographer')
                    @endif
                    @if($operated_role->name == 'stock_keeper')
                        @include('sidebars.stock_keeper')
                    @endif
                    @if($operated_role->name == 'rch')
                        @include('sidebars.rch')
                    @endif
                    @if($operated_role->name == 'dentist')
                        @include('sidebars.dentist')
                    @endif
                    @if($operated_role->name == 'claim')
                        @include('sidebars.claim')
                    @endif
                    @if($operated_role->name == 'nhif')
                        @include('sidebars.nhif')
                    @endif
                    @if($operated_role->name == 'bill')
                        @include('sidebars.bill')
                    @endif
                    @if($operated_role->name == 'accountant')
                        @include('sidebars.accountant')
                    @endif
                    @if($operated_role->name == 'human resource')
                        @include('sidebars.human_resource')
                    @endif
                @endif

            @endif --}}
           </ul>
    </section>
    <!-- /.sidebar -->
</aside>
