<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitObat extends Model
{
    use HasFactory;
    protected $fillable = [
        'kunjungan_id',
        'obat_id',
        'qty',
        'total_harga',
    ];
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id');
    }
}
