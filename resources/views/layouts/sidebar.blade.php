<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/">
            <img src="{{ asset('img/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-dashboard"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-dashboard"></i>
                        {{ __('lang.dashboard') }}
                    </span>
                </a>
            </li>

            @if (auth()->user()->level == 1)
            <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">master</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('kategori.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-cube"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-cube"></i>
                        {{ __('lang.category') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('produk.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-cubes"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-cubes"></i>
                        {{ __('lang.product') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('member.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-id-card"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-id-card"></i>
                        {{ __('lang.member') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('supplier.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-truck"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-truck"></i>
                        {{ __('lang.supllier') }}
                    </span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ __('lang.transaction') }}
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pengeluaran.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-money"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-money"></i>
                        {{ __('lang.expenses') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pembelian.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-download"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-download"></i>
                        {{ __('lang.puchasing') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('penjualan.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-upload"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-upload"></i>
                        {{ __('lang.sales') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaksi.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-cart-arrow-down"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-cart-arrow-down"></i>
                        {{ __('lang.active.transaction') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaksi.baru') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-cart-arrow-down"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-cart-arrow-down"></i>
                        {{ __('lang.new.transaction') }}
                    </span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ __('lang.reports') }}</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('laporan.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-file-pdf-o"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-file-pdf-o"></i>
                        {{ __('lang.report') }}
                    </span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">{{ __('lang.setting') }}</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-users"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-users"></i>
                        {{ __('lang.user') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('setting.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-cogs"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-cogs"></i>
                        {{ __('lang.config') }}
                    </span>
                </a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaksi.index') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-cart-arrow-down"></i>
                    </span>
                    <span class="sidenav-normal">
                        <i class="fa fa-cart-arrow-down"></i>
                        Transaksi Aktif
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaksi.baru') }}">
                    <span class="sidenav-mini-icon">
                        <i class="fa fa-cart-arrow-down"></i>
                    </span>
                    <span class="sidenav-normal">
                        Transaksi Baru
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="../../pages/dashboards/landing.html">
                    <span class="sidenav-mini-icon"> L </span>
                    <span class="sidenav-normal"> Landing </span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>