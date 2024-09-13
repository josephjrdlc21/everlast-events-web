<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: #003399">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('portal.index')}}">
        <div class="sidebar-brand-icon">
            <img src="{{isset($settings) ? "{$settings->directory}/{$settings->filename}" : ""}}" alt="Logo" class="img-fluid" width="40">
        </div>
        <div class="sidebar-brand-text mx-3">
            {{$settings->brand_name ?? 'Brand Name'}}
        </div>
    </a>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Quick Access
    </div>
    <li class="nav-item {{request()->segment(2) != "" ? "" : "active"}}">
        <a class="nav-link" href="{{route('portal.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Menus
    </div>
    @if($auth->canAny(['portal.users_kyc.index'], 'portal'))
    <li class="nav-item {{request()->segment(2) == "users-kyc" ? "active" : ""}}">
        <a class="nav-link {{request()->segment(2) == "users-kyc" ? "" : "collapsed"}}" href="#" data-toggle="collapse" data-target="#collapseRegistration" aria-expanded="true" aria-controls="collapseRegistration">
            <i class="fas fa-fw fa-cog"></i>
            <span>Registrations</span>
        </a>
        <div id="collapseRegistration" class="collapse {{request()->segment(2) == "users-kyc" ? "show" : ""}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{request()->segment(2) == "users-kyc" && request()->segment(3) == "" ? "active" : ""}}" href="{{route('portal.users_kyc.index')}}">Pending</a>
                <a class="collapse-item {{request()->segment(2) == "users-kyc" && request()->segment(3) == "approved" ? "active" : ""}}" href="{{route('portal.users_kyc.approved')}}">Approved</a>
                <a class="collapse-item {{request()->segment(2) == "users-kyc" && request()->segment(3) == "rejected" ? "active" : ""}}" href="{{route('portal.users_kyc.rejected')}}">Rejected</a>
            </div>
        </div>
    </li>
    @endif
    @if($auth->canAny(['portal.users.index'], 'portal'))
    <li class="nav-item {{request()->segment(2) == "users" ? "active" : ""}}">
        <a class="nav-link" href="{{route('portal.users.index')}}">
            <i class="fas fa-user-alt"></i>
            <span>Account Management</span>
        </a>
    </li>
    @endif
    @if($auth->canAny(['portal.members.index'], 'portal'))
    <li class="nav-item {{request()->segment(2) == "members" ? "active" : ""}}">
        <a class="nav-link" href="{{route('portal.members.index')}}">
            <i class="fas fa-users"></i>
            <span>Members</span>
        </a>
    </li>
    @endif
    @if($auth->canAny(['portal.bookings.index'], 'portal'))
    <li class="nav-item {{request()->segment(2) == "bookings" ? "active" : ""}}">
        <a class="nav-link" href="{{route('portal.bookings.index')}}">
            <i class="fas fa-calendar-alt"></i>
            <span>Bookings</span>
        </a>
    </li>
    @endif
    @if($auth->canAny(['portal.events.index'], 'portal'))
    <li class="nav-item {{request()->segment(2) == "events" ? "active" : ""}}">
        <a class="nav-link" href="{{route('portal.events.index')}}">
            <i class="fas fa-bell"></i>
            <span>Events</span>
        </a>
    </li>
    @endif
    @if($auth->canAny(['portal.transactions.index'], 'portal'))
    <li class="nav-item {{request()->segment(2) == "transactions" ? "active" : ""}}">
        <a class="nav-link" href="{{route('portal.transactions.index')}}">
            <i class="fas fa-clipboard"></i>
            <span>Transaction Report</span>
        </a>
    </li>
    @endif
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        System Settings
    </div>
    @if($auth->canAny(['portal.cms.permissions.index', 'portal.cms.roles.index', 'portal.cms.category.index', 'portal.cms.sponsors.index', 'portal.cms.pages.index', 'portal.cms.faq.index', 'portal.cms.settings.index'], 'portal'))
    <li class="nav-item {{request()->segment(2) == "cms" ? "active" : ""}}">
        <a class="nav-link {{request()->segment(2) == "cms" ? "" : "collapsed"}}" href="#" data-toggle="collapse" data-target="#collapseCMS" aria-expanded="true" aria-controls="collapseCMS">
            <i class="fas fa-book"></i>
            <span>Content Management</span>
        </a>
        <div id="collapseCMS" class="collapse {{request()->segment(2) == "cms" ? "show" : ""}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if($auth->canAny(['portal.cms.roles.index'], 'portal'))
                <a class="collapse-item {{request()->segment(3) == "roles" ? "active" : ""}}" href="{{route('portal.cms.roles.index')}}">User Roles</a>
                @endif
                @if($auth->canAny(['portal.cms.permissions.index'], 'portal'))
                <a class="collapse-item {{request()->segment(3) == "permissions" ? "active" : ""}}" href="{{route('portal.cms.permissions.index')}}">Permissions</a>
                @endif
                @if($auth->canAny(['portal.cms.category.index'], 'portal'))
                <a class="collapse-item {{request()->segment(3) == "category" ? "active" : ""}}" href="{{route('portal.cms.category.index')}}">Category</a>
                @endif
                @if($auth->canAny(['portal.cms.sponsors.index'], 'portal'))
                <a class="collapse-item {{request()->segment(3) == "sponsors" ? "active" : ""}}" href="{{route('portal.cms.sponsors.index')}}">Sponsors</a>
                @endif
                @if($auth->canAny(['portal.cms.faq.index'], 'portal'))
                <a class="collapse-item {{request()->segment(3) == "faq" ? "active" : ""}}" href="{{route('portal.cms.faq.index')}}">FAQ</a>
                @endif
                @if($auth->canAny(['portal.cms.pages.index'], 'portal'))
                <a class="collapse-item {{request()->segment(3) == "pages" ? "active" : ""}}" href="{{route('portal.cms.pages.index')}}">Pages</a>
                @endif
                @if($auth->canAny(['portal.cms.settings.index'], 'portal'))
                <a class="collapse-item {{request()->segment(3) == "settings" ? "active" : ""}}" href="{{route('portal.cms.settings.index')}}">Settings</a>
                @endif
            </div>
        </div>
    </li>
    @endif
    @if($auth->canAny(['portal.audit_trail.index'], 'portal'))
    <li class="nav-item {{request()->segment(2) == "audit-trail" ? "active" : ""}}">
        <a class="nav-link" href="{{route('portal.audit_trail.index')}}">
            <i class="fas fa-clock"></i>
            <span>Audit Trail</span>
        </a>
    </li>
    @endif
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>