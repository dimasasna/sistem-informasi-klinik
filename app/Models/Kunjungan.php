<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'kode_kunjungan',
        'pasien_id',
        'user_id',
        'jenis_kunjungan',
        'tanggal_kunjungan',
        'keluhan',
    ];
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function visitObat()
    {
        return $this->hasMany(VisitObat::class, 'kunjungan_id');
    }
    public function visitTindakan()
    {
        return $this->hasMany(VisitTindakan::class, 'kunjungan_id');
    }
}
