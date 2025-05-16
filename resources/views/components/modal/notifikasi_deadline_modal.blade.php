<div class="modal fade" id="notifDeadlineModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
	data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content shadow-lg rounded-4 border-0 animate__animated animate__fadeInDown">
			<div class="modal-body p-4">
				<div class="d-flex align-items-start">
					<div class="me-3">
						<i class="ti ti-alert-triangle text-warning display-5"></i>
					</div>
					<div>
						<h5 class="fw-bold text-dark mb-2">⏰ Peringatan Tenggat Waktu!</h5>
						<p class="text-muted mb-3">Berikut adalah daftar tenggat rencana yang akan segera berakhir:</p>
						<div class="mb-3">
							@foreach(session('deadline_notification') as $deadline)
							<div class="border rounded-3 p-3 mb-2 bg-light">
								<strong>{{ ucwords(str_replace('_', ' ', $deadline->kategoriTenggat->kategori_tenggat)) }}</strong><br>
								<small>
									Mulai: {{ \Carbon\Carbon::parse($deadline->tanggal_mulai)->format('d M Y') }}
									pukul {{ \Carbon\Carbon::parse($deadline->jam_mulai)->format('H:i') }}<br>
									Berakhir: {{ \Carbon\Carbon::parse($deadline->tanggal_selesai)->format('d M Y') }},
									pukul {{ \Carbon\Carbon::parse($deadline->jam_selesai)->format('H:i') }}
								</small>
							</div>
							@endforeach
						</div>
						<div class="text-end">
							<button class="btn btn-warning px-3 text-white btn-sm" data-bs-dismiss="modal">
								<i class="ti ti-check me-2"></i>Saya Mengerti
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>