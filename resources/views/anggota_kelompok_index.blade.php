@extends('layouts.main_layout', ['title' => 'Anggota Kelompok'])
@section('content')
  <div class="card mb-4 pb-4 bg-white">
    <div class="card-body px-0 py-0">
      <div class="card-header p-3 fs-5 fw-bolder d-flex justify-content-between align-items-center"
        style="background-color: #ececec;">
        <div>
          Anggota Kelompok
          <span class="fw-bolder text-primary">{{ Auth::user()->name }}</span>
        </div>
        @if ($hasKelompok)
          <span class="badge d-inline-flex align-items-center text-white"
            style="background-color: {{ $isKetua ? '#3b82f6' : '#6b7280' }};">
            @if ($isKetua)
              <i class="ti ti-crown me-1"></i> <span class="fs-2">Ketua Kelompok</span>
            @else
              <i class="ti ti-user me-1"></i> <span class="fs-2">Anggota Kelompok</span>
            @endif
          </span>
        @endif
      </div>

      <hr class="my-0">
      <!-- Notifikasi Kelompok -->
      @if ($belumKelompok)
        <div class="bg-warning bg-opacity-10 px-3 py-2 border-start border-4 border-warning mx-3 mt-3 mb-2 rounded">
          <p class="text-warning mb-0 small">
            <i class="ti ti-info-circle me-1"></i>
            Admin belum menetapkan Anda ke dalam kelompok
          </p>
        </div>
      @endif

      @if ($isKetua)
        <div class="card m-3 border shadow-none">
          <div class="card-header bg-warning bg-opacity-10 py-3 d-flex align-items-center">
            <i class="ti ti-brand-whatsapp fs-4 text-success me-2"></i>
            <h6 class="mb-0 fw-bold">Manajemen Grup WhatsApp</h6>
          </div>
          <div class="card-body p-3">
            <form action="{{ route('update-whatsapp-link') }}" method="POST">
              @csrf
              <div class="input-group">
                <span class="input-group-text bg-success text-white">
                  <i class="ti ti-link"></i>
                </span>
                <input type="url" name="whatsapp_link" class="form-control"
                  placeholder="https://chat.whatsapp.com/..." value="{{ $kelompok->link_grup_whatsapp ?? '' }}"
                  pattern="https://chat\.whatsapp\.com/.+" required>
                <button class="btn btn-success" type="submit">
                  <i class="ti ti-check me-1"></i> Simpan
                </button>
              </div>
              @if ($kelompok->link_grup_whatsapp)
                <div class="d-flex align-items-center mt-2">
                  <a href="{{ $kelompok->link_grup_whatsapp }}" target="_blank"
                    class="btn btn-sm btn-outline-success me-2">
                    <i class="ti ti-brand-whatsapp me-1"></i> Buka Grup
                  </a>
                  <small class="text-muted">
                    Terakhir diperbarui: {{ $kelompok->updated_at->diffForHumans() }}
                  </small>
                </div>
              @endif
            </form>
          </div>
        </div>
      @endif

      @if ($hasKelompok && !$isKetua)
        @if ($ketuaKelompok)
          <!-- Panel Informasi Ketua Kelompok -->
          <div class="alert alert-info fs-3 m-3">
            <div class="d-flex align-items-center">
              <i class="ti ti-crown fs-4 me-3 text-warning"></i>
              <div>
                <h6 class="fw-bolder mb-1">Ketua Kelompok Anda</h6>
                <div class="d-flex flex-wrap gap-4 mt-2">
                  <div>
                    <span class="text-muted small d-block">Nama</span>
                    <span class="fw-semibold">
                      {{ $ketuaKelompok->nama }}
                      @if ($ketuaKelompok->jenis_kelamin === 'L')
                        <i class="ti ti-gender-male text-primary ms-1"></i>
                      @else
                        <i class="ti ti-gender-female text-pink ms-1"></i>
                      @endif
                    </span>
                  </div>
                  <div>
                    <span class="text-muted small d-block">NPPU</span>
                    <span class="fw-semibold">{{ $ketuaKelompok->nppu }}</span>
                  </div>
                  <div>
                    <span class="text-muted small d-block">Kontak</span>
                    <span class="fw-semibold">{{ $ketuaKelompok->nomor_telepon ?? '-' }}</span>
                  </div>
                  <div>
                    <span class="text-muted small d-block">Email</span>
                    <span class="fw-semibold">{{ $ketuaKelompok->user->email ?? '-' }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif

        <div class="alert alert-success m-3 mb-2">
          <div class="d-flex align-items-center">
            <i class="ti ti-brand-whatsapp fs-3 me-3"></i>
            <div class="flex-grow-1">
              <h6 class="fw-semibold mb-1">Grup WhatsApp Kelompok</h6>
              <span>Gabung grup untuk koordinasi:</span>
            </div>
            @if ($kelompok->link_grup_whatsapp)
              <a href="{{ $kelompok->link_grup_whatsapp }}" target="_blank" class="btn btn-success">
                <i class="ti ti-brand-whatsapp me-1"></i> Join Grup
              </a>
            @else
              <a class="btn btn-dark opacity-25 disabled">
                <i class="ti ti-circle-off me-1"></i> Grup Belum Dibuat
              </a>
            @endif
          </div>
        </div>
      @endif

      <div class="table-responsive">
        <table class="table table-hover table-bordered mb-3" style="font-size: 0.7rem" id="myTable">
          <thead>
            <tr>
              <th class="align-middle">No.</th>
              <th>Nama</th>
              <th class="text-start">NPPU</th>
              <th>Email</th>
              <th>Status</th>
              <th>Unit Kerja</th>
              @if ($isKetua)
                <th>AKSI</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach ($dataPegawai as $item)
              <tr>
                <td class="text-center"> {{ $loop->iteration }} </td>
                <td>
                  <div>
                    <span>
                      @if ($item->jenis_kelamin === 'L')
                        <i class="ti ti-gender-male text-primary" style="font-size: 15px"></i>
                      @else
                        <i class="ti ti-gender-female" style="font-size: 15px; color: #ff70e7"></i>
                      @endif
                    </span>
                    {{ $item->nama }}
                  </div>
                </td>
                <td class="text-start">{{ $item->nppu }}</td>
                <td>{{ $item->user->email }}</td>
                <td>
                  @if ($item->status === 'aktif')
                    <span class="badge rounded-pill bg-success" style="font-size: 0.8rem">Aktif</span>
                  @else
                    <span class="badge rounded-pill bg-danger" style="font-size: 0.8rem">Non-Aktif</span>
                  @endif
                </td>
                <td>{{ $item->unitKerja->unit_kerja }}</td>
                @if ($isKetua)
                  <td>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                      data-bs-target="#detailModal{{ $item->id }}" title="Detail" style="font-size: 0.8rem"><span
                        class="ti ti-eye"></span></button>
                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal{{ $item->id }}" data-bs-backdrop="static"
                      data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel{{ $item->id }}"
                      aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-semibold" id="staticBackdropLabel{{ $item->id }}">
                              Detail Pegawai <span class="fw-semibold text-primary">{{ $item->nama }}</span>
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                              aria-label="Close"></button>
                          </div>
                          <div class="modal-body border border-2 mx-3 rounded-2">
                            <ol class="list-group">
                              <li class="list-group-item">
                                <h2 class="fs-5 d-inline">
                                  <span style="display:inline-block; width:200px;">Nama</span>
                                  <span class="text-secondary fw-bold">: {{ ucwords($item->nama) }} </span>
                                </h2>
                              </li>
                              <li class="list-group-item">
                                <h2 class="fs-5 d-inline">
                                  <span style="display:inline-block; width:200px;">NPPU</span>
                                  <span class="text-secondary fw-bold">: {{ ucwords($item->nppu) }}</span>
                                </h2>
                              </li>
                              <li class="list-group-item">
                                <h2 class="fs-5 d-inline">
                                  <span style="display:inline-block; width:200px;">Email</span>
                                  <span class="text-secondary fw-bold">: {{ $item->user->email }} </span>
                                </h2>
                              </li>
                              <li class="list-group-item">
                                <h2 class="fs-5 d-inline">
                                  <span style="display:inline-block; width:200px;">Status</span>
                                  <span class="text-secondary fw-bold">: @if ($item->status === 'aktif')
                                      <span class="badge rounded-pill bg-success">Aktif</span>
                                    @else
                                      <span class="badge rounded-pill bg-danger">Non-Aktif</span>
                                    @endif
                                  </span>
                                </h2>
                              </li>
                              <li class="list-group-item">
                                <h2 class="fs-5 d-inline">
                                  <span style="display:inline-block; width:200px;">Unit Kerja</span>
                                  <span class="text-secondary fw-bold">: {{ ucwords($item->unitKerja->unit_kerja) }}
                                  </span>
                                </h2>
                              </li>
                              <li class="list-group-item">
                                <h2 class="fs-5 d-inline">
                                  <span style="display:inline-block; width:200px;">Jabatan</span>
                                  <span class="text-secondary fw-bold">: {{ ucwords($item->jabatan->jabatan) }}</span>
                                </h2>
                              </li>
                              <li class="list-group-item">
                                <h2 class="fs-5 d-inline">
                                  <span style="display:inline-block; width:200px;">Pendidikan</span>
                                  <span class="text-secondary fw-bold">:
                                    {{ ucwords($item->pendidikanTerakhir->jenjangTerakhir->jenjang_terakhir) }}
                                  </span>
                                </h2>
                              </li>
                              <li class="list-group-item">
                                <h2 class="fs-5 d-inline">
                                  <span style="display:inline-block; width:200px;">Jurusan Pendidikan</span>
                                  <span class="text-secondary fw-bold">:
                                    {{ ucwords($item->pendidikanTerakhir->jurusan) }} </span>
                                </h2>
                              </li>
                            </ol>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
