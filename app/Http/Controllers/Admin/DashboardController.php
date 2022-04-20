<?php

namespace App\Http\Controllers\Admin;

use App\Models\{User, OrderItem, Order};
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;

class DashboardController extends Controller
{
    public function __invoke(ProductRepository $repository)
    {
        $products = $repository->publishedProducts();
        $orders = Order::isPending()->latest()->get();
        $users = User::latest()->get();
        $orderItems = OrderItem::get()->take(20);
        return view('admin.dashboard.index', compact('products', 'orders', 'users', 'orderItems'));
    }
}
