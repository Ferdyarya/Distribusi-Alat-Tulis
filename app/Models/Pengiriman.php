<?php

namespace App\Models;

use App\Models\Masterbarang;
use App\Models\Masterdinaspenerima;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_masterbarang','qty','id_masterdinaspenerima','tanggal','status'
    ];

    public function masterdinaspenerima()
    {
        return $this->hasOne(Masterdinaspenerima::class, 'id', 'id_masterdinaspenerima');
    }
    public function masterbarang()
    {
        return $this->hasOne(Masterbarang::class, 'id', 'id_masterbarang');
    }
}
