@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
             <div class="card">
                 <div class="card-body">
                    <h1 class="card-title mt-3"><b>Personal Information</b></h1>
                    <form id="checkoutForm" method="post" action="{{ route('profile.store') }}">
                        @csrf
                        @method('post')
                        </p>
                            <div class="form-group">
                                <label class="required" for="name">Name <em class="text-danger">*</em></label>
                                <div class="input-box">
                                    <input type="tel" value="{{ old('name',auth()->user()->name) }}" required name="name" id="name" class="form-control">
                                </div>
                            </div>
                            
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

                            <button type="submit" class="btn btn-warning">Update Profile</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
