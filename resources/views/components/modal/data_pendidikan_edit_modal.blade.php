<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title fs-5 fw-bold">Edit Data Pendidikan <span id="jurusanName" class="text-primary"></span>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="editFormID" method="POST" action="{{ route('data_pendidikan.update', $item->id) }}">
      @method('PUT')
      @csrf
      <div class="modal-body border border-2 mx-3 rounded-2">
        {{-- JENJANG --}}
        <div class="form-group mt-1 mb-3">
          <label class="fw-semibold" for="jenjang">Jenjang<span class="text-danger">*</span></label><br>
          <div id="jenjangContainer"></div>
          <span class="text-danger" id="jenjangError"></span>
        </div>

        {{-- JURUSAN --}}
        <div class="form-group mt-1 mb-3">
          <label for="jurusan" class="fw-bolder">Jurusan<span class="text-danger">*</span></label>
          <div class="col">
            <input type="text" class="form-control" id="jurusan" name="jurusan">
          </div>
          <span class="text-danger" id="jurusanError"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" id="editAlert">Simpan</button>
      </div>
    </form>
  </div>
</div>
