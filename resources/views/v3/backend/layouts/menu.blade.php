<div class="nav-container">
    <nav id="main-menu-navigation" class="navigation-main">
        {{-- MAIN NAVIGATION --}}
        <div class="nav-lavel">Main Navigation</div>
        <div class="nav-item {{ request()->routeIs(['management.dashboard']) ? 'active' : '' }}">
            <a href="{{ route('management.dashboard') }}">
                <i class="ik ik-bar-chart-2"></i>
                <span>Dashboard</span>
            </a>
        </div>
        {{-- END OF MAIN NAVIGATION --}}
        
        {{-- IT OR ADMIN --}}
        @if(\Auth::user()->userHasRole('admin'))
            <div class="nav-lavel">IT/Admin</div>
            <div class="nav-item {{ request()->routeIs('admins.*') ? 'active' : '' }}">
                <a href="{{ route('admins.index')  }}">
                    <i class="ik ik-user-check"></i>
                    <span>Staff</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs(['users.*','userProfile.view_user_route']) ? 'active' : '' }}">
                <a href="{{ route('users.allUsers')  }}">
                    <i class="ik ik-users"></i>
                    <span>Users</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <a href="{{ route('categories.index')  }}">
                    <i class="ik ik-layers"></i>
                    <span>Categories</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('food.*') ? 'active' : '' }}">
                <a href="{{ route('food.index')  }}">
                    <i class="ik ik-disc"></i>
                    <span>Food</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('workouts.*') ? 'active' : '' }}">
                <a href="{{ route('workouts.index')  }}">
                    <i class="ik ik-watch"></i>
                    <span>Workouts</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('emojis.*') ? 'active' : '' }}">
                <a href="{{ route('emojis.index')  }}">
                    <i class="ik ik-gitlab"></i>
                    <span>Emojis</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('sys_configs.*') ? 'active' : '' }}">
                <a href="{{ route('sys_configs.index')  }}">
                    <i class="ik ik-settings"></i>
                    <span>System Config</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('payments.complete_payments') ? 'active' : '' }}">
                <a href="{{ route('payments.complete_payments',date('Y-m-d').'~'. date('Y-m-d'))  }}">
                    <i class="ik ik-dollar-sign"></i>
                    <span>Subscribed Payments</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('userProfile.customs_subscriptions') ? 'active' : '' }}">
                <a href="{{ route('userProfile.customs_subscriptions',date('Y-m-d').'~'. date('Y-m-d'))  }}">
                    <i class="ik ik-calendar"></i>
                    <span>Custom Subscriptions</span>
                </a>
            </div>
            {{-- <div class="nav-item {{ request()->routeIs('userProfile.screenshots_report') ? 'active' : '' }}">
                <a href="{{ route('userProfile.screenshots_report',date('Y-m-d').'~'. date('Y-m-d'))  }}">
                    <i class="ik ik-check-circle"></i>
                    <span>New Subscriptions</span>
                </a>
            </div> --}}
            <div class="nav-item {{ request()->routeIs('userProfile.screenshots_report') ? 'active' : '' }}">
                <a href="{{ route('userProfile.screenshots_report',date('Y-m-d').'~'. date('Y-m-d'))  }}">
                    <i class="ik ik-aperture"></i>
                    <span>Screenshots Report</span>
                </a>
            </div>
        @endif
        
        @if(\Auth::user()->userHasRole('author'))
            <div class="nav-item has-sub {{ request()->routeIs('post.*') ? 'active open' : '' }}">
	            <a href="javascript:void(0)">
                    <i class="ik ik-book"></i>
                    <span>Blog Management</span> 
	            </a>
	            <div class="submenu-content">
	                <a href="{{ route('post.create') }}" class="menu-item {{ request()->routeIs('post.create') ? 'active' : '' }}">
                        <i class="ik plus-circle ik-plus-circle"></i>
                        Add New Blog
                    </a>
	                <a href="{{ route('post.post_list', Carbon\Carbon::now()->subDays(3)->toDateString().'~'.Carbon\Carbon::now()->toDateString()) }}" class="menu-item {{ request()->routeIs('post.index') ? 'active' : '' }}">
                        <i class="ik file-text ik-file-text"></i>
                        List Of Blogs
                    </a>
	            </div>
	        </div>
        @endif
        {{-- END OF IT OR ADMIN --}}    
        
        
    </nav>
</div>