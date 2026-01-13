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
                        @if(Auth::user()->can('search-registration'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['search.registration', 'search.registration.show'])) ? 'active' : '' }}" href="{{ route('search.registration') }}">Search</a></li>
                        @endif
                        @if(Auth::user()->can('vehicle-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['vehicle.list', 'vehicle.create', 'vehicle.edit', 'vehicle.payment.list', 'vehicle.payment.create', 'vehicle.payment.edit'])) ? 'active' : '' }}" href="{{ route('vehicle.list') }}">Vehicle Management</a></li>
                        @endif
                        @if(Auth::user()->can('camp-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['camp.list', 'camp.create', 'camp.edit', 'camp.patient.list', 'camp.patient.create', 'camp.patient.edit'])) ? 'active' : '' }}" href="{{ route('camp.list') }}">Camp Management</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            <li>
                <a class="d-flex align-items-center justify-content-between hover-svg" data-bs-toggle="collapse" href="#collapseOrders" role="button" aria-expanded="false" aria-controls="collapseOrders">
                    <span class="nav-title  fw-medium">Orders</span>
                    <svg class="opacity-75" width="18" height="18" stroke-width="0.5" viewBox="0 0 21 21" fill="none" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 4.375V16.625" />
                        <path d="M4.375 10.5H16.625" />
                    </svg>
                </a>
                <div class="collapse" id="collapseOrders">
                    <ul class="nav flex-column li_animate">
                        @if(Auth::user()->can('store-order-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['store.order.list', 'store.order.create', 'store.order.edit'])) ? 'active' : '' }}" href="{{ route('store.order.list') }}">Store Orders</a></li>
                        @endif
                        @if(Auth::user()->can('pharmacy-order-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['pharmacy.order.list', 'pharmacy.order.create', 'pharmacy.order.edit'])) ? 'active' : '' }}" href="{{ route('pharmacy.order.list') }}">Pharmacy Orders</a></li>
                        @endif
                        @if(Auth::user()->can('payment-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['payment.list', 'payment.create', 'payment.edit'])) ? 'active' : '' }}" href="{{ route('payment.list') }}">Payments</a></li>
                        @endif
                        @if(Auth::user()->can('surgery-register'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['surgery.advised.register'])) ? 'active' : '' }}" href="{{ route('surgery.advised.register') }}">Surgery Advised</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            <li>
                <a class="d-flex align-items-center justify-content-between hover-svg" data-bs-toggle="collapse" href="#collapseAccounts" role="button" aria-expanded="false" aria-controls="collapseAccounts">
                    <span class="nav-title  fw-medium">Accounts</span>
                    <svg class="opacity-75" width="18" height="18" stroke-width="0.5" viewBox="0 0 21 21" fill="none" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 4.375V16.625" />
                        <path d="M4.375 10.5H16.625" />
                    </svg>
                </a>
                <div class="collapse" id="collapseAccounts">
                    <ul class="nav flex-column li_animate">
                        @if(Auth::user()->can('head-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['head.list', 'head.create', 'head.edit'])) ? 'active' : '' }}" href="{{ route('head.list') }}">Heads</a></li>
                        @endif
                        @if(Auth::user()->can('ie-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['ie.list', 'ie.create', 'ie.edit'])) ? 'active' : '' }}" href="{{ route('ie.list', 'Expense') }}">Expense Management</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            <li>
                <a class="d-flex align-items-center justify-content-between hover-svg" data-bs-toggle="collapse" href="#collapseProducts" role="button" aria-expanded="false" aria-controls="collapseProducts">
                    <span class="nav-title  fw-medium">Product</span>
                    <svg class="opacity-75" width="18" height="18" stroke-width="0.5" viewBox="0 0 21 21" fill="none" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 4.375V16.625" />
                        <path d="M4.375 10.5H16.625" />
                    </svg>
                </a>
                <div class="collapse" id="collapseProducts">
                    <ul class="nav flex-column li_animate">
                        @if(Auth::user()->can('product-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['product.list', 'product.create', 'product.edit'])) ? 'active' : '' }}" href="{{ route('product.list') }}">Product Management</a></li>
                        @endif
                        @if(Auth::user()->can('purchase-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['purchase.list', 'purchase.create', 'purchase.edit'])) ? 'active' : '' }}" href="{{ route('purchase.list') }}">Purchase</a></li>
                        @endif
                        @if(Auth::user()->can('transfer-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['transfer.list', 'transfer.create', 'transfer.edit'])) ? 'active' : '' }}" href="{{ route('transfer.list') }}">Transfer</a></li>
                        @endif
                        @if(Auth::user()->can('inventory-status'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['inventory', 'get.inventory'])) ? 'active' : '' }}" href="{{ route('inventory') }}">Inventory Status</a></li>
                        @endif
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
                        @if(Auth::user()->can('ms-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['ms.list', 'ms.create', 'ms.edit'])) ? 'active' : '' }}" href="{{ route('ms.list', 'Manufacturer') }}">Manufacturer</a></li>
                        @endif
                        @if(Auth::user()->can('ms-list'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['ms.list', 'ms.create', 'ms.edit'])) ? 'active' : '' }}" href="{{ route('ms.list', 'Supplier') }}">Supplier</a></li>
                        @endif
                        @if(Auth::user()->can('bulk-order-update'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['bulk.order.status', 'bulk.order.status.update'])) ? 'active' : '' }}" href="{{ route('bulk.order.status') }}">Bulk Order Update</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            <li>
                <a class="d-flex align-items-center justify-content-between hover-svg" data-bs-toggle="collapse" href="#collapseOpto" role="button" aria-expanded="false" aria-controls="collapseOpto">
                    <span class="nav-title  fw-medium">Optometrist</span>
                    <svg class="opacity-75" width="18" height="18" stroke-width="0.5" viewBox="0 0 21 21" fill="none" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 4.375V16.625" />
                        <path d="M4.375 10.5H16.625" />
                    </svg>
                </a>
                <div class="collapse" id="collapseOpto">
                    <ul class="nav flex-column li_animate">
                        @if(Auth::user()->can('procedure'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['procedure.create', 'procedure.fetch', 'procedure'])) ? 'active' : '' }}" href="{{ route('procedure') }}">Procedure</a></li>
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
                        @if(Auth::user()->can('report-daybook'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['report.daybook', 'report.daybook.fetch'])) ? 'active' : '' }}" href="{{ route('report.daybook') }}">Daybook</a></li>
                        @endif
                        @if(Auth::user()->can('report-registration'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['report.registration', 'report.registration.fetch'])) ? 'active' : '' }}" href="{{ route('report.registration') }}">Registration</a></li>
                        @endif
                        @if(Auth::user()->can('report-sales'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['report.sales', 'report.sales.fetch'])) ? 'active' : '' }}" href="{{ route('report.sales') }}">Sales - Store</a></li>
                        @endif
                        @if(Auth::user()->can('report-pharmacy'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['report.pharmacy', 'report.pharmacy.fetch'])) ? 'active' : '' }}" href="{{ route('report.pharmacy') }}">Sales - Pharmacy</a></li>
                        @endif
                        @if(Auth::user()->can('report-expense'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['report.expense', 'report.expense.fetch'])) ? 'active' : '' }}" href="{{ route('report.expense') }}">Expense</a></li>
                        @endif
                        @if(Auth::user()->can('report-login-log'))
                        <li class="nav-item"><a class="nav-link {{ (in_array(Route::currentRouteName(), ['report.login.log', 'report.login.log.fetch'])) ? 'active' : '' }}" href="{{ route('report.login.log') }}">Login Log</a></li>
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</aside>
<div class="sidebar-overlay"></div>
<!-- End:: Sidebar -->