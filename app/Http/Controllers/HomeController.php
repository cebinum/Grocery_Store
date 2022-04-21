<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Notifications\NewOrder;
use App\Models\PurchaseReminder;
use App\Notifications\OrderUpdate;
use App\Repositories\ProductRepository;

class HomeController extends Controller
{

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

    public function storeOrder(Request $request)
    {
        $order = new Order();
        $order->order_number        =   'ORD-' . strtoupper(uniqid());
        $order->user_id             =   auth()->user()->id;
        $order->grand_total         =   \Cart::getSubTotal() + 1;
        $order->delivery_charges    =   0;
        $order->notes               =   $request->notes;
        $order->mode_of_delivery =   $request->mode_of_delivery;
        $order->saveOrFail();

        $user =  User::find(auth()->id());
        $user->state =  $request->state;
        $user->city = $request->city;
        $user->zip_code = $request->zip_code;
        $user->phone_number = $request->phonenumber;
        $user->address = $request->address;
        $user->saveOrFail();

        $items = \Cart::getContent();

        foreach ($items as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id        = $order->id;
            $orderItem->product_id      =  $item->id;
            $orderItem->quantity        =  $item->quantity;
            $orderItem->price           =  \Cart::get($item->id)->getPriceSum();
            $orderItem->saveOrFail();

            \Cart::remove($item->id);
        }

        // $user->notify(new NewOrder($order));

        toastr()->success('Your order, ' . $order->order_number . ' has been created successfully');

        return redirect()->route('order', $order->order_number);
    }

    public function category(ProductRepository $repository, Category $category)
    {
        $products = $repository->publishedProducts()->where('category_id', $category->id);
        return view('welcome', compact('products'));
    }

    public function profile()
    {
        return view('profile');
    }

    public function  storeProfile(Request $request)
    {
        $user =  User::find(auth()->id());
        $user->name =  $request->name;
        $user->state =  $request->state;
        $user->city = $request->city;
        $user->zip_code = $request->zip_code;
        $user->phone_number = $request->phonenumber;
        $user->address = $request->address;
        $user->saveOrFail();

        toastr()->success(' Profile updated successfully');

        return redirect()->back();
    }

    public function reminders()
    {
        return view('reminders');
    }

    public function storeReminders(Request $request){
        $purchaseReminder =  new PurchaseReminder();
        $purchaseReminder->reminder_date =  $request->reminder_date;
        $purchaseReminder->reminder_time =  $request->reminder_time;
        $purchaseReminder->product_id =  $request->product_id;
        $purchaseReminder->user_id =  auth()->id();
        $purchaseReminder->saveOrFail();

        toastr()->success('Reminder set successfully');

        return redirect()->back();
    }
}
