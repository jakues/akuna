<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Imports\TransactionImport;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function api(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $data = Transaction::all();
        return DataTables::of($data)
            ->addColumn('actions', function ($data) {
                return view('etc.transaction.button')->with('data', $data);
            })
            ->toJson();
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CsvFile' => 'required|mimes:xlsx',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.transaction')->with('error', 'Please upload a valid Excel file.');
        }

        $file = $request->file('CsvFile');

        if ($file) {
            try {
                Excel::import(new TransactionImport, $file);

                return response()->json(['message' => 'Excel file imported successfully'], 201);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error importing Excel file'], 500);
            }
        }

        return response()->json(['error' => 'No file provided.'], 500);
    }

    public function export()
    {
        return Excel::download(new TransactionExport, (new TransactionExport)->fileName());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal_pembelian' => 'required|string|max:15',
            'customer' => 'required|string|max:50',
            'kode' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|string|max:15',
            'nama_barang' => 'required|string',
            'qty_pembelian' => 'required|numeric|max:10000',
            'harga' => 'required|numeric|max:9999999',
            'total_harga' => 'required|numeric|max:999999999',
        ]);

        $tx = Transaction::create([
            'tanggal_pembelian' => $validatedData['tanggal_pembelian'],
            'customer' => $validatedData['customer'],
            'kode' => $validatedData['kode'],
            'alamat' => $validatedData['alamat'],
            'telp' => $validatedData['telp'],
            'nama_barang' => $validatedData['nama_barang'],
            'qty_pembelian' => $validatedData['qty_pembelian'],
            'harga' => $validatedData['harga'],
            'total_harga' => $validatedData['total_harga'],
        ]);

        return response()->json($tx, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Transaction::where('id', $id)->first();
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find by id
        $data = Transaction::where('id', $id)->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Validate incoming data
        $validatedData = $request->validate([
            'tanggal_pembelian' => 'required|string|max:15',
            'customer' => 'required|string|max:50',
            'kode' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|string|max:15',
            'nama_barang' => 'required|string|max:255',
            'qty_pembelian' => 'required|numeric|max:10000',
            'harga' => 'required|numeric|max:9999999',
            'total_harga' => 'required|numeric|max:999999999',
        ]);

        // Update using validated data
        $data->update([
            'tanggal_pembelian' => $validatedData['tanggal_pembelian'],
            'customer' => $validatedData['customer'],
            'kode' => $validatedData['kode'],
            'alamat' => $validatedData['alamat'],
            'telp' => $validatedData['telp'],
            'nama_barang' => $validatedData['nama_barang'],
            'qty_pembelian' => $validatedData['qty_pembelian'],
            'harga' => $validatedData['harga'],
            'total_harga' => $validatedData['total_harga'],
        ]);

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find by id
        $data = Transaction::where('id', $id)->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found', 404]);
        }

        // Delete it
        $data->delete();

        // Return a success response
        return response()->json(['message' => 'Data deleted successfully', 200]);
    }
}
