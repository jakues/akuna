<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function headings() : array
    {
        return [
            'id',
            'category_product',
            'name_product',
            'netto_product',
            'unit',
            'harga_product',
            'tanggal_input',
            'updated_at',
            'created_at'
        ];
    }

    public function filename() : string
    {
        $currentDate = Carbon::now()->format('Ymd-His');
        return "product_$currentDate.xlsx";
    }
}
