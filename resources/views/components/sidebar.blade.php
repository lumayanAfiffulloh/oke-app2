<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between mt-2" style="padding-left: 11px">
            <div class="logo-img">
                <img src={{ asset("img/logo.png")}} width="210" alt="" />
            </div>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
            {{-- HALAMAN LOGIN --}}
            @guest
            <li class="nav-small-cap mt-1">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link tw-ease-in-out tw-delay-10 active:tw-translate-x-2 hover:tw-translate-x-2 tw-duration-200" href="/" aria-expanded="false">
                    <span>
                        <i class="ti ti-layout-dashboard"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">SILAHKAN LOGIN</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="{{ route('login') }}" aria-expanded="false">
                    <span>
                        <i class="ti ti-user"></i>
                    </span>
                    <span class="hide-menu">LOGIN</span>
                </a>
            </li> 
            <li class="sidebar-item">
                <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="{{ route('register') }}" aria-expanded="false">
                    <span>
                        <i class="ti ti-user-plus"></i>
                    </span>
                    <span class="hide-menu">REGISTER</span>
                </a>
            </li> 
            @endguest
            @auth
                @can('admin')
                {{-- PEGAWAI --}}
                <li class="nav-small-cap mt-1">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">PEGAWAI</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/data_pegawai" aria-expanded="false">
                        <span>
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="hide-menu">Data Pegawai</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/data_pegawai/create" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-plus"></i>
                        </span>
                        <span class="hide-menu">Tambah Data Pegawai</span>
                    </a>    
                </li>
                @endcan

                {{-- PELAKSANAAN PEMBELAJARAN --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pelaksanaan Pembelajaran</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/pelaksanaan_pembelajaran" aria-expanded="false">
                        <span>
                            <i class="ti ti-checklist"></i>
                        </span>
                        <span class="hide-menu">Data Pelaksanaan</span>
                    </a>
                </li>

                {{-- RENCANA PEMBELAJARAN --}}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Rencana Pembelajaran (RP)</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/rencana_pembelajaran" aria-expanded="false">
                        <span>
                            <i class="ti ti-clipboard "></i>
                        </span>
                        <span class="hide-menu">RP Anda</span>
                    </a>
                </li>
                <li class="sidebar-item mb-5">
                    <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/rencana_pembelajaran/create" aria-expanded="false">
                        <span>
                            <i class="ti ti-clipboard-plus"></i>
                        </span>
                        <span class="hide-menu">Buat RP</span>
                    </a>
                </li>
                @endauth

                
            </ul>
        </nav>
    </div>
</aside>