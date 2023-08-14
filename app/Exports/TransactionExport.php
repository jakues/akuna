<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Transaction::all();
    }

    public function headings() : array
    {
        return [
            'id',
            'tanggal_pembelian',
            'customer',
            'kode',
            'alamat',
            'telp',
            'nama_barang',
            'qty_pembelian',
            'harga',
            'total_harga',
            'updated_at',
            'created_at'
        ];
    }

    public function filename() : string
    {
        $currentDate = Carbon::now()->format('Ymd-His');
        return "tx_$currentDate.xlsx";
    }
}
