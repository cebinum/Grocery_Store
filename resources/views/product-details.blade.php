@extends('layouts.base')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row mx-auto">
                <div class="col-md-6">
                    <img alt="{{ $product->title }}" src="{{ asset('product/'.$product->photo) }}" width="100%"> </a>
                </div>
                <div class="col-md-6">
                    <h1 class="card-title mb-3">{{ $product->title }} </small></h1>
                    <h2 class="card-title mb-3"><span> {{ $product->category->name }}</span></h2>
                    <h1 class="card-title text-warning mb-3">{{ $product->price }}</h1><hr>

                    <form action="{{ route('cart.add') }}" method="post">
                        @csrf
                        <input name="id" value="{{ $product->id }}" hidden>
                        <input name="name" value="{{ $product->title }}" hidden>
                        <input name="price" value="{{ $product->actualPrice }}" hidden>
                        <input name="quantity" value="1" hidden>
                        <button class="btn btn-warning" type="submit" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
