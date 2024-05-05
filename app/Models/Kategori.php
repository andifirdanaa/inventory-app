<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategoris';

    protected $fillable = [
        'name', 'status',
    ];

    public function produk()
    {
        return $this->hasMany('App\Models\Produk', 'kategori_id', 'id');
    }
}
