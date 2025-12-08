<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            // Simpan ke storage/app/public/images/categories
            $path = $request->file('image')->store('images/categories', 'public');
            // Simpan path yang bisa diakses dari public/storage
            $data['image'] = 'storage/' . $path;
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($category->image) {
                $oldPath = str_replace('storage/', '', $category->image);
                Storage::disk('public')->delete($oldPath);
            }
            // Upload gambar baru
            $path = $request->file('image')->store('images/categories', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        // Hapus gambar
        if ($category->image) {
            $oldPath = str_replace('storage/', '', $category->image);
            Storage::disk('public')->delete($oldPath);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
