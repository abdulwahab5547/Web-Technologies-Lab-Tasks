<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@shop.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Categories & Products
        $categories = [
            [
                'name'        => 'Electronics',
                'description' => 'Gadgets, devices, and cutting-edge tech for every lifestyle.',
                'products'    => [
                    ['name' => 'Wireless Noise-Cancelling Headphones', 'price' => 149.99, 'stock' => 42, 'desc' => 'Premium over-ear headphones with 30-hour battery life, active noise cancellation, and studio-quality sound. Perfect for work, travel, or everyday listening.'],
                    ['name' => 'Mechanical Keyboard – Compact TKL', 'price' => 89.99, 'stock' => 28, 'desc' => 'Tenkeyless mechanical keyboard with tactile switches, PBT keycaps, and RGB backlighting. Built for typists and gamers alike.'],
                    ['name' => '4K USB-C Monitor 27"', 'price' => 399.00, 'stock' => 15, 'desc' => 'Ultra-sharp 4K display with wide color gamut, 60Hz refresh rate, and USB-C single-cable connectivity. Ideal for creative professionals.'],
                    ['name' => 'Portable Bluetooth Speaker', 'price' => 59.99, 'stock' => 60, 'desc' => '360° sound in a compact, waterproof design. 12-hour battery, built-in microphone, and a deep bass radiator for rich audio anywhere.'],
                    ['name' => 'Smart Home Hub', 'price' => 79.99, 'stock' => 3, 'desc' => 'Control all your smart devices from one place. Compatible with Alexa, Google Home, and 5,000+ connected devices.'],
                ],
            ],
            [
                'name'        => 'Clothing',
                'description' => 'Timeless essentials and on-trend pieces for every occasion.',
                'products'    => [
                    ['name' => 'Classic Fit Oxford Shirt', 'price' => 49.99, 'stock' => 80, 'desc' => 'Crafted from 100% cotton with a wrinkle-resistant finish. Available in multiple colors — perfect for the office or a casual weekend.'],
                    ['name' => 'Slim-Cut Chino Trousers', 'price' => 64.99, 'stock' => 55, 'desc' => 'Versatile slim-cut chinos in a durable stretch-cotton blend. Clean lines that pair effortlessly with any top.'],
                    ['name' => 'Merino Wool Crew Sweater', 'price' => 89.00, 'stock' => 35, 'desc' => 'Luxuriously soft extra-fine merino wool. Naturally temperature-regulating and machine-washable.'],
                    ['name' => 'Lightweight Packable Jacket', 'price' => 119.00, 'stock' => 22, 'desc' => 'Windproof and water-resistant jacket that packs into its own pocket. Weighs just 280g — your ideal travel companion.'],
                    ['name' => 'Premium White Tee 3-Pack', 'price' => 34.99, 'stock' => 100, 'desc' => 'Heavyweight 200gsm cotton tees with a clean, structured silhouette. Three per pack — the building block of every wardrobe.'],
                ],
            ],
            [
                'name'        => 'Books',
                'description' => 'Bestsellers, classics, and hidden gems across every genre.',
                'products'    => [
                    ['name' => 'Atomic Habits – James Clear', 'price' => 16.99, 'stock' => 120, 'desc' => 'Tiny changes, remarkable results. The definitive guide to building good habits and breaking bad ones. Over 10 million copies sold worldwide.'],
                    ['name' => 'The Design of Everyday Things', 'price' => 19.99, 'stock' => 65, 'desc' => 'Don Norman\'s seminal work on human-centered design. Essential reading for designers, engineers, and anyone who has ever been baffled by a door handle.'],
                    ['name' => 'Sapiens: A Brief History of Humankind', 'price' => 17.99, 'stock' => 90, 'desc' => 'Yuval Noah Harari takes readers on a sweeping journey through 70,000 years of human history. Provocative, entertaining, and deeply illuminating.'],
                    ['name' => 'Deep Work – Cal Newport', 'price' => 15.99, 'stock' => 75, 'desc' => 'Rules for focused success in a distracted world. Learn how to cultivate deep focus and produce your most important work.'],
                    ['name' => 'The Pragmatic Programmer', 'price' => 49.99, 'stock' => 40, 'desc' => 'A timeless classic for software developers. Filled with practical advice on craftsmanship, career development, and how to write better code.'],
                ],
            ],
            [
                'name'        => 'Home & Garden',
                'description' => 'Everything you need to make your space beautiful and functional.',
                'products'    => [
                    ['name' => 'Ceramic Pour-Over Coffee Set', 'price' => 44.99, 'stock' => 38, 'desc' => 'Hand-crafted ceramic dripper and carafe set for the perfect pour-over ritual. Includes stainless steel filter — no paper waste.'],
                    ['name' => 'Solid Walnut Cutting Board', 'price' => 55.00, 'stock' => 25, 'desc' => 'End-grain walnut cutting board that\'s gentle on knife edges and naturally antimicrobial. A kitchen staple that lasts a lifetime.'],
                    ['name' => 'Linen Throw Blanket – 130×180cm', 'price' => 69.99, 'stock' => 50, 'desc' => 'Pre-washed pure linen for a luxuriously soft feel right out of the box. Machine-washable and gets better with every wash.'],
                    ['name' => 'Cast Iron Dutch Oven 5.5qt', 'price' => 134.99, 'stock' => 0, 'desc' => 'Enameled cast iron that distributes heat evenly for perfect braises, stews, and sourdough loaves. Oven-safe to 500°F.'],
                    ['name' => 'Succulent & Cacti Starter Kit', 'price' => 29.99, 'stock' => 4, 'desc' => 'Six hand-picked succulents in artisan terracotta pots with saucers, plus a bag of specialist cactus compost. The ideal low-maintenance plant gift.'],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $catSlug  = Str::slug($catData['name']);
            $category = Category::create([
                'name'        => $catData['name'],
                'description' => $catData['description'],
                'image_path'  => "https://picsum.photos/seed/cat-{$catSlug}/600/600",
            ]);

            foreach ($catData['products'] as $i => $p) {
                $slug = Str::slug($p['name']);
                Product::create([
                    'category_id'    => $category->id,
                    'name'           => $p['name'],
                    'description'    => $p['desc'],
                    'price'          => $p['price'],
                    'stock_quantity' => $p['stock'],
                    'image_path'     => "https://picsum.photos/seed/{$slug}/800/800",
                    'is_active'      => true,
                ]);
            }
        }
    }
}
