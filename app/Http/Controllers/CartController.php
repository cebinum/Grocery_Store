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

        flash($request->name . ' has been added to your basket')->success();

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

        flash(' Item removed form basket')->success();

        return redirect()->back();
    }

    public function empty()
    {
        \Cart::clear();

        flash('Your basket has been cleared')->success();

        return redirect()->back();
    }
}
