<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;
    // public function menus(): HasMany
    // {
    //     return $this->hasMany(Menu::class, 'kategori', 'nama');
    // }
    protected $fillable = [
        'image_url',
        'nama',
        'id_toko',
    ];
    public function menu()
    {
        return $this->hasMany(Nota::class);
    }

}