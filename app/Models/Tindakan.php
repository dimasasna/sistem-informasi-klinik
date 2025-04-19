<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tindakan',
        'deskripsi',
        'tarif',
    ];

    public function visitTindakan()
    {
        return $this->hasMany(VisitTindakan::class, 'tindakan_id');
    }
}
