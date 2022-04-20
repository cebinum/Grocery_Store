@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        Hello, {{ auth()->user()->name }},  you are welcome to your dashboard.
                    </p>

                    <div class="recent-orders">
                        <div class="title-buttons"><strong>Recent Orders</strong></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr class="first last">
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th><span class="nobr">Total</span></th>
                                        <th class="text-center">No of Items</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="first odd">
                                            <td><b>{{ $order->order_number }}</b></td>
                                            <td>{{ $order->date }} </td>
                                            <td><span class="price">$ {{ number_format($order->grand_total,2) }}</span></td>
                                            <td class="text-center">{{ $order->orderItems->count() }}</span></td>
                                            <td>
                                                @switch($order->payment_status)
                                                    @case(1)
                                                        <span class="badge badge-success">Paid</span>
                                                        @break
                                                    @default
                                                    <span class="badge badge-danger">Not Paid</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($order->status)
                                                    @case(\App\Models\Order::ORDER_RECEIVED)
                                                        <span class="text-info">Order Received</span>
                                                        @break
                                                    @case(\App\Models\Order::ORDER_IN_PROCESS)
                                                        <span class="">Order In Process</span>
                                                        @break
                                                    @case(\App\Models\Order::DELIVERY_IN_PROGRESS)
                                                        <span class="text-primary">Delivery In progress</span>
                                                        @break
                                                    @case(\App\Models\Order::PACKAGE_DELIVERED)
                                                        <span class="text-success">Package Delivered</span>
                                                        @break
                                                    @default
                                                    <span class="text-danger">Pending</span>
                                                @endswitch
                                            </td>
                                            <td class="a-center last">
                                                <span class="nobr">
                                                    <a href="{{ route('order', $order->order_number) }}" class="btn btn-secondary">Order Details</a>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            <div class="pager text-right" style="margin: 30px">
                            <div class="pages">
                                {{ $orders->render() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
