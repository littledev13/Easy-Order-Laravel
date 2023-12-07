<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nota extends Model
{
    use HasFactory;
    // public function pesanans(): HasMany
    // {
    //     return $this->hasMany(Pesanan::class, 'no_nota', 'no_nota');
    // }
    protected $fillable = [
        'pembeli',
        'id_toko',
        'status',
        'pembayaran',
        'no_nota',
        'total_harga',
    ];
}