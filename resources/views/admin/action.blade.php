@php
$route = '';
if(in_array(Route::currentRouteName(), ['branch.list'])):
$route = 'branch.create';
elseif(in_array(Route::currentRouteName(), ['role.list'])):
$route = 'role.create';
elseif(in_array(Route::currentRouteName(), ['user.list'])):
$route = 'user.create';
elseif(in_array(Route::currentRouteName(), ['doctor.list'])):
$route = 'doctor.create';
endif
@endphp


@if(in_array(Route::currentRouteName(), ['branch.list', 'role.list', 'user.list', 'doctor.list']))
<li>
    <a href="{{ ($route) ? route($route) : '' }}" class="text-decoration-none hover-svg">
        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <path d="M13 2V24"></path>
            <path d="M2 13H24"></path>
        </svg>
    </a>
</li>
@endif