<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Admin - Full management
    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $products = Product::latest()->paginate(12);
        return view('products.admin-index', compact('products'));
    }

    // Kasir - View products for transaction
    public function kasirIndex()
    {
        if (auth()->user()->role !== 'kasir') {
            abort(403, 'Unauthorized action.');
        }
        
        $products = Product::where('is_active', true)
                          ->where('stock', '>', 0)
                          ->latest()
                          ->paginate(12);
        return view('products.kasir-index', compact('products'));
    }

    // Pembeli - Browse products
    public function pembeliIndex()
    {
        if (auth()->user()->role !== 'pembeli') {
            abort(403, 'Unauthorized action.');
        }
        
        $products = Product::where('is_active', true)
                          ->where('stock', '>', 0)
                          ->latest()
                          ->paginate(12);
        return view('products.pembeli-index', compact('products'));
    }

    // API Methods for AJAX
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-z0-9.\-]/i', '_', $file->getClientOriginalName());
            $path = $file->storeAs('products', $filename, 'public');
            $validated['image'] = asset('storage/' . $path);
        }

        $validated['sku'] = 'PRD-' . strtoupper(\Illuminate\Support\Str::random(8));
        $validated['is_active'] = true;

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-z0-9.\-]/i', '_', $file->getClientOriginalName());
            $path = $file->storeAs('products', $filename, 'public');
            $validated['image'] = asset('storage/' . $path);
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diupdate',
            'data' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}
