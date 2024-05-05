<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produks';

    protected $fillable = [
        'nama_produk', 'harga_beli', 'harga_jual','status','image','kategori_id','stok',
    ];

    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori', 'kategori_id', 'id');
    }

    
}
