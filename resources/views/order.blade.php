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
				