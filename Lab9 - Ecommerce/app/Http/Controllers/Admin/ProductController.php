<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(fn ($q) => $q->where('name', 'like', $term)
                                       ->orWhere('description', 'like', $term));
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('stock')) {
            match ($request->stock) {
                'low'      => $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 5),
                'out'      => $query->where('stock_quantity', 0),
                'inactive' => $query->where('is_active', false),
                default    => null,
            };
        }

        $products   = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'category_id'    => ['required', 'exists:categories,id'],
            'description'    => ['nullable', 'string'],
            'price'          => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active'      => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('products', 'public');
        }

        // Ensure a unique slug even if the name already exists
        $slug = Str::slug($validated['name']);
        $validated['slug']      = $this->uniqueSlug($slug);
        $validated['is_active'] = $request->boolean('is_active', true);
        unset($validated['image']);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$validated['name']}\" created.");
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'category_id'    => ['required', 'exists:categories,id'],
            'description'    => ['nullable', 'string'],
            'price'          => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active'      => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            // Delete old image before storing the new one
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')
                ->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        unset($validated['image']);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$product->name}\" updated.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Prevent deletion if product is part of existing orders
        if ($product->orderItems()->exists()) {
            return back()->with('error',
                "Cannot delete \"{$product->name}\" — it has existing order history. Deactivate it instead.");
        }

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $name = $product->name;
        $product->delete();

        return back()->with('success', "Product \"{$name}\" deleted.");
    }

    private function uniqueSlug(string $base): string
    {
        $slug  = $base;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }
}
