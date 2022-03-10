@extends('layouts.admin.argon')

@section('title' , 'All Categories')

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
                                <span class="btn-inner--text">Add Category</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    @include('flash::message')
                </div>
                @if ($categories->isNotEmpty())
                    <div class="table-responsive py-4">
                        <table class="table align-items-center table-flush" id="">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name of Category</th>
                                    <th class="text-center">Total Comomdities</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name of Category</th>
                                    <th class="text-center">Total Comomdities</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration}}</td>
                                        <td>{{$category->name }}</td>
                                        <td class="text-center">{{$products = $category->products->count()}}</td>
                                        <td class="text-center">

                                            <button class="btn btn-outline-dark btn-round btn-icon" data-toggle="modal" data-target="#edit-{{ $loop->iteration }}">
                                                <span class="btn-inner--icon"><i class="fas fa-user-edit"></i></span>
                                            </button>

                                            <div class="modal fade" id="edit-{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit {{$category->name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                                @csrf
                                                                @method('patch')
                                                                <div class="form-row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <h4 class="text-left">Category Name</h4>
                                                                        <input type="text" class="form-control" name="name" value="{{$category->name }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success">Update {{$category->name }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ( $products < 1)
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure?');">
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
                        <h2 class="text-center mt-5">All categories will show here</h2>
                        <button class="btn btn-success btn-round btn-icon" data-toggle="modal" data-target="#category">
                            <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                            <span class="btn-inner--text">Add Category</span>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="name" required>
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
