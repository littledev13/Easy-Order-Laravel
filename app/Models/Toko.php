<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Toko extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'pemilik',
        'deskripsi',
        'alamat',
    ];
    public function notas()
    {
        return $this->hasMany(Nota::class, 'id_toko');
    }

    // public function pesanans()
    // {
    //     return $this->hasMany(Pesanan::class, 'id_toko');
    // }
    public function akuns()
    {
        return $this->hasMany(User::class, 'id');
    }
    public function menus()
    {
        return $this->hasMany(Menu::class, 'id_toko');
    }
    // public function notas(): HasMany
    // {
    //     return $this->hasMany(Nota::class, 'id_toko', 'nama');
    // }
    // public function pesanans(): HasMany
    // {
    //     return $this->hasMany(Pesanan::class, 'id_toko', 'nama');
    // }
}