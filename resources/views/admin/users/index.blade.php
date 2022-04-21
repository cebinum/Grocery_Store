@extends('layouts.admin.argon')

@section('title' , 'Users')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="mb-0">@yield('title')</h3>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    @include('flash::message')
                </div>

                @if ($users->isNotEmpty())
                    <div class="table-responsive py-4">
                        <table class="table align-items-center table-flush" id="datatable-buttons">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Total Orders</th>
                                    <th>Date Registered</th>
                                    <th>Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Total Orders</th>
                                    <th>Date Registered</th>
                                    <th>Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration}}</td>
                                        <td>{{$user->name }}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->orders->count() }}</td>
                                        <td>{{$user->created_at->diffForHumans() }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-success">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>

                                            @if ($user->id != auth()->id())
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure this User?');">
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
                        <img src="{{ asset('argon/img/users.png')}}" alt="" width="50%" >
                        <h2 class="text-center mt-5">All users will show here</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
