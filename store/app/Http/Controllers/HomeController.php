<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\ProductRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('home', compact('orders'));
    }

    public function myCart()
    {
        return view('my-basket');
    }

    public function order($id)
    {
        $order = Order::where('order_number', $id)->where('user_id', auth()->id())->first();
        return view('order', compact('order'));
    }
}
