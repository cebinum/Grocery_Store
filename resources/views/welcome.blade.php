@extends('layouts.base')

@section('content')
    <div class="container-fluid">
        <div class="card pb-5">
            <h1 class="text-center card-title mt-5"><b>PRODUCTS</b></h1>
            <div class="card-body">
                <div class="row mx-auto">
                    @foreach ($products as $product)
                        <div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="item-inner border">
                                <div class="item-img text-center">
                                    <div class="item-img-info">
                                        <a class="product-image" title="{{ $product->title }}" href="{{ url('product/'.$product->slug) }}">
                                        <img alt="{{ $product->title }}" src="{{ asset('product/'.$product->photo) }}" height="300px"> </a>
                                    </div>
                                </div>
                                <div class="border p-3">
                                    <div class="info-inner border-1">
                                        <h2 class="item-title text-center">
                                            <a title="{{ $product->title }}" href="{{ url('product/'.$product->slug) }}" >{{ $product->title }}</a>
                                        </h2>
                                        <div class="item-content">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="item-price">
                                                        <div class="price-box"> <span class="regular-price"> <span class="price">{{ $product->price }}</span> </span> </div>
                                                    </div>

                                                </div>
                                                <div class="col">
                                                    <div class="action text-right">
                                                        <form action="{{ route('cart.add') }}" method="post">
                                                            @csrf
                                                            <input name="id" value="{{ $product->id }}" hidden>
                                                            <input name="name" value="{{ $product->title }}" hidden>
                                                            <input name="price" value="{{ $product->actualPrice }}" hidden>
                                                            <input name="quantity" value="1" hidden>
                                                            <button class="btn btn-warning btn-sm " type="submit" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
