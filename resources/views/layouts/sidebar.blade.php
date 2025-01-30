<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">لوحة التحكم</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>لوحة التحكم</span></a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        الادارات
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>المستخدمين</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('posts.index') }}">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>المنشورات</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('reports.index') }}">
            <i class="fas fa-fw fa-exclamation-triangle"></i>
            <span>البلاغات</span>
            @if ($unhiddenReportsCount > 0)
                <span class="badge badge-danger ml-2">{{ $unhiddenReportsCount }}</span>
            @endif
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('gifts.index') }}">
            <i class="fas fa-fw fa-gift"></i>
            <span>الهدايات</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('messages.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>الاسئلة</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('notifications.index') }}">
            <i class="fas fa-fw fa-bell"></i>
            <span>الاشعارات</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('verification.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>طلبات التحقق</span>
            @if ($pendingVerificationCount > 0)
                <span class="badge badge-danger">{{ $pendingVerificationCount }}</span>
            @endif
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-tv"></i>
            <span>لايفات ولاضافات الاخري</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">اللايفات:</h6>
                <a class="collapse-item" href="{{ route('families.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>العائلات</span>
                </a>
                <a class="collapse-item" href="{{ route('live_streamings.index') }}">
                    <i class="fas fa-fw fa-tv"></i>
                    <span>اللايفات الحية</span>
                </a>
                <a class="collapse-item" href="{{ route('agencies.index') }}">
                    <i class="fas fa-fw fa-building"></i>
                    <span>الوكالات</span>
                </a>
                {{-- <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a> --}}
            </div>
        </div>
    </li> 
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
