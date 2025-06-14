<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangjarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_masterbarang','qty','tanggal','status','usulan','catatan'
    ];

    public function masterbarang()
    {
        return $this->hasOne(Masterbarang::class, 'id', 'id_masterbarang');
    }
}
