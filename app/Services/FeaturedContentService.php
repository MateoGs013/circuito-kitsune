<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Collection;

class FeaturedContentService
{
    public function getFeaturedProducts(int $limit = 3): Collection
    {
        return Product::query()
            ->featured()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getFeaturedPosts(int $limit = 3): Collection
    {
        return Post::query()
            ->featured()
            ->published()
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function getAvailableProducts(): Collection
    {
        return Product::query()
            ->available()
            ->latest()
            ->get();
    }

    public function getCircuitProducts(): Collection
    {
        return Product::query()
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();
    }
}
