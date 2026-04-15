<ul class="main-menu">
    <li class="slide__category"><span class="category-name">Dashboard</span></li>

    <li class="slide">
        <a href="{{ route('user.dashboard.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
            </svg>
            <span class="side-menu__label">Dashboards</span>
        </a>
    </li>

    <li class="slide__category"><span class="category-name">Tagihan</span></li>

    <li class="slide">
        <a href="{{ route('user.tagihan.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-2.16-2.66c-.44-.53-1.25-.58-1.78-.15-.53.43-.58 1.25-.15 1.78l3 3.69c.31.39.77.59 1.25.59s.95-.2 1.25-.59l3.98-5.04c.43-.53.38-1.35-.15-1.78-.53-.43-1.35-.38-1.78.15z" />
            </svg>
            <span class="side-menu__label">Tagihan Saya</span>
        </a>
    </li>
</ul>
