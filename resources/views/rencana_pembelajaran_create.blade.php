@extends('layouts.app_modern', ['title'=>'Buat Rencana Pembelajaran'])
@section('content')
<style>
    /* Hide category container initially */
    #category-container {
        display: none;
    }
</style>
    <div class="card bg-white">
        <div class="card-body p-0">
            <div class="card-header p-3 fs-5 fw-bolder">Buat Rencana Pembelajaran</div>
            <form action="/rencana_pembelajaran" method="POST" class="px-4 py-2">
                @csrf
                {{-- TAHUN --}}
                <div class="form-group mt-1 mb-3">
                    <label for="tahun" class="fw-bolder">Tahun</label>
                    <div class="col-md-2">
                        <input type="number" min="2024" max="2099" step="1" value="2024" class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun">
                    </div>
                    <span class="text-danger">{{ $errors->first('tahun') }}</span>
                </div>

                {{-- KLASIFIKASI --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="klasifikasi" class="fw-bolder">Klasifikasi</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="klasifikasi" id="pendidikan" value="pendidikan"  onclick="updateCategoryOptions()">
                        <label class="form-check-label" for="pendidikan">Pendidikan</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="klasifikasi" id="pelatihan" value="pelatihan"  onclick="updateCategoryOptions()">
                        <label class="form-check-label" for="pelatihan">Pelatihan</label>
                    </div>
                </div>

                {{-- KATEGORI KLASIFIKASI --}}
                <div class="form-group mt-1 mb-3" > 
                    <label for="kategori_klasifikasi" class="fw-bolder">Kategori Klasifikasi</label><br>
                    <div id="category-container">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kategori_klasifikasi" id="gelar" value="gelar">
                            <label class="form-check-label" for="gelar">Gelar</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kategori_klasifikasi" id="non-gelar" value="non-gelar">
                            <label class="form-check-label" for="non-gelar">Non-Gelar</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kategori_klasifikasi" id="teknis" value="teknis">
                            <label class="form-check-label" for="teknis">Teknis</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kategori_klasifikasi" id="fungsional" value="fungsional">
                            <label class="form-check-label" for="fungsional">Fungsional</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kategori_klasifikasi" id="sosial kultural" value="sosial kultural">
                            <label class="form-check-label" for="sosial kultural">Sosial Kultural</label>
                        </div>
                    </div>
                </div>

                {{-- KATEGORI --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="kategori" class="fw-bolder">Kategori</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="kategori" id="klasikal" value="klasikal">
                        <label class="form-check-label" for="klasikal">Klasikal</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="kategori" id="non-klasikal" value="non-klasikal">
                        <label class="form-check-label" for="non-klasikal">Non-Klasikal</label>
                    </div>
                </div>

                {{-- BENTUK JALUR --}}
                <div class="form-group mt-1 mb-3">
                    <label for="bentuk_jalur" class="fw-bolder">Bentuk Jalur</label>
                    <div class="col">
                        <input type="text" class="form-control @error('bentuk_jalur') is-invalid @enderror" id="bentuk_jalur" name="bentuk_jalur">
                    </div>
                    <span class="text-danger">{{ $errors->first('bentuk_jalur') }}</span> 
                </div>

                {{-- NAMA PELATIHAN --}}
                <div class="form-group mt-1 mb-3">
                    <label for="nama_pelatihan" class="fw-bolder">Nama Pelatihan</label>
                    <div class="col">
                        <input type="text" class="form-control @error('nama_pelatihan') is-invalid @enderror" id="nama_pelatihan" name="nama_pelatihan">
                    </div>
                    <span class="text-danger">{{ $errors->first('nama_pelatihan') }}</span> 
                </div>

                {{-- JAM PELAJARAN --}}
                <div class="form-group mt-1 mb-3">
                    <label for="jam_pelajaran" class="fw-bolder">Jam Pelajaran</label>
                    <div class="col-md-2">
                        <input type="number" min="1" max="50" step="1" value="0" class="form-control @error('jam_pelajaran') is-invalid @enderror" id="jam_pelajaran" name="jam_pelajaran">
                    </div>
                    <span class="text-danger">{{ $errors->first('jam_pelajaran') }}</span>
                </div>
                

                {{-- REGIONAL --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="regional" class="fw-bolder">Regional</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="regional" id="nasional" value="nasional">
                        <label class="form-check-label" for="nasional">Nasional</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="regional" id="internasional" value="internasional">
                        <label class="form-check-label" for="internasional">Internasional</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('regional') }}</span>
                </div>

                {{-- ANGGARAN --}}
                <div class="form-group mt-1 mb-3 col-md-4">
                    <label for="anggaran" class="fw-bolder">Anggaran</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start">Rp</span>
                        <input type="number" min="0" value="0" step="1000" class="form-control @error('anggaran') is-invalid @enderror"  id="anggaran" name="anggaran" >
                    </div>
                    <span class="text-danger">{{ $errors->first('anggaran') }}</span>
                </div>

                {{-- PRIORITAS --}}
                <div class="form-group mt-1 mb-3"> 
                    <label for="prioritas" class="fw-bolder">Prioritas</label><br>
                    <div class="btn-group btn-group" role="group" aria-label="Default button group">
                        <input class="btn-check" type="radio" name="prioritas" id="rendah" value="rendah" autocomplete="off" >
                        <label class="btn btn-outline-success" for="rendah">Rendah</label>

                        <input class="btn-check" type="radio" name="prioritas" id="sedang" value="sedang" autocomplete="off">
                        <label class="btn btn-outline-warning" for="sedang">Sedang</label>

                        <input class="btn-check" type="radio" name="prioritas" id="tinggi" value="tinggi" autocomplete="off">
                        <label class="btn btn-outline-danger" for="tinggi">Tinggi</label>
                    </div>
                    <span class="text-danger">{{ $errors->first('prioritas') }}</span>
                </div>

                <button type="submit" class="btn btn-primary mb-2">SIMPAN</button>
            </form>
        </div>
    </div>
@endsection

{{-- SCRIPT UNTUK MEMUNCULKAN KATEGORI KLASIFIKASI --}}
<script>
    function updateCategoryOptions() {
        // Get selected classification
        const selectedClassification = document.querySelector('input[name="klasifikasi"]:checked')?.value;

        // Get all category radio buttons
        const categoryRadios = document.querySelectorAll('input[name="kategori_klasifikasi"]');

        // Show category container once a classification is selected
        const categoryContainer = document.getElementById('category-container');
        categoryContainer.style.display = 'block';
        
        // Define category options based on classification
        const educationCategories = ['gelar', 'non-gelar'];
        const trainingCategories = ['teknis', 'fungsional', 'sosial kultural'];
        
        // Update visibility of category options
        categoryRadios.forEach(radio => {
            const value = radio.value;
            if (selectedClassification === 'pendidikan') {
                if (educationCategories.includes(value)) {
                    radio.parentElement.style.display = 'inline-block';
                } else {
                    radio.parentElement.style.display = 'none';
                }
            } else if (selectedClassification === 'pelatihan') {
                if (trainingCategories.includes(value)) {
                    radio.parentElement.style.display = 'inline-block';
                } else {
                    radio.parentElement.style.display = 'none';
                }
            } else {
                radio.parentElement.style.display = 'inline-block';
            }
        });
    }
</script>