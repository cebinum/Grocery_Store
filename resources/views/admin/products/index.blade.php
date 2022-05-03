@extends('layouts.admin.argon')

@section('title' , 'All Products')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0">@yield('title')</h3>
                        </div>

                        <div class="col-6 text-right">
                            <button class="btn btn-success btn-round btn-icon" data-toggle="modal" data-target="#category">
                                <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                <span class="btn-inner--text">Add Product</span>
                            </button>
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

                @if ($products->isNotEmpty())
                    <div class="table-responsive py-4">
                        <table class="table align-items-center table-flush" id="datatable-buttons">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration}}</td>
                                        <td>
                                            <img src="{{ asset('product/'.$product->photo) }}" height="100px" alt="">
                                        </td>
                                        <td>{{$product->name }}</td>
                                        <td>{{$product->category->name }}</td>
                                        <td>{{$product->price }}</td>
                                        <td>
                                            @if ($product->isPending())
                                                <span class="text-danger">Not live</span>
                                            @else
                                                <span class="text-success">Live</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                        @if ($product->isPending())
                                            <a href="{{ route('products.live', $product->id) }}" class="btn btn-outline-success">go live</a>
                                        @else
                                            <a href="{{ route('products.live', $product->id) }}" class="btn btn-outline-danger">go off</a>
                                        @endif
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-dark">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @if ($product->orderItems->isEmpty())
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure this item?');">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{ csrf_field() }}
                                                <button class="btn btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center m-5">
                        <img src="{{ asset('argon/img/images.png')}}" alt="" width="50%" >
                        <h2 class="text-center mt-5">All products will show here</h2>
                        <button class="btn btn-success btn-round btn-icon" data-toggle="modal" data-target="#category">
                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                            <span class="btn-inner--text">Add Product</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

<div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a new Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Category</label>
                            <select name="category" required class="form-control">
                                <option></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Product Name</label>
                            <input type="text" name="name" required class="form-control" value="{{ old('name') }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Product Quantity</label>
                            <input type="text" name="quantity" required class="form-control" value="0">
                        </div>

                        {{-- <div class="col-md-6 mb-3"> --}}
                            {{-- <label>Unit of Measurement</label> --}}
                            {{-- <span class="input-group-addon"> --}}
                                <input type="hidden" value="empt" name="product[unit]" required>
                            {{-- </span> --}}
                        {{-- </div> --}}

                        <div class="col-md-12 mb-3">
                            <label>Price(USD)</label>
                            <input type="text" class="form-control" required name="product[price]">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Image</label>
                            <input type="file" class="form-control" name="photo" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
