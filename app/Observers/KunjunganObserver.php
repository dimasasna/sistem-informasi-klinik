<?php

namespace App\Observers;

use App\Models\Kunjungan;

class KunjunganObserver
{
    /**
     * Handle the Kunjungan "created" event.
     */
    public function creating(Kunjungan $kunjungan)
    {
        // Cek apakah kode_kunjungan sudah ada, jika belum generate
        if (empty($kunjungan->kode_kunjungan)) {
            $lastKunjungan = Kunjungan::orderBy('id', 'desc')->first();
            $nextNumber = $lastKunjungan ? (int) substr($lastKunjungan->kode_kunjungan, 2) + 1 : 1;
            $kodeKunjungan = 'KJ' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $kunjungan->kode_kunjungan = $kodeKunjungan;
        }
    }

    /**
     * Handle the Kunjungan "updated" event.
     */
    public function updated(Kunjungan $kunjungan): void
    {
        //
    }

    /**
     * Handle the Kunjungan "deleted" event.
     */
    public function deleted(Kunjungan $kunjungan): void
    {
        //
    }

    /**
     * Handle the Kunjungan "restored" event.
     */
    public function restored(Kunjungan $kunjungan): void
    {
        //
    }

    /**
     * Handle the Kunjungan "force deleted" event.
     */
    public function forceDeleted(Kunjungan $kunjungan): void
    {
        //
    }
}
