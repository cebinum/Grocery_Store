@extends('layouts.base')

@section('content')
<div class="container card p-5">
    @if (count(\Cart::getContent()))
    <div class="row">
        <div class="col-md-6">
            <div class="">
                <div class="card-body">
                    <h2 class="card-title mt-3"><b>Shopping Cart</b></h2>
                    <div class="row mx-auto">
                        <table>
                            @foreach(\Cart::getContent() as $product)
                            @php
                            $item = App\Models\Product::where('id', $product->id)->first();
                            @endphp
                            <div class="list-group-item list-group-item-action">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        {{ $loop->iteration }}. <img alt="{{ $product->name }}" src="{{ asset('product/'. $item->photo) }}" class="avatar rounded-circle">
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="mb-0 text-sm">{{ $product->name }}</h4>
                                            </div>
                                            <div class="text-right text-muted">
                                                {{-- <small><a href="{{ route('checkout.cart.remove', $product->id) }}" class="btn"> Remove</a></small> --}}
                                            </div>
                                        </div>
                                        <p class="text-sm mb-0">
                                            <strong>{{ $product->quantity }}</strong> x <span class="text-danger">${{ number_format(\Cart::get($product->id)->getPriceSum(),2) }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </table>

                        <div class="col pt-5">
                            <div class="list-group mb-3">
                                <div class="list-group-item p-3 bg-snow">
                                    <h5 class="mb-0">Order Summary</h5>
                                </div>
                                <div class="list-group-item py-2 px-3 bg-white">
                                    <div class="row w-100 no-gutters">
                                        <div class="col-6 text-pebble">
                                            Subtotal
                                        </div>
                                        <div class="col-6 text-right text-charcoal">
                                            ${{ number_format(\Cart::getSubTotal(),2) }}
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
                                            <b>${{ number_format(\Cart::getSubTotal() + 1,2) }}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
             <div class="card">
                 <div class="card-body">
                    <h1 class="card-title mt-3"><b>Order Information</b></h1>
                    <form id="checkoutForm" method="post" action="{{ route('order.store') }}">
                        @csrf
                        @method('post')
                        <p>Hello {{ auth()->user()->name }}, please fill out the form. <br>
                        We will get in touch with you via <b>{{ auth()->user()->email }}.</b>
                        </p>
                            <div class="form-group">
                                <label class="required" for="phonenumber">Phone Number <em class="text-danger">*</em></label>
                                <div class="input-box">
                                    <input type="tel" value="{{ old('phonenumber',auth()->user()->phone_number) }}" required name="phonenumber" id="phonenumber" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="required" for="state">State<em class="text-danger">*</em></label>
                                <div class="input-box">
                                    <input type="text" value="{{ old('state', auth()->user()->state) }}" required name="state" id="state" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="required" for="city">City<em class="text-danger">*</em></label>
                                <div class="input-box">
                                    <input type="text" value="{{ old('city', auth()->user()->city) }}" required name="city" id="city" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="required" for="address">Address<em class="text-danger">*</em></label>
                                <div class="input-box">
                                    <input type="text" value="{{ old('address', auth()->user()->address) }}" required name="address" id="address" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="required" for="zip_code">Zip Code<em class="text-danger">*</em></label>
                                <div class="input-box">
                                    <input type="text" value="{{ old('zip_code', auth()->user()->zip_code) }}" required name="zip_code" id="zip_code" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="required" for="mode_of_delivery">Mode of Delivery<em class="text-danger">*</em></label>
                                <div class="input-box">
                                    <select name="mode_of_delivery" required id="mode_of_delivery" class="form-control">
                                        <option value="pick_up">Store Pick up</option>
                                        <option value="doordash">DoorDash</option>
                                        <option value="ubereats">UberEats</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="required" for="notes">Additional Notes</label>
                                <div class="input-box">
                                    <textarea name="notes" id="" cols="30" rows="3" placeholder="Is there something you want us know? We are all ears!." class="text-input form-control"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning">Purchase</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center">
        <img src="{{ asset('argon/img/cart.jpg') }}" alt="">
        <h2 class="text-muted">Your cart is empty</h2>
    </div>
    @endif
</div>
@endsection
