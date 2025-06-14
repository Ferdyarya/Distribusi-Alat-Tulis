<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kekurangan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_masterbarang','qty','tanggal','qtyditerima'
    ];

    public function masterbarang()
    {
        return $this->hasOne(Masterbarang::class, 'id', 'id_masterbarang');
    }
}
