<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_obat',
        'satuan',
        'harga_satuan',
        'stok',
    ];
    public function visitObat()
    {
        return $this->hasMany(VisitObat::class);
    }
}
