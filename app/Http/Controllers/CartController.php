<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ));

        toastr()->success($request->name . ' has been added to cart');

        return redirect()->back();
    }

    public function myCart(ProductRepository $repository)
    {
        $products = $repository->publishedProducts()->shuffle()->take(4);
        return view('my-basket', compact('products'));
    }

    public function removeItem($id)
    {
        \Cart::remove($id);

        toastr()->info('Item removed from cart');

        return redirect()->back();
    }

    
}
