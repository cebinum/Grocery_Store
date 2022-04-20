<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Notifications\OrderUpdate;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function received(Order $order)
    {
        $order->status = Order::ORDER_RECEIVED;
        $order->save();

        flash('Order Status updated')->success();

         $order->user->notify(new OrderUpdate($order));

        return redirect()->back();
    }

    public function inProcess(Order $order)
    {
        $order->status = Order::ORDER_IN_PROCESS;
        $order->save();

        flash('Order Status updated')->success();

         $order->user->notify(new OrderUpdate($order));

        return redirect()->back();
    }

    public function deliveryInProgress(Order $order)
    {
        $order->status = Order::DELIVERY_IN_PROGRESS;
        $order->save();

        flash('Order Status updated')->success();

         $order->user->notify(new OrderUpdate($order));

        return redirect()->back();
    }

    public function delivered(Order $order)
    {
        $order->status = Order::PACKAGE_DELIVERED;
        $order->save();

        flash('Order Status updated')->success();

         $order->user->notify(new OrderUpdate($order));

        return redirect()->back();
    }
}
