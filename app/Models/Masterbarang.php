<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterbarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama','qty','harga','kategori'
    ];
}
