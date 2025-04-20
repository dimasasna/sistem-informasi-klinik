<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'kunjungan_id',
        'total_tagihan',
        'metode_pembayaran',
        'status',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function updateTotalTagihan(): void
{
    $kunjungan = $this->kunjungan()->with(['visitTindakan', 'visitObat'])->first();

    $totalTindakan = $kunjungan->visitTindakan->sum('total_harga');
    $totalObat = $kunjungan->visitObat->sum('total_harga');

    $this->update([
        'total_tagihan' => $totalTindakan + $totalObat,
    ]);
}
}
