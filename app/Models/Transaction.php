<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $table = "pembelian";
    protected $primaryKey = 'id';
    protected $fillable = [
        'tanggal_pembelian',
        'customer',
        'alamat',
        'telp',
        'nama_barang',
        'qty_pembelian',
        'harga',
        'total_harga'
    ];
}
