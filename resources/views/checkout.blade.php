@extends('layouts.base')

@section('content')
<div class="container">
    <div class="card">
        <h1 class="text-center card-title mt-5"><b>CHECKOUT</b></h1>
        <div class="card-body">
            <div class="row mx-auto">
                <table>
                    @foreach(\Cart::getContent() as $product)
                    @php
                    $item = App\Models\Product::where('id', $product->id)->first();
                    @endphp
                    <a href="#!" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <!-- Avatar -->
                                {{ $loop->iteration }}. <img alt="{{ $product->name }}" src="{{ asset('product/'. $item->photo) }}" class="avatar rounded-circle">
                            </div>
                            <div class="col ml--2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-0 text-sm">{{ $product->name }}</h4>
                                    </div>
                                    <div class="text-right text-muted">
                                        <small>Remove</small>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">
                                    <strong>{{ $product->quantity }}</strong> x <span class="text-danger">${{ number_format(\Cart::get($product->id)->getPriceSum(),2) }}</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    <a href="{{ route('checkout') }}" class="dropdown-item text-center text-warning font-weight-bold py-3">Proceed to Payment <i class="fa fa-arrow-right"></i></a>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
