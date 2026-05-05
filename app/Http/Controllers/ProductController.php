<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('filter');

        return view('products.index', [
            'products' => Product::query()
                ->byFilter($filter)
                ->orderByDesc('is_featured')
                ->orderBy('name')
                ->get(),
            'totalCount' => Product::count(),
            'activeFilter' => $filter,
        ]);
    }

    public function show(Product $product): View
    {
        return view('products.show', [
            'product' => $product,
        ]);
    }
}
