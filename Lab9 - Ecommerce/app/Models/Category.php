<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image_path'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            $path = $this->image_path;
            if (! $path) {
                return null;
            }
            return Str::startsWith($path, ['http://', 'https://'])
                ? $path
                : Storage::url($path);
        });
    }

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function (Category $category) {
            if ($category->isDirty('name') && ! $category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
