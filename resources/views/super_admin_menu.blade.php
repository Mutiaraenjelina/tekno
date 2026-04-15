<ul class="main-menu">
    <li class="slide__category"><span class="category-name">Dashboard</span></li>

    <li class="slide">
        <a href="{{ route('Dashboard.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
            </svg>
            <span class="side-menu__label">Dashboards</span>
        </a>
    </li>

    <li class="slide__category"><span class="category-name">Tagihan dan Pembayaran</span></li>

    <li class="slide">
        <a href="{{ route('TagihanUser.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M4 18h4v-2H4v2zm0-4h4v-2H4v2zm0-6v2h4V8H4zm6 10h10v-2H10v2zm0-4h10v-2H10v2zm0-6v2h10V8H10z" />
            </svg>
            <span class="side-menu__label">Assignment Tagihan User</span>
        </a>
    </li>
</ul>
