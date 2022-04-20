<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class WelcomeController extends Controller
{
    public function __invoke(ProductRepository $repository, Request $request)
    {
        $query = trim($request->query('search'));

        if ($query) {
            $products = Product::where('name', 'like', '%' . $query . '%')
                ->paginate();
        } else {
            $products = Product::isPublished()->paginate(24);
        }
        // $products = $repository->publishedProducts()->shuffle()->take(24);
        return view('welcome', compact('products'));
    }
}
