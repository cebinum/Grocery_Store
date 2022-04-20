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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group text-center">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-warning btn-number"  data-type="minus" data-field="quantity">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </span>
                                    <input type="text" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quantity">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </span>
                                </div>
                                <input name="id" value="{{ $product->id }}" hidden>
                                <input name="name" value="{{ $product->title }}" hidden>
                                <input name="price" value="{{ $product->actualPrice }}" hidden>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-warning" type="submit" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3">
        
        <h1 class="text-center text-uppercase mb-5"><b><u>Related Products</u></b></h1>
         <div class="row">
            @foreach ($relatedProducts->take(3) as $product)
                <div class="item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="item-inner border">
                        <div class="item-img text-center">
                            <div class="item-img-info">
                                <a class="product-image" title="{{ $product->title }}" href="{{ url('product/'.$product->slug) }}">
                                <img alt="{{ $product->title }}" src="{{ asset('product/'.$product->photo) }}" height="300px" width="300px"> </a>
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
