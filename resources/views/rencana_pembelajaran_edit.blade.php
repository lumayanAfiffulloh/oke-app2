@extends('layouts.app_modern', ['title'=>'Edit Rencana Pembelajaran'])
@section('content')
    <div class="card mb-3 bg-white">
        <div class="card-body p-0 ">
            <div class="card-header p-3 fs-5 fw-bolder" style="background-color: #ececec;">Edit Rencana Pembelajaran <span class="fw-bolder tw-text-blue-500">{{ $rencanaPembelajaran->id }}</span></div>
            <form action="/rencana_pembelajaran/{{ $rencanaPembelajaran->id }}" method="POST" class="px-3 py-3">
                @method('PUT')
                @csrf
                {{-- TAHUN --}}
                <div class="form-group mt-1 mb-3">
                    <label for="tahun" class="fw-bolder">Tahun</label>
                    <div class="col-md-2">
                        <input type="number" min="2024" max="2055" step="1" value="{{ old('tahun') ?? $rencanaPembelajaran->tahun }}" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun">
                    </div>
                    <span class="text-danger">{{ $errors->first('tahun') }}</span>
                </div>
                
                {{-- KLASIFIKASI --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="klasifikasi" class="fw-bolder">Klasifikasi</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="klasifikasi" id="pendidikan" value="pendidikan" {{ old('klasifikasi') ?? $rencanaPembelajaran->klasifikasi === 'pendidikan' ? 'checked' : '' }} onclick="updateCategoryOptions()">
                        <label class="form-check-label" for="pendidikan">Pendidikan</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="klasifikasi" id="pelatihan" value="pelatihan" {{ old('klasifikasi') ?? $rencanaPembelajaran->klasifikasi === 'pelatihan' ? 'checked' : '' }} onclick="updateCategoryOptions()">
                        <label class="form-check-label" for="pelatihan">Pelatihan</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('klasifikasi') }}</span>
                </div>

                {{-- KATEGORI --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="kategori" class="fw-bolder">Kategori</label>
                    <div class="col-md-6">
                        <select class="form-select" id="kategori" name="kategori">
                            <option value="" selected disabled id="pilih">-- Pilih Kategori --</option>
                            <option value="pendidikan" {{ old('kategori') ?? $rencanaPembelajaran->kategori === 'pendidikan' ? 'selected' : '' }} id="kategori-pendidikan">Pendidikan</option>
                            <option value="klasikal" {{ old('kategori') ?? $rencanaPembelajaran->kategori === 'klasikal' ? 'selected' : '' }} id="kategori-klasikal">Klasikal</option>
                            <option value="non-klasikal" {{ old('kategori') ?? $rencanaPembelajaran->kategori === 'non-klasikal' ? 'selected' : '' }} id="kategori-non-klasikal">Non-Klasikal</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('kategori') }}</span>
                    </div>
                </div>

                {{-- BENTUK JALUR --}}
                <div class="form-group mt-1 mb-3">
                    <label for="bentuk_jalur" class="fw-bolder">Bentuk Jalur</label>
                    <div class="col">
                        <input type="text" class="form-control @error('bentuk_jalur') is-invalid @enderror  " id="bentuk_jalur" name="bentuk_jalur" value="{{ old('bentuk_jalur') ?? $rencanaPembelajaran->bentuk_jalur}}">
                    </div>
                    <span class="text-danger">{{ $errors->first('bentuk_jalur') }}</span> 
                </div>

                {{-- NAMA PELATIHAN --}}
                <div class="form-group mt-1 mb-3">
                    <label for="nama_pelatihan" class="fw-bolder">Nama Pelatihan</label>
                    <div class="col">
                        <input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror" id="nama_pelatihan" name="nama_pelatihan" value="{{ old('nama_pelatihan') ?? $rencanaPembelajaran->nama_pelatihan}}">
                    </div>
                    <span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span> 
                </div>

                {{-- JAM PELAJARAN --}}
                <div class="form-group mt-1 mb-3">
                    <label for="jam_pelajaran" class="fw-bolder">Jam Pelajaran</label>
                    <div class="col-md-2">
                        <input type="number" min="1" max="50" step="1" value="{{ old('jam_pelajaran') ?? $rencanaPembelajaran->jam_pelajaran }}" class="form-control @error('jam_pelajaran') is-invalid @enderror" id="jam_pelajaran" name="jam_pelajaran">
                    </div>
                    <span class="text-danger">{{ $errors->first('jam_pelajaran') }}</span>
                </div>
                

                {{-- REGIONAL --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="regional" class="fw-bolder">Regional</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="regional" id="nasional" value="nasional" {{ old('regional') ?? $rencanaPembelajaran->regional === 'nasional' ? 'checked' : '' }}>
                        <label class="form-check-label" for="nasional">Nasional</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="regional" id="internasional" value="internasional" {{ old('regional') ?? $rencanaPembelajaran->regional === 'internasional' ? 'checked' : '' }}>
                        <label class="form-check-label" for="internasional">Internasional</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('regional') }}</span>
                </div>

                {{-- ANGGARAN --}}
                <div class="form-group mt-1 mb-3 col-md-4">
                    <label for="anggaran" class="fw-bolder">Anggaran</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start">Rp</span>
                        <input type="number" min="0" value="{{ old('anggaran') ?? $rencanaPembelajaran->anggaran }}" step="1000" class="form-control @error('anggaran') is-invalid @enderror"  id="anggaran" name="anggaran" oninput="formatRupiah(this)">
                    </div>
                    <span class="text-danger">{{ $errors->first('anggaran') }}</span>
                </div>

                {{-- PRIORITAS --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="prioritas" class="fw-bolder">Prioritas</label><br>
                    <div class="btn-group" role="group" aria-label="Default button group">
                        <input class="btn-check" type="radio" name="prioritas" id="rendah" value="rendah" {{ old('prioritas') ?? $rencanaPembelajaran->prioritas === 'rendah' ? 'checked' : '' }} autocomplete="off" >
                        <label class="btn btn-outline-success" for="rendah">Rendah</label>

                        <input class="btn-check" type="radio" name="prioritas" id="sedang" value="sedang" {{ old('prioritas') ?? $rencanaPembelajaran->prioritas === 'sedang' ? 'checked' : '' }} autocomplete="off">
                        <label class="btn btn-outline-warning" for="sedang">Sedang</label>

                        <input class="btn-check" type="radio" name="prioritas" id="tinggi" value="tinggi" {{ old('prioritas') ?? $rencanaPembelajaran->prioritas === 'tinggi' ? 'checked' : '' }} autocomplete="off">
                        <label class="btn btn-outline-danger" for="tinggi">Tinggi</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('prioritas') }}</span>
                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-start mt-3">
                    <form>
                        <button type="submit" class="btn btn-primary me-1 tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-blue-600 tw-duration-200">SIMPAN</button>
                    </form>
                    <a name="" id="" class="btn btn-warning me-1 tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-orange-400 tw-duration-200" href="/rencana_pembelajaran">BATAL EDIT</a>
                    <form action="/rencana_pembelajaran/{{ $rencanaPembelajaran->id }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger tw-transition tw-ease-in-out tw-delay-10 hover:tw-translate-y-0 hover:tw-scale-110 hover:tw-bg-red-500 tw-duration-200" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                            HAPUS DATA
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>


@endsection

{{-- SCRIPT UNTUK MEMUNCULKAN KATEGORI --}}
<script>
    function updateCategoryOptions() {
        // Disable all category options by default
        document.getElementById('kategori-pendidikan').style.display = 'none';
        document.getElementById('kategori-klasikal').style.display = 'none';
        document.getElementById('kategori-non-klasikal').style.display = 'none';
        
        // Get the selected classification
        const selectedKlasifikasi = document.querySelector('input[name="klasifikasi"]:checked').value;
        const kategoriSelect = document.getElementById('kategori');

        // Enable the appropriate category options
        if (selectedKlasifikasi === 'pendidikan') {
            document.getElementById('kategori-pendidikan').style.display = 'block';
            if (kategoriSelect.value !== 'pendidikan') {
            kategoriSelect.value = ''; // Deselect current option
            }
        } else if (selectedKlasifikasi === 'pelatihan') {
            document.getElementById('kategori-klasikal').style.display = 'block';
            document.getElementById('kategori-non-klasikal').style.display = 'block';
            if (kategoriSelect.value !== 'klasikal' && kategoriSelect.value !== 'non-klasikal') {
            kategoriSelect.value = ''; // Deselect current option
            }
        }
    }

    // Run the function on page load to handle old input
    window.onload = updateCategoryOptions;
</script>
