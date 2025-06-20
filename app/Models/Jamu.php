<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jamu extends Model
{
    use HasFactory;

    protected $fillable = [
        'KHASIAT', 'KANDUNGAN', 'ATURAN MINUM', 'EFEK SAMPING', 'JENIS', 'PRODUSEN'
    ];
}
