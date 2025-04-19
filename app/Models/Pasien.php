<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pasien',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
    ];
    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class);
    }
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }


}
