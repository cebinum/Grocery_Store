@extends('layouts.base')

@section('content')
<div class="container">
    <div class="card pb-4">
        @if (auth()->user()->purchaseReminder->count())
        <h1 class="text-center card-title mt-5"><b>Purchase Reminders</b></h1>
        <div class="card-body">
            <div class="row mx-auto">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>S/N</th>
                            <th>Product</th>
                            <th>Reminder Date</th>
                            <th>Reminder Time</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach (auth()->user()->purchaseReminder as $purchaseReminder)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img alt="{{ $purchaseReminder->product->title }}" src="{{ asset('product/'.$purchaseReminder->product->photo) }}" height="50px">  {{ $purchaseReminder->product->name }}</td>
                                <td>{{ $purchaseReminder->reminder_date }}</td>
                                <td>{{ $purchaseReminder->reminder_time }}</td>
                                <td>
                                    @switch($purchaseReminder->staus)
                                        @case(1)
                                            <span class="badge badge-success">Sent</span>
                                            @break
                                        @default
                                        <span class="badge badge-danger">Pending</span>
                                    @endswitch
                                </td>
                                <td>
                                    <a title="{{ $purchaseReminder->product->title }}" class="btn btn-warning btn-sm" href="{{ url('product/'.$purchaseReminder->product->slug) }}" >View Product</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
            <div class="text-center">
                <img src="{{ asset('argon/img/reminder.jpg') }}"  width="50%" alt="">
                <h2 class="text-muted">No Purchase Reminders yet</h2>
            </div>
        @endif
    </div>
</div>
@endsection
