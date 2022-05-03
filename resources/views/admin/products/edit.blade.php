@extends('layouts.admin.argon')

@section('title' , 'Edit '. $product->name)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">@yield('title')</h3>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    @include('flash::message')
                </div>

                 @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        @foreach ($errors->all() as $error)
                            <span>{{$error}}</span><br>
                        @endforeach
                    </div>
                @endif


                <div class="card-body container">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label>Category</label>
                                <select name="category" required class="form-control">
                                    <option></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id? 'selected':'' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Product Name</label>
                                <input type="text" name="name" required class="form-control" value="{{ $product->name }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Product Quantity</label>
                                <input type="text" name="quantity" required class="form-control" value="{{ $product->quantity }}">
                            </div>

                            {{-- <div class="col-md-6 mb-3"> --}}
                            {{-- <label>Unit of Measurement</label> --}}
                            {{-- <span class="input-group-addon"> --}}
                                <input type="hidden" value="empt" name="product[unit]" required>
                            {{-- </span> --}}
                        {{-- </div> --}}

                        <div class="col-md-12 mb-3">
                           <!-- <label>Price(USD)</label>-->
                           <label>Price(USD)</label>
                            <input type="text" class="form-control" required name="product[price]" value="{{ $product->unit_and_price['price'] }}">
                        </div>


                            <div class="col-md-12 mb-3">
                                <img src="{{ asset('product/'.$product->photo) }}" height="100px" alt="{{ $product->name }}"><br>
                                <label>Update Image</label>
                                <input type="file" class="form-control" name="photo">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary"> Cancel</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
