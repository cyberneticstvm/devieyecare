<div class="offcanvas-body">
    <ul class="navbar-nav justify-content-start grow">
        <!--<li class="me-lg-3 nav-item"><a class="nav-link py-1 active" aria-current="page" href="#">Home</a></li>-->
        <li class="me-lg-3 nav-item dropdown">
            <a class="nav-link py-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Front Desk</a>
            <ul class="dropdown-menu p-2 p-xl-3 language shadow-lg rounded-4 li_animate">
                @if(Auth::user()->can('dashboard'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['index'])) ? 'active' : '' }}" href="{{ route('index') }}">Dashboard</a></li>
                @endif
                @if(Auth::user()->can('appointment-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['appointment.list', 'appointment.create', 'appointment.edit'])) ? 'active' : '' }}" href="{{ route('appointment.list') }}">Appointments</a></li>
                @endif
                @if(Auth::user()->can('registration-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['registration.list', 'registration.create', 'registration.edit'])) ? 'active' : '' }}" href="{{ route('registration.list') }}">Registrations</a></li>
                @endif
                @if(Auth::user()->can('search-registration'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['search.registration', 'search.registration.show'])) ? 'active' : '' }}" href="{{ route('search.registration') }}">Search</a></li>
                @endif
                @if(Auth::user()->can('vehicle-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['vehicle.list', 'vehicle.create', 'vehicle.edit', 'vehicle.payment.list', 'vehicle.payment.create', 'vehicle.payment.edit'])) ? 'active' : '' }}" href="{{ route('vehicle.list') }}">Vehicle Management</a></li>
                @endif
                @if(Auth::user()->can('camp-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['camp.list', 'camp.create', 'camp.edit', 'camp.patient.list', 'camp.patient.create', 'camp.patient.edit'])) ? 'active' : '' }}" href="{{ route('camp.list') }}">Camp Management</a></li>
                @endif
            </ul>
        </li>
        <li class="me-lg-3 nav-item dropdown">
            <a class="nav-link py-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Orders</a>
            <ul class="dropdown-menu p-2 p-xl-3 language shadow-lg rounded-4 li_animate">
                @if(Auth::user()->can('store-order-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['store.order.list', 'store.order.create', 'store.order.edit'])) ? 'active' : '' }}" href="{{ route('store.order.list') }}">Store Orders</a></li>
                @endif
                @if(Auth::user()->can('pharmacy-order-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['pharmacy.order.list', 'pharmacy.order.create', 'pharmacy.order.edit'])) ? 'active' : '' }}" href="{{ route('pharmacy.order.list') }}">Pharmacy Orders</a></li>
                @endif
                @if(Auth::user()->can('payment-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['payment.list', 'payment.create', 'payment.edit'])) ? 'active' : '' }}" href="{{ route('payment.list') }}">Payments</a></li>
                @endif
                @if(Auth::user()->can('surgery-register'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['surgery.advised.register'])) ? 'active' : '' }}" href="{{ route('surgery.advised.register') }}">Surgery Advised</a></li>
                @endif
            </ul>
        </li>
        <li class="me-lg-3 nav-item dropdown">
            <a class="nav-link py-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Accounts</a>
            <ul class="dropdown-menu p-2 p-xl-3 language shadow-lg rounded-4 li_animate">
                @if(Auth::user()->can('head-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['head.list', 'head.create', 'head.edit'])) ? 'active' : '' }}" href="{{ route('head.list') }}">Heads</a></li>
                @endif
                @if(Auth::user()->can('ie-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['ie.list', 'ie.create', 'ie.edit'])) ? 'active' : '' }}" href="{{ route('ie.list', 'Expense') }}">Expense Management</a></li>
                @endif
            </ul>
        </li>
        <li class="me-lg-3 nav-item dropdown">
            <a class="nav-link py-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Product</a>
            <ul class="dropdown-menu p-2 p-xl-3 language shadow-lg rounded-4 li_animate">
                @if(Auth::user()->can('product-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['product.list', 'product.create', 'product.edit'])) ? 'active' : '' }}" href="{{ route('product.list') }}">Product Management</a></li>
                @endif
                @if(Auth::user()->can('purchase-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['purchase.list', 'purchase.create', 'purchase.edit'])) ? 'active' : '' }}" href="{{ route('purchase.list') }}">Purchase</a></li>
                @endif
                @if(Auth::user()->can('transfer-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['transfer.list', 'transfer.create', 'transfer.edit'])) ? 'active' : '' }}" href="{{ route('transfer.list') }}">Transfer</a></li>
                @endif
                @if(Auth::user()->can('inventory-status'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['inventory', 'get.inventory'])) ? 'active' : '' }}" href="{{ route('inventory') }}">Inventory Status</a></li>
                @endif
            </ul>
        </li>
        <li class="me-lg-3 nav-item dropdown">
            <a class="nav-link py-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Operations</a>
            <ul class="dropdown-menu p-2 p-xl-3 language shadow-lg rounded-4 li_animate">
                @if(Auth::user()->can('user-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['user.list', 'user.create', 'user.edit'])) ? 'active' : '' }}" href="{{ route('user.list') }}">User Management</a></li>
                @endif
                @if(Auth::user()->can('role-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['role.list', 'role.create', 'role.edit'])) ? 'active' : '' }}" href="{{ route('role.list') }}">Roles & Permissions</a></li>
                @endif
                @if(Auth::user()->can('branch-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['branch.list', 'branch.create', 'branch.edit'])) ? 'active' : '' }}" href="{{ route('branch.list') }}">Branch Management</a></li>
                @endif
                @if(Auth::user()->can('doctor-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['doctor.list', 'doctor.create', 'doctor.edit'])) ? 'active' : '' }}" href="{{ route('doctor.list') }}">Doctor Management</a></li>
                @endif
                @if(Auth::user()->can('ms-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['ms.list', 'ms.create', 'ms.edit'])) ? 'active' : '' }}" href="{{ route('ms.list', 'Manufacturer') }}">Manufacturer</a></li>
                @endif
                @if(Auth::user()->can('ms-list'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['ms.list', 'ms.create', 'ms.edit'])) ? 'active' : '' }}" href="{{ route('ms.list', 'Supplier') }}">Supplier</a></li>
                @endif
                @if(Auth::user()->can('bulk-order-update'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['bulk.order.status', 'bulk.order.status.update'])) ? 'active' : '' }}" href="{{ route('bulk.order.status') }}">Bulk Order Update</a></li>
                @endif
            </ul>
        </li>
        <li class="me-lg-3 nav-item dropdown">
            <a class="nav-link py-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Optometrist</a>
            <ul class="dropdown-menu p-2 p-xl-3 language shadow-lg rounded-4 li_animate">
                @if(Auth::user()->can('procedure'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['procedure.create', 'procedure.fetch', 'procedure'])) ? 'active' : '' }}" href="{{ route('procedure') }}">Procedure</a></li>
                @endif
            </ul>
        </li>
        <li class="me-lg-3 nav-item dropdown">
            <a class="nav-link py-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reports</a>
            <ul class="dropdown-menu p-2 p-xl-3 language shadow-lg rounded-4 li_animate">
                @if(Auth::user()->can('report-daybook'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['report.daybook', 'report.daybook.fetch'])) ? 'active' : '' }}" href="{{ route('report.daybook') }}">Daybook</a></li>
                @endif
                @if(Auth::user()->can('report-registration'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['report.registration', 'report.registration.fetch'])) ? 'active' : '' }}" href="{{ route('report.registration') }}">Registration</a></li>
                @endif
                @if(Auth::user()->can('report-sales'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['report.sales', 'report.sales.fetch'])) ? 'active' : '' }}" href="{{ route('report.sales') }}">Sales - Store</a></li>
                @endif
                @if(Auth::user()->can('report-pharmacy'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['report.pharmacy', 'report.pharmacy.fetch'])) ? 'active' : '' }}" href="{{ route('report.pharmacy') }}">Sales - Pharmacy</a></li>
                @endif
                @if(Auth::user()->can('report-expense'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['report.expense', 'report.expense.fetch'])) ? 'active' : '' }}" href="{{ route('report.expense') }}">Expense</a></li>
                @endif
                @if(Auth::user()->can('report-login-log'))
                <li class=""><a class="dropdown-item rounded-pill {{ (in_array(Route::currentRouteName(), ['report.login.log', 'report.login.log.fetch'])) ? 'active' : '' }}" href="{{ route('report.login.log') }}">Login Log</a></li>
                @endif
            </ul>
        </li>
    </ul>
</div>