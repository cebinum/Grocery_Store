@extends('layouts.base')
@section('content')
<div class="container mt-3 mt-md-5">
	<h2 class="text-charcoal hidden-sm-down">Your Order - {{ $order->order_number }}</h2>
	<div class="row">
		<div class="col-12">
			<div class="list-group mb-5">
				<div class="list-group-item p-3 bg-snow" style="position: relative;">
					<div class="row w-100 no-gutters">
						<div class="col-6 col-md">
							<h6 class="text-charcoal mb-0 w-100">Order Number</h6>
							<a href="" class="text-pebble mb-0 w-100 mb-2 mb-md-0">#{{ $order->order_number }}</a>
						</div>
						<div class="col-6 col-md">
							<h6 class="text-charcoal mb-0 w-100">Date</h6>
							<p class="text-pebble mb-0 w-100 mb-2 mb-md-0">{{ date('D F d, Y', strtotime($order->created_at)) }}</p>
						</div>
						<div class="col-6 col-md">
							<h6 class="text-charcoal mb-0 w-100">Total</h6>
							<p class="text-pebble mb-0 w-100 mb-2 mb-md-0">${{ number_format($order->grand_total,2) }}</p>
						</div>
						<div class="col-6 col-md">
							<h6 class="text-charcoal mb-0 w-100">Delivering To</h6>
							<p class="text-pebble mb-0 w-100 mb-2 mb-md-0">{{ $order->user->address }}</p>
						</div>
					</div>
				</div>
				<div class="list-group-item p-3 bg-white">
					<div class="row no-gutters">
						<div class="col-12 col-md-9 pr-0 pr-md-3">
                            @foreach ($order->orderItems as $orderItems)
                            <div class="row no-gutters mt-3">
                                <div class="col-3 col-md-1">
                                    <img class="img-fluid pr-3" src="{{ asset('product/'.$orderItems->product->photo) }}" alt="">
                                </div>
                                <div class="col-9 col-md-8 pr-0 pr-md-3">
                                    <h4 class="text-charcoal mb-2 mb-md-1">
                                        <a href="" class="text-charcoal">{{ $orderItems->product->title }}</a>
                                    </h4>
                                    <ul class="list-unstyled text-pebble mb-2 small">
                                        <li class="">
                                            <b>Qty:</b> {{ $orderItems->quantity }}
                                        </li>
                                    </ul>
                                    <h4 class="text-charcoal text-left mb-0 mb-md-2"><b>${{ number_format($orderItems->price, 2) }}</b></h4>
                                </div>
                                <div class="col-12 col-md-3 hidden-sm-down">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#purchaseReminder{{ $loop->iteration }}">
                                        <i class="fa fa-bell"></i> Set Reminder
                                    </button>

                                        <div class="modal fade" id="purchaseReminder{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="purchaseReminder{{ $loop->iteration }}Label" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="purchaseReminder{{ $loop->iteration }}Label">Set Purchase Reminder</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Set Purchase reminder for <img class="img-fluid pr-3" src="{{ asset('product/'.$orderItems->product->photo) }}" height="50px" width="50px" alt=""> {{ $orderItems->product->title }}</p>
                                                        <form id="checkoutForm" method="post" action="{{ route('reminders.store') }}">
                                                            @csrf
                                                            @method('post')
                                                            </p>
                                                                <div class="form-group">
                                                                    <label class="required" for="reminder_date">Reminder Date <em class="text-danger">*</em></label>
                                                                    <div class="input-box">
                                                                        <input type="date" value="{{ old('reminder_date') }}" required name="reminder_date" id="reminder_date" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="required" for="reminder_time">Reminder Time<em class="text-danger">*</em></label>
                                                                    <div class="input-box">
                                                                        <input type="time" value="{{ old('reminder_time') }}" required name="reminder_time" id="reminder_time" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <input type="hidden" name="product_id" value="{{ $orderItems->product->id }}">

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Set Reminder</button>
                                                                </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <hr>
                            @endforeach
						</div>
						<div class="col-12 col-md-3">
                            <div class="p-3 border-1">
                                    <h4>Order Status: @switch($order->status)
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
                                                    @endswitch</h4>
                                </div>
                            <div class="list-group mb-3">
                                <div class="list-group-item p-3 bg-snow">
                                    <h5 class="mb-0">Order Summary

                                        @switch($order->payment_status)
                                                    @case(1)
                                                        <span class="badge badge-success">Paid</span>
                                                        @break
                                                    @default
                                                    <span class="badge badge-danger">Not Paid</span>
                                                @endswitch</h5>
                                </div>
                                <div class="list-group-item py-2 px-3 bg-white">
                                    <div class="row w-100 no-gutters">
                                        <div class="col-6 text-pebble">
                                            Subtotal
                                        </div>
                                        <div class="col-6 text-right text-charcoal">
                                            ${{ number_format($order->grand_total -1 , 2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item py-2 px-3 bg-white">
                                    <div class="row w-100 no-gutters">
                                        <div class="col-6 text-pebble">
                                            Service Charge
                                        </div>
                                        <div class="col-6 text-right text-charcoal">
                                            ${{ number_format(1,2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item py-2 px-3 bg-snow">
                                    <div class="row w-100 no-gutters">
                                        <div class="col-8 text-charcoal">
                                            <b>Total</b>
                                        </div>
                                        <div class="col-4 text-right text-green">
                                            <b>${{ number_format($order->grand_total , 2) }}</b>
                                        </div>
                                    </div>

                                </div>
                                @if (!$order->payment_status)
                                 <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal " role="form">
                                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['invoiceId' => $order->order_number]) }}" >


                                    <input type="hidden" name="email" value="{{Auth::user()->email}}">

                                    <input type="hidden" name="orderID" value="{{ $order->order_number }}">


                                    <input type="hidden" name="amount" value="{{ $order->grand_total * 100}}">

                                    <input type="hidden" name="currency" value="GHS">

                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                                    {{ csrf_field() }}

                                    <button class="btn btn-success btn-block mt-3" type="submit">Pay ${{ number_format($order->grand_total, 2) }}</button>
                                </form>
                                @endif
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
