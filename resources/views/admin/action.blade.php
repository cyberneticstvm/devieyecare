@php
$route = '';
if(in_array(Route::currentRouteName(), ['branch.list'])):
$route = route('branch.create');
elseif(in_array(Route::currentRouteName(), ['role.list'])):
$route = route('role.create');
elseif(in_array(Route::currentRouteName(), ['user.list'])):
$route = route('user.create');
elseif(in_array(Route::currentRouteName(), ['doctor.list'])):
$route = route('doctor.create');
elseif(in_array(Route::currentRouteName(), ['registration.list'])):
$route = route('registration.create', ['rtype' => encrypt(getRtypeId('New')), 'typeid' => encrypt(0)]);
elseif(in_array(Route::currentRouteName(), ['product.list'])):
$route = route('product.create');
endif
@endphp


@if(in_array(Route::currentRouteName(), ['branch.list', 'role.list', 'user.list', 'doctor.list', 'registration.list', 'product.list']))
<li>
    <a href="{{ ($route) ? $route : '' }}" class="text-decoration-none hover-svg">
        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <path d="M13 2V24"></path>
            <path d="M2 13H24"></path>
        </svg>
    </a>
</li>
@endif