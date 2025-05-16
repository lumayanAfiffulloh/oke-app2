<?php

namespace App\Services;

use App\Models\DataPegawai;
use App\Models\TenggatRencana;
use App\Models\RencanaPembelajaran;
use App\Models\KelompokCanValidating;
use App\Notifications\RencanaPembelajaranNotification;
use Carbon\Carbon;

class NotificationService
{
    public function checkDeadlines()
    {
        // Notifikasi untuk pegawai tentang tenggat rencana
        $tenggats = TenggatRencana::whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_selesai', '>=', now())
            ->get();

        foreach ($tenggats as $tenggat) {
            $this->notifyPegawaiAboutDeadline($tenggat);
            $this->notifyValidatorsAboutDeadline($tenggat);
        }
    }

	public function notifyPegawaiAboutDeadline($tenggat)
	{
		$kategori = $tenggat->kategoriTenggat->nama;
		$daysRemaining = Carbon::parse($tenggat->tanggal_selesai)->diffInDays(now());
	
		if ($daysRemaining > 3) {
			$message = "Tenggat $kategori akan berakhir dalam $daysRemaining hari";
			$type = 'deadline_reminder';
		} elseif ($daysRemaining > 0) {
			$message = "Segera! Tenggat $kategori akan berakhir dalam $daysRemaining hari";
			$type = 'deadline_reminder_urgent';
		} else {
			$message = "Tenggat $kategori telah berakhir!";
			$type = 'deadline_passed';
		}
	
		// Dapatkan pegawai yang perlu dinotifikasi
		$pegawai = DataPegawai::whereHas('rencanaPembelajaran', function($q) use ($tenggat) {
			// Sesuaikan dengan logika Anda
		})->get();
	
		foreach ($pegawai as $p) {
			$p->notify(new RencanaPembelajaranNotification(
				$type,
				$message,
				route('rencana-pembelajaran.index')
			));
		}
	}

    protected function notifyValidatorsAboutDeadline($tenggat)
    {
        // Logika serupa untuk validator/ketua kelompok
    }

    public function notifyStatusChange($rencanaPembelajaran)
    {
        $pegawai = $rencanaPembelajaran->pegawai;
        $status = $rencanaPembelajaran->status_pengajuan;

        $messages = [
            'draft' => 'Rencana pembelajaran Anda masih dalam draft',
            'submitted' => 'Rencana pembelajaran Anda telah diajukan',
            'approved' => 'Rencana pembelajaran Anda telah disetujui',
            'rejected' => 'Rencana pembelajaran Anda ditolak',
            'revision' => 'Rencana pembelajaran Anda memerlukan revisi',
        ];

        $pegawai->notify(new RencanaPembelajaranNotification(
            'status_update',
            $messages[$status] ?? 'Status rencana pembelajaran Anda berubah',
            route('rencana-pembelajaran.show', $rencanaPembelajaran->id)
        ));

        // Jika status memerlukan validasi, beri tahu validator
        if (in_array($status, ['submitted', 'revision'])) {
            $this->notifyValidators($rencanaPembelajaran);
        }
    }

    protected function notifyValidators($rencanaPembelajaran)
    {
        $validators = KelompokCanValidating::where('rencana_pembelajaran_id', $rencanaPembelajaran->id)
            ->with('kelompok.pegawai')
            ->get();

        foreach ($validators as $validator) {
            $validator->kelompok->pegawai->notify(new RencanaPembelajaranNotification(
                'validation_required',
                'Ada rencana pembelajaran yang perlu divalidasi',
                route('validasi-rencana.show', $rencanaPembelajaran->id)
            ));
        }
    }
}