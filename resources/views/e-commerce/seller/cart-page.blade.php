@extends('e-commerce.seller.master')

<?php
use App\Models\Cart;

$user = Auth::user();
$cart = Cart::with('variant.product', 'variant.attributes.attributeValue')->where('user_id', Auth::id())->get();
// $cart = Cart::where('user_id', $user->id)->get();
?>

@section('cart-content')

    <div class="container mt-4" style="min-height:80vh;">
        <h2 class="mb-4">Shopping Cart</h2>

        <div class="row">

            <!-- Cart Items -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="row text-muted fw-bold border-bottom pb-2 mb-3">
                            <div class="col-md-6">Product</div>
                            <div class="col-md-2">Price</div>
                            <div class="col-md-2">Qty</div>
                            <div class="col-md-2">Total</div>
                        </div>

                        @if ($cart->count() > 0)
                            {{-- @foreach ($cart as $item)
                                <div class="row align-items-center mb-3 " id="row{{ $item->product_rel->id }}">

                                    <div class="col-md-6 d-flex align-items-center">

                                            <img src="{{ $item->product_rel->product_image }}" width="70"
                                                class="me-3 rounded">  &nbsp;  &nbsp;   &nbsp;


                                        <div>
                                            <h6 class="mb-1">{{ $item->product_rel->product_name }}</h6>

                                            <a href="{{ route('product-remove', $item->product_rel->id) }}"
                                                class="text-danger small">Remove</a>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        ${{ $item->price }}
                                    </div>

                                    <div class="col-md-2">

                                        <a class="decrement btn btn-danger btn-sm"
                                            data-id="{{ $item->product_rel->id }}">-</a>

                                        <span class="qty{{ $item->product_rel->id }} mx-2">
                                            {{ $item->quantity }}
                                        </span>

                                        <a class="increment btn btn-success btn-sm"
                                            data-id="{{ $item->product_rel->id }}">+</a>

                                    </div>

                                    <div class="col-md-2 fw-bold total{{ $item->product_rel->id }}">
                                        ${{ $item->price * $item->quantity }}
                                    </div>

                                </div>

                                <hr>
                            @endforeach --}}


                            @foreach ($cart as $item)
                                <div class="row align-items-center mb-3" id="row{{ $item->variant->id }}">

                                    <div class="col-md-6 d-flex align-items-center">

                                        <img src="{{ $item->variant->product->product_image }}" width="70"
                                            class="me-3 rounded">

                                        {{--
                                        <h6 class="mb-1">
                                            {{ $item->variant->product->product_name }}
                                        </h6> --}}


                                        <small class="text-muted">
                                            @foreach ($item->variant->attributes as $attr)
                                                {{ $attr->attributeValue->value }},
                                            @endforeach
                                        </small>



                                        <div>
                                            <h6 class="mb-1">
                                                {{ $item->variant->product->product_name }}
                                            </h6>

                                            <a href="{{ route('product-remove', $item->variant->id) }}"
                                                class="text-danger small">Remove</a>
                                        </div>

                                    </div>

                                    <div class="col-md-2">
                                        ${{ $item->price }}
                                    </div>

                                    <div class="col-md-2">

                                        <a class="decrement btn btn-danger btn-sm" data-id="{{ $item->variant->id }}">-</a>

                                        <span class="qty{{ $item->variant->id }} mx-2">
                                            {{ $item->quantity }}
                                        </span>

                                        <a class="increment btn btn-success btn-sm"
                                            data-id="{{ $item->variant->id }}">+</a>

                                    </div>

                                    <div class="col-md-2 fw-bold total{{ $item->variant->id }}">
                                        ${{ $item->price * $item->quantity }}
                                    </div>

                                </div>

                                <hr>
                            @endforeach
                        @else
                            <div class="text-center p-5">
                                <h5 class="text-muted">No item added to cart yet</h5>

                                <a href="{{ route('e-commerce-page') }}" class="btn btn-warning mt-3">
                                    Continue Shopping
                                </a>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                <a class="btn btn-danger" href="{{ route('e-commerce-page') }}">
                                    Back
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3">Order Summary</h5>

                        @php
                            $subtotal = 0;
                        @endphp

                        @foreach ($cart as $item)
                            @php
                                $subtotal += $item->price * $item->quantity;
                            @endphp
                        @endforeach

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span id="subtotal">${{ $subtotal }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span id="total">${{ $subtotal }}</span>
                        </div>

                        <a href="{{ route('order.checkout') }}" class="btn btn-success w-100 mt-3">
                            Proceed to Checkout
                        </a>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('click', '.increment', function() {

            var id = $(this).data('id');

            $.get('/inc-order/' + id, function(res) {

                $('.qty' + id).text(res.quantity);
                $('.total' + id).text('$' + res.total);
                $('#subtotal').text('$' + res.subtotal);
                $('#total').text('$' + res.subtotal);

            });

        });


        $(document).on('click', '.decrement', function() {

            var id = $(this).data('id');

            $.get('/dec-order/' + id, function(res) {

                if (res.quantity == 0) {

                    $('#row' + id).remove();

                } else {

                    $('.qty' + id).text(res.quantity);
                    $('.total' + id).text('$' + res.total);

                }

                $('#subtotal').text('$' + res.subtotal);
                $('#total').text('$' + res.subtotal);

            });

        });
    </script>

@endsection
