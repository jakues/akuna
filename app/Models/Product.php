<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $table = "product";
    protected $primaryKey = 'id_product';
    protected $fillable = [
        'category_product',
        'name_product',
        'netto_product',
        'unit',
        'harga_product',
        'tanggal_input',
    ];
}
