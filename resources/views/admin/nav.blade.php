<!-- Start:: Sidebar -->
<aside class="left-sidebar border-end z-2">
    <nav class="nav-sidebar">
        <ul class="list-unstyled li_animate mb-0">
            <li class="mb-4">
                <div class="d-flex flex-column align-items-start gap-3">
                    <div class="image-input border-primary border-3 avatar position-relative d-inline-block xxl rounded-4" style='background-image: url(' {{ asset('/assets/images/profile-avatar.png') }}')'>
                        <div class="avatar-wrapper rounded-4" style='background-image: url("{{ asset('/assets/images/profile-avatar.png') }}")'></div>
                        <div class="file-input position-absolute end-0 bottom-0 me-2 mb-2">
                            <input type="file" class="form-control" name="file-input" id="file-input1">
                            <label for="file-input1" class="bg-primary text-white shadow"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                    <path d="M13.5 6.5l4 4" />
                                </svg></label>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-0"><a href="#">{{ Auth::user()->name }}</a></h5>
                        <p class="small text-truncate mb-0 text-muted">{{ Auth::user()?->roles()?->first()?->name ?? '' }}</p>
                    </div>
                </div>
            </li>
            <li>
                <a class="d-flex align-items-center justify-content-between hover-svg" data-bs-toggle="collapse" href="#collapseFrontDesk" role="button" aria-expanded="true" aria-controls="collapseFrontDesk">
                    <span class="nav-title  fw-medium">Front Desk</span>
                    <svg class="opacity-75" width="18" height="18" stroke-width="0.5" viewBox="0 0 21 21" fill="none" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 4.375V16.625" />
                        <path d="M4.375 10.5H16.625" />
                    </svg>
                </a>
                <div class="collapse" id="collapseFrontDesk">
                    <ul class="nav flex-column li_animate">
                        @if(Auth::user()->can('dashboard'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['index'])) ? 'active' : '' }}" href="{{ route('index') }}">Dashboard</a></li>
                        @endif
                        @if(Auth::user()->can('appointment-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['appointment.list', 'appointment.create', 'appointment.edit'])) ? 'active' : '' }}" href="{{ route('appointment.list') }}">Appointments</a></li>
                        @endif
                        @if(Auth::user()->can('registration-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['registration.list', 'registration.create', 'registration.edit'])) ? 'active' : '' }}" href="{{ route('registration.list') }}">Registrations</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['search'])) ? 'active' : '' }}" href="{{ route('index') }}">Search</a></li>

                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['vehicle'])) ? 'active' : '' }}" href="{{ route('index') }}">Vehicle</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a class="d-flex align-items-center justify-content-between hover-svg" data-bs-toggle="collapse" href="#collapseOperations" role="button" aria-expanded="false" aria-controls="collapseOperations">
                    <span class="nav-title  fw-medium">Operations</span>
                    <svg class="opacity-75" width="18" height="18" stroke-width="0.5" viewBox="0 0 21 21" fill="none" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 4.375V16.625" />
                        <path d="M4.375 10.5H16.625" />
                    </svg>
                </a>
                <div class="collapse" id="collapseOperations">
                    <ul class="nav flex-column li_animate">
                        @if(Auth::user()->can('user-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['user.list', 'user.create', 'user.edit'])) ? 'active' : '' }}" href="{{ route('user.list') }}">User Management</a></li>
                        @endif
                        @if(Auth::user()->can('role-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['role.list', 'role.create', 'role.edit'])) ? 'active' : '' }}" href="{{ route('role.list') }}">Roles & Permissions</a></li>
                        @endif
                        @if(Auth::user()->can('branch-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['branch.list', 'branch.create', 'branch.edit'])) ? 'active' : '' }}" href="{{ route('branch.list') }}">Branch Management</a></li>
                        @endif
                        @if(Auth::user()->can('doctor-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['doctor.list', 'doctor.create', 'doctor.edit'])) ? 'active' : '' }}" href="{{ route('doctor.list') }}">Doctor Management</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            <li>
                <a class="d-flex align-items-center justify-content-between hover-svg" data-bs-toggle="collapse" href="#collapseReports" role="button" aria-expanded="false" aria-controls="collapseReports">
                    <span class="nav-title  fw-medium">Reports</span>
                    <svg class="opacity-75" width="18" height="18" stroke-width="0.5" viewBox="0 0 21 21" fill="none" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 4.375V16.625" />
                        <path d="M4.375 10.5H16.625" />
                    </svg>
                </a>
                <div class="collapse" id="collapseReports">
                    <ul class="nav flex-column li_animate">
                        <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Daybook</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Registration</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Sales</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</aside>
<div class="sidebar-overlay"></div>
<!-- End:: Sidebar -->