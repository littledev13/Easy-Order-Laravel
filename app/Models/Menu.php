<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_url',
        'nama',
        'kategori',
        'deskripsi',
        'harga',
        'id_toko',
    ];
}