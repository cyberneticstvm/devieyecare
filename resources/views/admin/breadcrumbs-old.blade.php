<!-- Start:: Breadcrumbs -->
<div class="page-breadcrumbs py-2 py-md-3">
    <div class="container-fluid px-2 px-md-4">
        <div class="d-flex align-items-stretch justify-content-between">
            <div class="back-btn d-flex align-items-center">
                <a href="javascript:history.back()" class="d-flex align-items-center hover-svg">
                    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 7H15M1 7L7 13M1 7L7 1" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="ms-2 d-none d-md-block fs-14 text-black-50">Back</span>
                </a>
            </div>
            <div class="right-breadcrumb d-flex flex-fill align-items-center justify-content-between">
                <div class="page-name fs-20 fw-bold ms-md-4 ms-2 position-relative">Branch: {{ Session::get('branch')?->name ?? '' }}</div>
                <ul class="page-action list-unstyled ms-auto mb-0 gap-3 d-flex align-items-center justify-content-end">
                    <li class="position-relative d-md-block d-none">
                        {{ html()->form('POST')->route('search.registration.show')->open() }}
                        <input class="form-control position-absolute px-3 rounded-pill z-0" type="text" id="PageSearchInput" name="search_term" placeholder="Search..." />
                        <a href="#" class="hover-svg position-relative text-decoration-none z-3" id="searchToggleBtn">
                            <svg width="26" height="26" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3.75 12.5C3.75 13.6491 3.97633 14.7869 4.41605 15.8485C4.85578 16.9101 5.5003 17.8747 6.31282 18.6872C7.12533 19.4997 8.08992 20.1442 9.15152 20.5839C10.2131 21.0237 11.3509 21.25 12.5 21.25C13.6491 21.25 14.7869 21.0237 15.8485 20.5839C16.9101 20.1442 17.8747 19.4997 18.6872 18.6872C19.4997 17.8747 20.1442 16.9101 20.5839 15.8485C21.0237 14.7869 21.25 13.6491 21.25 12.5C21.25 11.3509 21.0237 10.2131 20.5839 9.15152C20.1442 8.08992 19.4997 7.12533 18.6872 6.31282C17.8747 5.5003 16.9101 4.85578 15.8485 4.41605C14.7869 3.97633 13.6491 3.75 12.5 3.75C11.3509 3.75 10.2131 3.97633 9.15152 4.41605C8.08992 4.85578 7.12533 5.5003 6.31282 6.31282C5.5003 7.12533 4.85578 8.08992 4.41605 9.15152C3.97633 10.2131 3.75 11.3509 3.75 12.5Z"></path>
                                <path d="M26.25 26.25L18.75 18.75"></path>
                            </svg>
                        </a>
                        {{ html()->form()->close() }}
                    </li>
                    @include("admin.action")
                    <li>
                        <a href="javascript:void(0);" class="text-decoration-none btn-toggle-leftsidebar hover-svg">
                            <svg width="26" height="26" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 7.5H25" />
                                <path d="M8.75 15H25" />
                                <path d="M12.5 22.5H25" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End:: Breadcrumbs -->