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
}