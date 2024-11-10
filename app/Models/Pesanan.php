<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    use HasFactory;
    // public function notas(): HasOne
    // {
    //     return $this->hasOne(Pesanan::class, 'no_nota', 'no_nota');
    // }
    protected $fillable = [
        'id_toko',
        'no_nota',
        'harga',
        'quantity',
        'menu',
    ];
    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }

    // public function menu()
    // {
    //     return $this->belongsTo(Menu::class, 'nama');
    // }

    // public function toko()
    // {
    //     return $this->belongsTo(Toko::class, 'id_toko');
    // }
}