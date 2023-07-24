<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('products.index');
        // $data = Product::orderBy('id_product', 'asc');
        // return DataTables::of($data)->make(true);
    }

    public function apiProducts(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $products = Product::all();
        return DataTables::of($products)
            ->addColumn('actions', function ($product) {
                return view('etc.button')->with('data', $product);
            })
            ->toJson();
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
            'category_product' => 'string|max:100',
            'name_product' => 'required|string|max:255',
            'netto_product' => 'numeric|max:10000',
            'unit' => 'string|max:5',
            'harga_product' => 'required|numeric|max:999999999',
        ]);

        $products = Product::create([
            'category_product' => $validatedData['category_product'],
            'name_product' => $validatedData['name_product'],
            'netto_product' => $validatedData['netto_product'],
            'unit' => $validatedData['unit'],
            'harga_product' => $validatedData['harga_product'],
        ]);

        return response()->json($products, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::where('id_product', $id)->first();
        return response()->json($products);
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
        // Find the product by ID
        $product = Product::where('id_product', $id)->first();

        // If the product is not found, return a 404 response
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Validate the incoming data from the client
        $validatedData = $request->validate([
            'category_product' => 'string|max:100',
            'name_product' => 'required|string|max:255',
            'netto_product' => 'numeric|max:10000',
            'unit' => 'string|max:5',
            'harga_product' => 'required|numeric|max:999999999',
        ]);

        // Update the product using the validated data
        $product->update([
            'category_product' => $validatedData['category_product'],
            'name_product' => $validatedData['name_product'],
            'netto_product' => $validatedData['netto_product'],
            'unit' => $validatedData['unit'],
            'harga_product' => $validatedData['harga_product'],
        ]);

        //Product::where('id_product', $id)->update($request, $product);
        // Return the updated product as a JSON response
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the product by ID
        $product = Product::where('id_product', $id)->first();

        // If the product is not found, return a 404 response
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Delete the product
        $product->delete();

        // Return a success response
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
