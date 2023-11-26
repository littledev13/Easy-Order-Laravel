<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Toko extends Model
{
    use HasFactory;
    // public function akuns(): HasMany
    // {
    //     return $this->hasMany(Akun::class, 'id_toko', 'nama');
    // }
    // public function menus(): HasMany
    // {
    //     return $this->hasMany(Menu::class, 'id_toko', 'nama');
    // }
    // public function notas(): HasMany
    // {
    //     return $this->hasMany(Nota::class, 'id_toko', 'nama');
    // }
    // public function pesanans(): HasMany
    // {
    //     return $this->hasMany(Pesanan::class, 'id_toko', 'nama');
    // }
}