<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);


        $validated['slug'] = Str::slug($validated['name']);
        // Set default icon jika kosong
        if (empty($validated['icon'])) {
            $validated['icon'] = $this->getDefaultIcon($validated['name']);
        }

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);


        $validated['slug'] = Str::slug($validated['name']);
        // Set default icon jika kosong
        if (empty($validated['icon'])) {
            $validated['icon'] = $this->getDefaultIcon($validated['name']);
        }

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate',
            'data' => $category
        ]);
    }

    /**
     * Get default icon class for category name
     */
    private function getDefaultIcon($name)
    {
        $name = strtolower($name);
        if (strpos($name, 'sembako') !== false || strpos($name, 'market') !== false) {
            return 'fa-store';
        } elseif (strpos($name, 'buah') !== false || strpos($name, 'sayur') !== false || strpos($name, 'apple') !== false) {
            return 'fa-apple-alt';
        } elseif (strpos($name, 'minuman') !== false || strpos($name, 'drink') !== false) {
            return 'fa-glass-whiskey';
        } elseif (strpos($name, 'makanan') !== false || strpos($name, 'snack') !== false || strpos($name, 'cookie') !== false) {
            return 'fa-cookie-bite';
        }
        return 'fa-tag';
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has products
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih memiliki produk'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return response()->json($category);
    }
}
