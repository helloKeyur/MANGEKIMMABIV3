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
           
        </div>
        <!-- search form -->
      
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          
                <li class="{{Request::is('/') ? 'active' : '' }}"><a href="/"><i class="fa fa-dashboard"></i> <span>Home</span> </a></li>


           </ul>
    </section>
    <!-- /.sidebar -->
</aside>