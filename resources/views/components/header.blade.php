<header class="app-header">
	<nav class="navbar navbar-expand-lg navbar-light">
		<ul class="navbar-nav">
			<li class="nav-item d-block d-xl-none">
				<a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
					<i class="ti ti-menu-2"></i>
				</a>
			</li>
		</ul>
		<div class="navbar-collapse justify-content-end px-0" id="navbarNav">
			<ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

				<div class="border border-2 border-primary border-opacity-50 rounded fw-bolder" style="padding: 6px 10px;">{{
					Auth::user()->name }} (<span class="text-warning">@foreach (Auth::user()->roles as $role)
						{{ ucwords(str_replace('_', ' ', $role->role)) }}
						@if (!$loop->last)
						,
						@endif
						@endforeach</span>)</div>
				<li class="nav-item dropdown">
					<a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
						aria-expanded="false">
						@if (Auth::user()->dataPegawai && Auth::user()->dataPegawai->foto)
						<img src="{{ Storage::url(Auth::user()->dataPegawai->foto) }}" alt="Foto Profil"
							style="object-fit: cover; height: 35px; width: 35px;" class="rounded-circle">
						@else
						<img src={{ asset("modern/src/assets/images/profile/user-1.jpg") }} alt="" width="35" height="35"
							class="rounded-circle">
						@endif
					</a>

					<div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
						<div class="message-body">
							<a href="profil" class="d-flex dropdown-item">
								<i class="ti ti-user fs-6 me-2"></i>
								<p class="fs-3">Profil Saya</p>
							</a>
							<a href="ganti_password" class="d-flex dropdown-item mb-2">
								<i class="ti ti-settings fs-6 me-2"></i>
								<p class="fs-3">Ganti Password</p>
							</a>
							<a href="{{ route('logout') }}" class="d-block btn btn-outline-danger mx-2"
								onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								<p class=" fs-3">Logout</p>
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</header>