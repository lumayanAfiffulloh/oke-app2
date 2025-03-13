<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $data_pelatihan_id
 * @property int $kategori_id
 * @property int $region_id
 * @property int $anggaran_min
 * @property int $anggaran_maks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DataPelatihan|null $dataPelatihan
 * @property-read \App\Models\Kategori|null $kategori
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan whereAnggaranMaks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan whereAnggaranMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan whereDataPelatihanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPelatihan whereUpdatedAt($value)
 */
	class AnggaranPelatihan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $jenjang_id
 * @property int $region_id
 * @property int $anggaran_min
 * @property int $anggaran_maks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jenjang|null $jenjangs
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan whereAnggaranMaks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan whereAnggaranMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan whereJenjangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnggaranPendidikan whereUpdatedAt($value)
 */
	class AnggaranPendidikan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kategori_id
 * @property string $bentuk_jalur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kategori|null $kategori
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencanaPembelajaran
 * @property-read int|null $rencana_pembelajaran_count
 * @method static \Database\Factories\BentukJalurFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur query()
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereBentukJalur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereKategoriId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereUpdatedAt($value)
 */
	class BentukJalur extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kelompok_can_validating_id
 * @property string $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\kelompokCanValidating|null $kelompokCanValidating
 * @method static \Illuminate\Database\Eloquent\Builder|CatatanValidasiKelompok newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CatatanValidasiKelompok newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CatatanValidasiKelompok query()
 * @method static \Illuminate\Database\Eloquent\Builder|CatatanValidasiKelompok whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatatanValidasiKelompok whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatatanValidasiKelompok whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatatanValidasiKelompok whereKelompokCanValidatingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CatatanValidasiKelompok whereUpdatedAt($value)
 */
	class CatatanValidasiKelompok extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $nppu
 * @property string $status
 * @property int $pendidikan_terakhir_id
 * @property string $jenis_kelamin
 * @property string|null $nomor_telepon
 * @property string|null $foto
 * @property int $unit_kerja_id
 * @property int $jabatan_id
 * @property int $user_id
 * @property int $kelompok_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jabatan|null $jabatan
 * @property-read \App\Models\Kelompok|null $kelompok
 * @property-read \App\Models\Kelompok|null $ketuaKelompok
 * @property-read \App\Models\PendidikanTerakhir|null $pendidikanTerakhir
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencanaPembelajaran
 * @property-read int|null $rencana_pembelajaran_count
 * @property-read \App\Models\UnitKerja|null $unitKerja
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\DataPegawaiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai query()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereJabatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereKelompokId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereNomorTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereNppu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai wherePendidikanTerakhirId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereUnitKerjaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereUserId($value)
 */
	class DataPegawai extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $rumpun_id
 * @property string $kode
 * @property string $nama_pelatihan
 * @property string|null $deskripsi
 * @property int $jp
 * @property string|null $materi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnggaranPelatihan> $anggaranPelatihan
 * @property-read int|null $anggaran_pelatihan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencanaPembelajaran
 * @property-read int|null $rencana_pembelajaran_count
 * @property-read \App\Models\Rumpun|null $rumpun
 * @method static \Database\Factories\DataPelatihanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan query()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereJp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereMateri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereRumpunId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereUpdatedAt($value)
 */
	class DataPelatihan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $jurusan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnggaranPendidikan> $anggaranPendidikan
 * @property-read int|null $anggaran_pendidikan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Jenjang> $jenjangs
 * @property-read int|null $jenjangs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencanaPembelajaran
 * @property-read int|null $rencana_pembelajaran_count
 * @method static \Database\Factories\DataPendidikanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan query()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereJurusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereUpdatedAt($value)
 */
	class DataPendidikan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $jabatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataPegawai> $dataPegawai
 * @property-read int|null $data_pegawai_count
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jabatan whereUpdatedAt($value)
 */
	class Jabatan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $jenis_pendidikan
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencanaPembelajaran
 * @property-read int|null $rencana_pembelajaran_count
 * @method static \Illuminate\Database\Eloquent\Builder|JenisPendidikan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisPendidikan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisPendidikan query()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisPendidikan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisPendidikan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisPendidikan whereJenisPendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisPendidikan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenisPendidikan whereUpdatedAt($value)
 */
	class JenisPendidikan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $jenjang
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnggaranPendidikan> $anggaranPendidikan
 * @property-read int|null $anggaran_pendidikan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataPendidikan> $dataPendidikan
 * @property-read int|null $data_pendidikan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencanaPendidikan
 * @property-read int|null $rencana_pendidikan_count
 * @method static \Illuminate\Database\Eloquent\Builder|Jenjang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jenjang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jenjang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Jenjang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jenjang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jenjang whereJenjang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jenjang whereUpdatedAt($value)
 */
	class Jenjang extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $jenjang_terakhir
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PendidikanTerakhir> $pendidikanTerakhir
 * @property-read int|null $pendidikan_terakhir_count
 * @method static \Illuminate\Database\Eloquent\Builder|JenjangTerakhir newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenjangTerakhir newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenjangTerakhir query()
 * @method static \Illuminate\Database\Eloquent\Builder|JenjangTerakhir whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenjangTerakhir whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenjangTerakhir whereJenjangTerakhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JenjangTerakhir whereUpdatedAt($value)
 */
	class JenjangTerakhir extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $kategori
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnggaranPelatihan> $anggaranPelatihan
 * @property-read int|null $anggaran_pelatihan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BentukJalur> $bentukJalur
 * @property-read int|null $bentuk_jalur_count
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kategori whereUpdatedAt($value)
 */
	class Kategori extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriTenggatWaktu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriTenggatWaktu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KategoriTenggatWaktu query()
 */
	class KategoriTenggatWaktu extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $id_ketua
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataPegawai> $anggota
 * @property-read int|null $anggota_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\kelompokCanValidating> $kelompokCanValidating
 * @property-read int|null $kelompok_can_validating_count
 * @property-read \App\Models\DataPegawai|null $ketua
 * @method static \Database\Factories\KelompokFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok whereIdKetua($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok whereUpdatedAt($value)
 */
	class Kelompok extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $jenjang_terakhir_id
 * @property string $jurusan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataPegawai> $dataPegawai
 * @property-read int|null $data_pegawai_count
 * @property-read \App\Models\JenjangTerakhir|null $jenjangTerakhir
 * @method static \Illuminate\Database\Eloquent\Builder|PendidikanTerakhir newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendidikanTerakhir newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PendidikanTerakhir query()
 * @method static \Illuminate\Database\Eloquent\Builder|PendidikanTerakhir whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendidikanTerakhir whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendidikanTerakhir whereJenjangTerakhirId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendidikanTerakhir whereJurusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PendidikanTerakhir whereUpdatedAt($value)
 */
	class PendidikanTerakhir extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $region
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnggaranPelatihan> $anggaranPelatihan
 * @property-read int|null $anggaran_pelatihan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnggaranPendidikan> $anggaranPendidikan
 * @property-read int|null $anggaran_pendidikan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencanaPembelajaran
 * @property-read int|null $rencana_pembelajaran_count
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $data_pegawai_id
 * @property int $data_pendidikan_id
 * @property int $data_pelatihan_id
 * @property int $bentuk_jalur_id
 * @property int $jenis_pendidikan_id
 * @property int $region_id
 * @property int $jenjang_id
 * @property string $klasifikasi
 * @property string $tahun
 * @property int $jam_pelajaran
 * @property int $anggaran_rencana
 * @property string $prioritas
 * @property string $status_pengajuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BentukJalur|null $bentukJalur
 * @property-read \App\Models\DataPegawai|null $dataPegawai
 * @property-read \App\Models\DataPelatihan|null $dataPelatihan
 * @property-read \App\Models\DataPendidikan|null $dataPendidikan
 * @property-read \App\Models\JenisPendidikan|null $jenisPendidikan
 * @property-read \App\Models\Jenjang|null $jenjang
 * @property-read \App\Models\kelompokCanValidating|null $kelompokCanValidating
 * @property-read \App\Models\Region|null $region
 * @method static \Database\Factories\RencanaPembelajaranFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereAnggaranRencana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereBentukJalurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereDataPegawaiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereDataPelatihanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereDataPendidikanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereJamPelajaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereJenisPendidikanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereJenjangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereKlasifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran wherePrioritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereStatusPengajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereUpdatedAt($value)
 */
	class RencanaPembelajaran extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $rumpun
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataPelatihan> $dataPelatihan
 * @property-read int|null $data_pelatihan_count
 * @method static \Illuminate\Database\Eloquent\Builder|Rumpun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rumpun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rumpun query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rumpun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumpun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumpun whereRumpun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rumpun whereUpdatedAt($value)
 */
	class Rumpun extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TenggatWaktu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenggatWaktu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenggatWaktu query()
 */
	class TenggatWaktu extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $unit_kerja
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataPegawai> $dataPegawai
 * @property-read int|null $data_pegawai_count
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKerja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKerja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKerja query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKerja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKerja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKerja whereUnitKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKerja whereUpdatedAt($value)
 */
	class UnitKerja extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DataPegawai|null $dataPegawai
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $kelompok_id
 * @property int $rencana_pembelajaran_id
 * @property string $status
 * @property string $status_revisi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CatatanValidasiKelompok> $catatanValidasiKelompok
 * @property-read int|null $catatan_validasi_kelompok_count
 * @property-read \App\Models\Kelompok|null $kelompok
 * @property-read \App\Models\RencanaPembelajaran|null $rencanaPembelajaran
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating query()
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating whereKelompokId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating whereRencanaPembelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating whereStatusRevisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kelompokCanValidating whereUpdatedAt($value)
 */
	class kelompokCanValidating extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $data_pegawai_id
 * @property int $rencana_pembelajaran_id
 * @property string $status
 * @property string $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving query()
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving whereDataPegawaiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving whereRencanaPembelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanApproving whereUpdatedAt($value)
 */
	class pegawaiCanApproving extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $data_pegawai_id
 * @property int $rencana_pembelajaran_id
 * @property string $status
 * @property string $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying query()
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying whereDataPegawaiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying whereRencanaPembelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pegawaiCanVerifying whereUpdatedAt($value)
 */
	class pegawaiCanVerifying extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi query()
 */
	class pendidikanHasEstimasi extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $data_pendidikan_id
 * @property int $jenjang_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasJenjang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasJenjang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasJenjang query()
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasJenjang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasJenjang whereDataPendidikanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasJenjang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasJenjang whereJenjangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasJenjang whereUpdatedAt($value)
 */
	class pendidikanHasJenjang extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|userHasRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userHasRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userHasRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|userHasRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userHasRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userHasRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userHasRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userHasRole whereUserId($value)
 */
	class userHasRole extends \Eloquent {}
}

