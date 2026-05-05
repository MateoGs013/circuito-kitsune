<?php

namespace App\Http\Controllers;

use App\Services\FeaturedContentService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly FeaturedContentService $featured)
    {
    }

    public function index(): View
    {
        return view('home', [
            'circuitProducts' => $this->featured->getCircuitProducts(),
            'featuredProducts' => $this->featured->getFeaturedProducts(),
            'featuredPosts' => $this->featured->getFeaturedPosts(),
        ]);
    }
}
