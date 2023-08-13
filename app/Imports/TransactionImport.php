<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Transaction;

class TransactionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Transaction([
            'tanggal_pembelian' => $row['tanggal_pembelian'],
            'customer' => $row['customer'],
            'kode' => $row['kode'],
            'alamat' => $row['alamat'],
            'telp' => $row['telp'],
            'nama_barang' => $row['nama_barang'],
            'qty_pembelian' => $row['qty_pembelian'],
            'harga' => $row['harga'],
            'total_harga' => $row['total_harga'],
        ]);
    }
}
