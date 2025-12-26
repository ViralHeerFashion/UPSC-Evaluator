<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="javascript:void(0);" class="brand-link">
        <img src="{{asset('public/images/icon.png')}}" alt="Aspire Scan" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Aspire Scan</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('public/images/team-01sm.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info text-center">
                <a href="javascript:void(0);" class="d-block text-center">
                    @if(request()->is('admin/*') && auth()->guard('admin')->check())
					{{ auth()->guard('admin')->user()->name }}
                    @else
                    {{ auth()->guard('institute')->user()->name }}
                    @endif
				</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar-search-results"><div class="list-group"><a href="#" class="list-group-item"><div class="search-title"><strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong></div><div class="search-path"></div></a></div></div>
        </div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(request()->is('admin/*') && auth()->guard('admin')->check())
				<li class="nav-item">
					<a href="{{ route('admin.dashboard') }}" class="nav-link dashboard-link">
    					<i class="nav-icon fas fa-chart-line"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
                <li class="nav-item">
					<a href="{{ route('admin.institute') }}" class="nav-link institute-link">
    					<i class="nav-icon fas fa-university"></i>
						<p>
							Institute
						</p>
					</a>
				</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link users-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Students
                        </p>
                    </a>
                </li>
                @elseif(request()->is('institute/*') && auth()->guard('institute')->check())
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link users-link">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Students
                        </p>
                    </a>
                </li>
                @endif
			</ul>
		</nav>
    </div>
</aside>