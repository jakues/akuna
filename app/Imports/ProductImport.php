<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'category_product' => $row['category_product'],
            'name_product' => $row['name_product'],
            'netto_product' => $row['netto_product'],
            'unit' => $row['unit'],
            'harga_product' => $row['harga_product'],
            'tanggal_input' => $row['tanggal_input'],
        ]);
    }
}
