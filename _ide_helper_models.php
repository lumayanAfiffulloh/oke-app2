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
 * @property string $nama
 * @property string $status
 * @property int $nip
 * @property string $jabatan
 * @property string $unit_kerja
 * @property string $pendidikan
 * @property string $jenis_kelamin
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PelaksanaanPembelajaran> $pelaksanaan_pembelajaran
 * @property-read int|null $pelaksanaan_pembelajaran_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RencanaPembelajaran> $rencana_pembelajaran
 * @property-read int|null $rencana_pembelajaran_count
 * @method static \Database\Factories\DataPegawaiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai query()
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai wherePendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereUnitKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DataPegawai whereUpdatedAt($value)
 */
	class DataPegawai extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $pegawai_id
 * @property int $rencana_pembelajaran_id
 * @property string $tanggal_pelaksanaan
 * @property string $status_pembelajaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DataPegawai|null $dataPegawai
 * @property-read \App\Models\RencanaPembelajaran|null $rencana_pembelajaran
 * @method static \Database\Factories\PelaksanaanPembelajaranFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran wherePegawaiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran whereRencanaPembelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran whereStatusPembelajaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran whereTanggalPelaksanaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PelaksanaanPembelajaran whereUpdatedAt($value)
 */
	class PelaksanaanPembelajaran extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $tahun
 * @property string $klasifikasi
 * @property string $kategori_klasifikasi
 * @property string $kategori
 * @property string $bentuk_jalur
 * @property string $nama_pelatihan
 * @property int $jam_pelajaran
 * @property string $regional
 * @property int $anggaran
 * @property string $prioritas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DataPegawai|null $dataPegawai
 * @method static \Database\Factories\RencanaPembelajaranFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereBentukJalur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereJamPelajaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RencanaPembelajaran whereKategoriKlasifikasi($value)
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
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

