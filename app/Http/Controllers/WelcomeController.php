<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class WelcomeController extends Controller
{
    public function __invoke(ProductRepository $repository)
    {
        $products = $repository->publishedProducts()->shuffle()->take(24);
        return view('welcome', compact('products'));
    }
}
