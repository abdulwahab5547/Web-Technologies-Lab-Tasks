<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:500'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:1024'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('categories', 'public');
        }

        $slug = Str::slug($validated['name']);
        $validated['slug'] = $this->uniqueSlug($slug);
        unset($validated['image']);

        Category::create($validated);

        return back()->with('success', "Category \"{$validated['name']}\" created.");
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', "unique:categories,name,{$category->id}"],
            'description' => ['nullable', 'string', 'max:500'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:1024'],
        ]);

        if ($request->hasFile('image')) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            $validated['image_path'] = $request->file('image')
                ->store('categories', 'public');
        }

        unset($validated['image']);
        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', "Category \"{$category->name}\" updated.");
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('error',
                "Cannot delete \"{$category->name}\" — it has products assigned to it. Reassign or delete them first.");
        }

        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }

        $name = $category->name;
        $category->delete();

        return back()->with('success', "Category \"{$name}\" deleted.");
    }

    private function uniqueSlug(string $base): string
    {
        $slug  = $base;
        $count = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }
}
