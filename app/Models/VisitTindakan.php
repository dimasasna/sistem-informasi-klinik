<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitTindakan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kunjungan_id',
        'tindakan_id',
        'total_harga',
    ];
    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class, 'tindakan_id');
    }
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'kunjungan_id');
    }
}
