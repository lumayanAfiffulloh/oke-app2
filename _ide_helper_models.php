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
 * @property string $kategori
 * @property string $bentuk_jalur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\BentukJalurFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur query()
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereBentukJalur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BentukJalur whereUpdatedAt($value)
 */
	class BentukJalur extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string $nppu
 * @property string $status
 * @property string $jabatan
 * @property string $unit_kerja
 * @property string $pendidikan
 * @property string $jurusan_pendidikan
 * @property string $jenis_kelamin
 * @property string|null $nomor_telepon
 * @property string|null $foto
 * @property int $user_id
 * @property int $kelompok_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kelompok|null $kelompok
 * @property-read \App\Models\Kelompok|null $ketuaKelompok
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencanaPembelajaran
 * @property-read int|null $rencana_pembelajaran_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\DataPegawaiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai query()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereJurusanPendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereKelompokId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereNomorTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereNppu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai wherePendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereUnitKerja($value)
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
 * @property string $kode
 * @property string|null $rumpun
 * @property string $nama_pelatihan
 * @property string|null $deskripsi
 * @property int $jp
 * @property string|null $materi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EstimasiHarga> $estimasiHarga
 * @property-read int|null $estimasi_harga_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereRumpun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPelatihan whereUpdatedAt($value)
 */
	class DataPelatihan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $jenjang_id
 * @property int $jurusan_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EstimasiPendidikan> $estimasiPendidikans
 * @property-read int|null $estimasi_pendidikans_count
 * @property-read \App\Models\Jenjang|null $jenjang
 * @property-read \App\Models\Jurusan|null $jurusan
 * @method static \Database\Factories\DataPendidikanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan query()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereJenjangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereJurusanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPendidikan whereUpdatedAt($value)
 */
	class DataPendidikan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $pelatihan_id
 * @property string $region
 * @property string $kategori
 * @property int $anggaran_min
 * @property int $anggaran_maks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DataPelatihan|null $dataPelatihan
 * @method static \Database\Factories\EstimasiHargaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga query()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga whereAnggaranMaks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga whereAnggaranMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga wherePelatihanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiHarga whereUpdatedAt($value)
 */
	class EstimasiHarga extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $region
 * @property int $anggaran_min
 * @property int $anggaran_maks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataPendidikan> $dataPendidikans
 * @property-read int|null $data_pendidikans_count
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan query()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan whereAnggaranMaks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan whereAnggaranMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimasiPendidikan whereUpdatedAt($value)
 */
	class EstimasiPendidikan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $jenjang
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Jurusan> $jurusans
 * @property-read int|null $jurusans_count
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
 * @property string $jurusan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Jenjang> $jenjangs
 * @property-read int|null $jenjangs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Jurusan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jurusan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jurusan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Jurusan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jurusan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jurusan whereJurusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jurusan whereUpdatedAt($value)
 */
	class Jurusan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $ketua_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataPegawai> $anggota
 * @property-read int|null $anggota_count
 * @property-read \App\Models\DataPegawai|null $ketua
 * @method static \Database\Factories\KelompokFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok whereKetuaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelompok whereUpdatedAt($value)
 */
	class Kelompok extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $tahun
 * @property string $klasifikasi
 * @property string $kategori
 * @property string $bentuk_jalur
 * @property string $nama_pelatihan
 * @property int $jam_pelajaran
 * @property string $regional
 * @property int $anggaran
 * @property string $prioritas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $data_pegawai_id
 * @property-read \App\Models\DataPegawai|null $dataPegawai
 * @method static \Database\Factories\RencanaPembelajaranFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereBentukJalur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereDataPegawaiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereJamPelajaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereKlasifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereNamaPelatihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran wherePrioritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereRegional($value)
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
 * @property string $name
 * @property string $akses
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DataPegawai|null $dataPegawai
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAkses($value)
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
 * @property int $data_pendidikan_id
 * @property int $estimasi_pendidikan_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi whereDataPendidikanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi whereEstimasiPendidikanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|pendidikanHasEstimasi whereUpdatedAt($value)
 */
	class pendidikanHasEstimasi extends \Eloquent {}
}

