<ul class="main-menu">
    <li class="slide__category"><span class="category-name">DASHBOARD</span></li>

    <li class="slide">
        <a href="{{ route('Dashboard.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none" />
                <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
            </svg>
            <span class="side-menu__label">Dashboard</span>
        </a>
    </li>

    <li class="slide__category"><span class="category-name">PENGELOLAAN</span></li>

    <li class="slide has-sub">
        <a href="javascript:void(0);" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M4 18h4v-2H4v2zm0-4h4v-2H4v2zm0-6v2h4V8H4zm6 10h10v-2H10v2zm0-4h10v-2H10v2zm0-6v2h10V8H10z" />
            </svg>
            <span class="side-menu__label">Tagihan</span>
            <i class="ri-arrow-right-s-line side-menu__angle"></i>
        </a>
        <ul class="slide-menu child1">
            <li class="slide side-menu__label1">
                <a href="javascript:void(0)">Tagihan</a>
            </li>
            <li class="slide">
                <a href="{{ route('ModuleTagihan.index') }}" class="side-menu__item">Daftar Tagihan</a>
            </li>
            <li class="slide">
                <a href="{{ route('ModuleTagihan.create') }}" class="side-menu__item">Buat Tagihan</a>
            </li>
        </ul>
    </li>

    <li class="slide">
        <a href="{{ route('Pembayaran.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M20 8H4V6h16v2zm0 2H4v8h16v-8zm-2 6H6v-4h12v4z" />
            </svg>
            <span class="side-menu__label">Pembayaran</span>
        </a>
    </li>

    <li class="slide">
        <a href="{{ route('Laporan.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M5 3h14v18H5V3zm2 2v14h10V5H7zm2 2h6v2H9V7zm0 4h6v2H9v-2zm0 4h4v2H9v-2z" />
            </svg>
            <span class="side-menu__label">Laporan</span>
        </a>
    </li>

    <li class="slide">
        <a href="{{ route('ModulePelanggan.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M9 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3" />
                <path d="M9 13c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z" />
            </svg>
            <span class="side-menu__label">Penerima Tagihan</span>
        </a>
    </li>

    <li class="slide">
        <a href="{{ route('TagihanUser.index') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M3 5h18v2H3V5zm0 6h18v2H3v-2zm0 6h18v2H3v-2z" />
            </svg>
            <span class="side-menu__label">Link & QR Pembayaran</span>
        </a>
    </li>

    <li class="slide__category"><span class="category-name">PENGATURAN</span></li>

    <li class="slide">
        <a href="{{ route('Admin.profile') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            <span class="side-menu__label">Profil Admin</span>
        </a>
    </li>

    <li class="slide">
        <a href="{{ route('Admin.settings') }}" class="side-menu__item">
            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24" width="24px" fill="#5f6368">
                <path d="M0 0h24v24H0V0z" fill="none"></path>
                <path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.52l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.34.24.52.49.52h4c.25 0 .46-.18.49-.52l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z" />
            </svg>
            <span class="side-menu__label">Pengaturan</span>
        </a>
    </li>
</ul>
