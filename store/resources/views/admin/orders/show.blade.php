@extends('layouts.admin.argon')

@section('title' , 'Orders Details | '.$order->order_number)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="mb-0">@yield('title')</h3><br>
                                </div>
                                <div class="col-md-6 text-right float-right">
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Update Order Status
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('order.received', $order->id) }}">Order Received</a>
                                            <a class="dropdown-item" href="{{ route('order.progress', $order->id) }}">Order In Process</a>
                                            <a class="dropdown-item" href="{{ route('delivery.progress', $order->id) }}">Delivery in progress</a>
                                            <a class="dropdown-item" href="{{ route('delivered', $order->id) }}">Package Delivered</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-unstyled" style="line-height:30px;">
                                <li>
                                    <span><b>Order From :</b></span>
                                    <span>{{$order->user->name }}</span>
                                </li>
                                <li>
                                    <span><b>Phone Number :</b></span>
                                    <span>{{$order->phone_number }}</span>
                                </li>
                                <li>
                                    <span><b>Items Ordered :</b></span>
                                    <span>{{$order->orderItems->count() }}</span>
                                </li>
                                <li>
                                    <span><b>Grand Total :</b></span>
                                    <span>GHS {{ number_format($order->grand_total,2) }}</span>
                                </li>
                                <li>
                                    <span><b>Order Status :</b></span>
                                    @switch($order->status)
                                        @case(\App\Order::ORDER_RECEIVED)
                                            <span class="text-info">Order Received</span>
                                            @break
                                        @case(\App\Order::ORDER_IN_PROCESS)
                                            <span class="">Order In Process</span>
                                            @break
                                        @case(\App\Order::DELIVERY_IN_PROGRESS)
                                            <span class="text-primary">Delivery In progress</span>
                                            @break
                                        @case(\App\Order::PACKAGE_DELIVERED)
                                            <span class="text-success">Package Delivered</span>
                                            @break
                                        @default
                                        <span class="text-danger">Pending</span>
                                    @endswitch
                                </li>
                                <li>
                                    <span><b>Date :</b></span>
                                    <span>{{$order->date }}</span>
                                </li>
                                <li>
                                    <span><b>Delivery Location :</b></span>
                                    <span>{{$order->location }}</span>
                                </li>
                                <li>
                                    <span><b>Postal Address :</b></span>
                                    <span>{{$order->postal_address }}</span>
                                </li>
                                <li>
                                    <span><b>Order Notes :</b></span>
                                    <span>{{$order->notes }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    @include('flash::message')
                </div>

                @if ($order->orderItems->isNotEmpty())
                    <div class="table-responsive py-4 ">
                        <h3 class="ml-4">Order Items</h3>
                        <table class="table align-items-center">
                            <thead >
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                             <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration}}</td>
                                        <td>
                                            @if ($item->product_id == 0)
                                                <img src="{{ asset('images/pinapple.jpg') }}" height="60px">
                                            @else
                                                <img src="{{ asset('product/'.$item->product->photo) }}" height="60px" alt="">
                                            @endif
                                        </td>
                                        <td><b>
                                            @if ($item->product_id == 0)
                                                Mystery Market
                                            @else
                                                {{ $item->product->title }}</th>
                                            @endif
                                        </b></td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td>GHS {{ number_format($item->price,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center m-5">
                        <img src="{{ asset('argon/img/images.png')}}" alt="" width="50%" >
                        <h2 class="text-center mt-5 text-muted">All orders will appear here</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
