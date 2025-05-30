<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_wilayah',
        'kode_pos',
    ];

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }
}
