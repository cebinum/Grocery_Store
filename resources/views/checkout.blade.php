@extends('layouts.base')

@section('content')
<div class="container">
    <div class="card">
        <h1 class="text-center card-title mt-5"><b>CART</b></h1>
        <div class="card-body">
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
                                        <div class="input-group text-right">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-warning btn-number"  data-type="minus" data-field="quantity">
                                                    <span class="fa fa-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="quantity" class="form-control input-number" value="{{ $product->quantity }}" min="1" max="100">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quantity">
                                                    <span class="fa fa-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <small><a href="{{ route('checkout.cart.remove', $product->id) }}" class="btn"> Remove</a></small>
                                </div>
                                <p class="text-sm mb-0">
                                    <strong>{{ $product->quantity }}</strong> x <span class="text-danger">${{ number_format(\Cart::get($product->id)->getPriceSum(),2) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <a href="{{ route('payment') }}" class="dropdown-item text-center text-warning font-weight-bold py-3">Proceed Checkout <i class="fa fa-arrow-right"></i></a>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.btn-number').click(function(e){
    e.preventDefault();

    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {

            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }


});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>
@endsection
