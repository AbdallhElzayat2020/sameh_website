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

        <li class="menu-item {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.roles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Roles">Roles</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.permissions.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.permissions.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-shield-check"></i>
                <div data-i18n="Permissions">Permissions</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.clients.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.clients.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-address-book"></i>
                <div data-i18n="Clients">Clients</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.services.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.services.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-briefcase"></i>
                <div data-i18n="Services">Services</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.finance.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.finance.invoices') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-wallet"></i>
                <div data-i18n="Finance">Finance</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.industries.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.industries.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-building"></i>
                <div data-i18n="Industries">Industries</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.contact-messages.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.contact-messages.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-mail"></i>
                <div data-i18n="Contact Messages">Contact Messages</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.ios-images.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.ios-images.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-photo"></i>
                <div data-i18n="iOS Images">iOS Images</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.freelancers.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.freelancers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Freelancers">Freelancers</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.project-requests.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.project-requests.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                <div data-i18n="Project Requests">Price Requests</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.tasks.*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.tasks.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-checklist"></i>
                <div data-i18n="Tasks">Tasks</div>
            </a>
        </li>









    </ul>
</aside>
