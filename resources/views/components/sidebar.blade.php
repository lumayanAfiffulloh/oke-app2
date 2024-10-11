@auth
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
        {{-- PROFIL --}}
        <li class="nav-small-cap mt-1">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Dashboard</span>
        </li>
        <li class="sidebar-item {{ Request::is('ganti_password') ? 'selected' : '' }}">
          <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/profil" aria-expanded="false">
            <span>
              <i class="ti ti-user-circle"></i>
            </span>
              <span class="hide-menu">Profil Anda</span>
          </a>
        </li>

        @can('admin')
        {{-- PEGAWAI --}}
        <li class="nav-small-cap mt-2">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">PEGAWAI</span>
        </li>
        <li class="sidebar-item {{ Request::is('data_pegawai*') ? 'selected' : '' }}">
          <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/data_pegawai" aria-expanded="false">
            <span>
              <i class="ti ti-user"></i>
            </span>
            <span class="hide-menu">Kelola Data Pegawai</span>
          </a>
        </li>
        <li class="sidebar-item {{ Request::is('kelompok*') ? 'selected' : '' }}">
          <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/kelompok" aria-expanded="false">
            <span>
              <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Kelola Kelompok</span>
          </a>    
        </li>

        {{-- DATA PELATIHAN --}}
        <li class="nav-small-cap mt-2">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">PELATIHAN</span>
        </li>
        <li class="sidebar-item {{ Request::is('data_pelatihan*') ? 'selected' : '' }}">
          <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/data_pelatihan" aria-expanded="false">
            <span>
              <i class="ti ti-file-stack"></i>
            </span>
            <span class="hide-menu">Data Pelatihan</span>
          </a>
        </li>
        @endcan


        {{-- RENCANA PEMBELAJARAN --}}
        <li class="nav-small-cap mt-2">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Rencana Pembelajaran (RPP)</span>
        </li>
        <li class="sidebar-item {{ Request::is('rencana_pembelajaran*') ? 'selected' : '' }}">
          <a class="sidebar-link tw-ease-in-out tw-delay-10 hover:tw-translate-x-2 tw-duration-200" href="/rencana_pembelajaran" aria-expanded="false">
            <span>
              <i class="ti ti-bookmarks "></i>
            </span>
            <span class="hide-menu">RPP Anda</span>
          </a>
        </li>
        
        
      </ul>
    </nav>
  </div>
</aside>
@endauth