<div class="page-breadcrumbs py-2 py-md-3">
    <nav class="navbar navbar-expand-sm p-0 fs-6 w-100" aria-label="Offcanvas navbar large">
        <div class="container-fluid">
            <a class="navbar-brand d-block d-sm-none" href="#">Menu</a>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label" style="top: 63px;">
                <div class="offcanvas-header end-0 position-absolute">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                @include("admin.nav_horizontal")
            </div>
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
                <li class="text-primary">Br. {{ Session::get('branch')?->name ?? '' }}</li>
            </ul>
            <button class="navbar-toggler border-0 ms-3 navbar-toggler p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</div>