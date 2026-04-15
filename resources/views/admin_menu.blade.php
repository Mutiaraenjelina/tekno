<ul class="main-menu">
    <!-- Start::slide__category -->
    <li class="slide__category"><span class="category-name">Dashboard</span></li>
    <!-- End::slide__category -->

    <!-- Start::slide -->
    <li class="slide">
        <a href="{{ route('Dashboard.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
            </svg>
            <span class="side-menu__label">Dashboards</span>
        </a>
    </li>
    <!-- End::slide -->

    <!-- Start::slide__category -->
    <li class="slide__category"><span class="category-name">Tagihan dan Pembayaran</span></li>
    <!-- End::slide__category -->

    <!-- Start::slide -->
    <li class="slide">
        <a href="{{ route('ModuleTagihan.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M4 18h4v-2H4v2zm0-4h4v-2H4v2zm0-6v2h4V8H4zm6 10h10v-2H10v2zm0-4h10v-2H10v2zm0-6v2h10V8H10z" />
            </svg>
            <span class="side-menu__label">Tagihan</span>
        </a>
    </li>
    <!-- End::slide -->

    <!-- Start::slide -->
    <li class="slide">
        <a href="{{ route('ModulePelanggan.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M9 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 7c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4zm6 5H3v-2c0-1.5 3.58-2.5 6-2.5s6 1 6 2.5v2z" opacity=".3" />
                <path d="M13 14c2.21 0 4-1.79 4-4s-1.79-4-4-4c-.47 0-.91.1-1.33.27C11.79 7.35 12 8.63 12 10s-.21 2.65-.33 3.73c.42.17.86.27 1.33.27zm-6 0c.47 0 .91-.1 1.33-.27-.12-1.08-.33-2.36-.33-3.73s.21-2.65.33-3.73C4.91 5.9 4.47 6 4 6c-2.21 0-4 1.79-4 4s1.79 4 4 4zm0 3c-2.67 0-8 1.34-8 4v3h8v-3c0-1.13.9-2.09 2-2.83-.59-.81-1.26-1.41-2-1.84zm6 0c-.74.43-1.41 1.03-2 1.84 1.1.74 2 1.7 2 2.83v3h8v-3c0-2.66-5.33-4-8-4z" />
            </svg>
            <span class="side-menu__label">Pelanggan</span>
        </a>
    </li>
    <!-- End::slide -->

    <!-- Start::slide -->
    <li class="slide">
        <a href="{{ route('TagihanUser.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M4 18h4v-2H4v2zm0-4h4v-2H4v2zm0-6v2h4V8H4zm6 10h10v-2H10v2zm0-4h10v-2H10v2zm0-6v2h10V8H10z" />
            </svg>
            <span class="side-menu__label">Assignment Tagihan User</span>
        </a>
    </li>
    <!-- End::slide -->

        <!-- Start::slide__category
    <li class="slide__category"><span class="category-name">Laporan-laporan</span></li>
     End::slide__category -->

        <!-- Start::slide 
    <li class="slide">
        <a href="icons.html" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24"
                height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <g>
                    <rect fill="none" height="24" width="24" />
                </g>
                <g>
                    <g />
                    <g>
                        <path
                            d="M6.44,9.86L7.02,5H5.05L4.04,9.36c-0.1,0.42-0.01,0.84,0.25,1.17C4.43,10.71,4.73,11,5.23,11 C5.84,11,6.36,10.51,6.44,9.86z"
                            opacity=".3" />
                        <path
                            d="M9.71,11C10.45,11,11,10.41,11,9.69V5H9.04L8.49,9.52c-0.05,0.39,0.07,0.78,0.33,1.07 C9.05,10.85,9.37,11,9.71,11z"
                            opacity=".3" />
                        <path
                            d="M14.22,11c0.41,0,0.72-0.15,0.96-0.41c0.25-0.29,0.37-0.68,0.33-1.07L14.96,5H13v4.69 C13,10.41,13.55,11,14.22,11z"
                            opacity=".3" />
                        <path
                            d="M18.91,4.99L16.98,5l0.58,4.86c0.08,0.65,0.6,1.14,1.21,1.14c0.49,0,0.8-0.29,0.93-0.47 c0.26-0.33,0.35-0.76,0.25-1.17L18.91,4.99z"
                            opacity=".3" />
                        <path
                            d="M21.9,8.89l-1.05-4.37c-0.22-0.9-1-1.52-1.91-1.52H5.05C4.15,3,3.36,3.63,3.15,4.52L2.1,8.89 c-0.24,1.02-0.02,2.06,0.62,2.88C2.8,11.88,2.91,11.96,3,12.06V19c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2v-6.94 c0.09-0.09,0.2-0.18,0.28-0.28C21.92,10.96,22.15,9.91,21.9,8.89z M13,5h1.96l0.54,4.52c0.05,0.39-0.07,0.78-0.33,1.07 C14.95,10.85,14.63,11,14.22,11C13.55,11,13,10.41,13,9.69V5z M8.49,9.52L9.04,5H11v4.69C11,10.41,10.45,11,9.71,11 c-0.34,0-0.65-0.15-0.89-0.41C8.57,10.3,8.45,9.91,8.49,9.52z M4.29,10.53c-0.26-0.33-0.35-0.76-0.25-1.17L5.05,5h1.97L6.44,9.86 C6.36,10.51,5.84,11,5.23,11C4.73,11,4.43,10.71,4.29,10.53z M19,19H5v-6.03C5.08,12.98,5.15,13,5.23,13 c0.87,0,1.66-0.36,2.24-0.95c0.6,0.6,1.4,0.95,2.31,0.95c0.87,0,1.65-0.36,2.23-0.93c0.59,0.57,1.39,0.93,2.29,0.93 c0.84,0,1.64-0.35,2.24-0.95c0.58,0.59,1.37,0.95,2.24,0.95c0.08,0,0.15-0.02,0.23-0.03V19z M19.71,10.53 C19.57,10.71,19.27,11,18.77,11c-0.61,0-1.14-0.49-1.21-1.14L16.98,5l1.93-0.01l1.05,4.37C20.06,9.78,19.97,10.21,19.71,10.53z" />
                    </g>
                </g>
            </svg>
            <span class="side-menu__label">Laporan</span>
        </a>
    </li>
     End::slide

     Start::slide
    <li class="slide has-sub">
        <a href="javascript:void(0);" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M5 5h15v3H5zm12 5h3v9h-3zm-7 0h5v9h-5zm-5 0h3v9H5z" opacity=".3" />
                <path
                    d="M20 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 19H5v-9h3v9zm7 0h-5v-9h5v9zm5 0h-3v-9h3v9zm0-11H5V5h15v3z" />
            </svg>
            <span class="side-menu__label">Laporan</span>
            <i class="ri-arrow-right-s-line side-menu__angle"></i>
        </a>
        <ul class="slide-menu child1">
            <li class="slide side-menu__label1">
                <a href="javascript:void(0)">Laporan</a>
            </li>
            <li class="slide">
                <a href="tables.html" class="side-menu__item">Tables</a>
            </li>
            <li class="slide">
                <a href="grid-tables.html" class="side-menu__item">Grid JS Tables</a>
            </li>
            <li class="slide">
                <a href="data-tables.html" class="side-menu__item">Data Tables</a>
            </li>
        </ul>
    </li>
    End::slide -->
</ul>
