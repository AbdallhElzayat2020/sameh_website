<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard.home') }}" class="app-brand-link">
            <img src="{{ asset('assets/website/images/logo.png') }}" alt="Logo" width="160">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
            <a href="{{ route('dashboard.home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Home">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">إدارة الصلاحيات</span>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.roles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Roles">الأدوار</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.permissions.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.permissions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-shield-check"></i>
                <div data-i18n="Permissions">الصلاحيات</div>
            </a>
        </li>









    </ul>
</aside>
