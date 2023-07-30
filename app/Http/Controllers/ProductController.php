<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the user's search term from the 'q' query parameter
        $searchTerm = $request->query('q');

        // Perform the server-side filtering based on the search term
        $products = Product::where('name_product', 'like', '%' . $searchTerm . '%')
            ->orWhere('category_product', 'like', '%' . $searchTerm . '%')
            ->orWhere('unit', 'like', '%' . $searchTerm . '%')
            ->get();

        // Return the filtered products as JSON response
        return response()->json($products);
    }

    public function api(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $products = Product::all();
        return DataTables::of($products)
            ->addColumn('actions', function ($product) {
                return view('etc.product.button')->with('data', $product);
            })
            ->toJson();
    }

    public function export()
    {
        $fileName = 'product_' . date("Ymd-His") . '.csv';
        $products = Product::all();

        // Set the appropriate headers for the CSV file
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        );

        $tableHeaders = [
            'id_product',
            'category_product',
            'name_product',
            'netto_product',
            'unit',
            'harga_product',
            'tanggal_input',
            'updated_at',
            'created_at',
        ];

        // Create a StreamedResponse to efficiently handle large data sets
        return new StreamedResponse(function () use ($tableHeaders, $products) {
            $file = fopen('php://output', 'w');

            // Write the header row to the CSV file
            fputcsv($file, $tableHeaders);

            // Write each row of data to the CSV file
            foreach ($products as $product) {
                fputcsv($file, $product->getAttributes());
            }

            fclose($file);
        }, 200, $headers);
    }

    public function count()
    {
        $totalProducts = DB::table('product')->count();
        return response()->json(['total_products' => $totalProducts]);
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
