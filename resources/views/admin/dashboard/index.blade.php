@extends('layouts.admin.argon')

@section('title', 'Dashboard')

@section('headerbreadcrum')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Visits</h5>
                            <span class="h2 font-weight-bold mb-0">0</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-active-40"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-nowrap">Since last month</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Products</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $products->count() }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                                <i class="ni ni-chart-pie-35"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <a href="{{ route('products.index') }}" class="text-nowrap">See all Products</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Pending Orders</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $orders->count() }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <a href="{{ route('orders.index') }}" class="text-nowrap">See all Orders</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">All Users</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $users->count() }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-chart-bar-32"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <a href="{{ route('users.index') }}" class="text-nowrap">See all Users</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Pending Orders</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-success">See all</a>
                            </div>
                        </div>
                    </div>
                    @if ($orders->isNotEmpty())
                    <div class="table-responsive py-4">
                        <table class="table align-items-center table-flush" id="datatable-buttons">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Order Number</th>
                                    <th>Order By</th>
                                    <th class="text-center">Number of Items</th>
                                    <th>Grand Total</th>
                                    <th>Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Order Number</th>
                                    <th>Order By</th>
                                    <th class="text-center">Number of Items</th>
                                    <th>Grand Total</th>
                                    <th>Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration}}</td>
                                        <td class="text-success"><b>{{$order->order_number }}</b></td>
                                        <td>{{$order->user->name }}</td>
                                        <td class="text-center">{{$order->orderItems->count() }}</td>
                                        <td>GHS {{ number_format($order->grand_total,2) }}</td>
                                        <td>{{$order->date }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-success">
                                                Details
                                            </a>
                                        </td>
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

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Recent Users</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-success">See all</a>
                            </div>
                        </div>
                    </div>
                    @if ($users->isNotEmpty())
                    <div class="table-responsive py-4">
                        <table class="table align-items-center table-flush" id="datatable-buttons">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date Registered</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date Registered</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($users->take(10) as $user)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration}}</td>
                                        <td>{{$user->name }}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->created_at->diffForHumans() }}</td>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center m-5">
                        <img src="{{ asset('argon/img/users.png')}}" alt="" width="50%" >
                        <h2 class="text-center mt-5">All users will show here</h2>
                    </div>
                @endif
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Trending Products</h3>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Product</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr>
                                        <td>
                                            @if ($item->product_id == 0)
                                                <img src="{{ asset('images/pinapple.jpg') }}" height="60px">
                                            @else
                                                <img src="{{ asset('product/'.$item->product->photo) }}" height="60px" alt="">
                                            @endif
                                        </td>
                                        <th scope="row">
                                            @if ($item->product_id == 0)
                                                Mystery Market
                                            @else
                                                {{ $item->product->name }}</th>
                                            @endif
                                        <td class="text-center">{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
