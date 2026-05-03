<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        // Category filter via slug
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        // Full-text search on name and description
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('description', 'like', $term);
            });
        }

        // Price range filters
        if ($request->filled('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Sorting
        match ($request->sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc'   => $query->orderBy('name'),
            'newest'     => $query->latest(),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::withCount(['products' => fn ($q) => $q->where('is_active', true)])->get();

        // Determine the active category model for the sidebar
        $activeCategory = $request->filled('category')
            ? $categories->firstWhere('slug', $request->category)
            : null;

        return view('shop.index', compact('products', 'categories', 'activeCategory'));
    }

    public function show(Product $product)
    {
        // The route uses {product:slug} binding; still gate on is_active
        abort_if(! $product->is_active, 404);

        $product->load('category');

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'related'));
    }
}
