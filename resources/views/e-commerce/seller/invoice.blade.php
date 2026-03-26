@extends('e-commerce.seller.master')



@section('invoice-content')
    <div class="content d-flex flex-column min-vh-100">


        <div class="container pt-4 flex-grow-1 ">

            <div class="row mb-4">
                <div class="col-6">
                    <h4>
                        <i class="fas fa-store"></i> Envato Market
                    </h4>
                </div>

                <div class="col-6 text-end">
                    <h5><strong>INVOICE</strong></h5>
                    <p>Date: {{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-6">
                    <h6><strong>ADDRESS:</strong></h6>
                    <p>
                        {{ $order->order_address ?? 'N/A' }} <br>
                    </p>
                </div>

                <div class="col-6 text-end">
                    <h6><strong>BILL TO:</strong></h6>
                    <p>
                        <strong>Name: &nbsp; </strong> {{ $order->user_rel->name }} <br>
                        <strong>Email: &nbsp; </strong> {{ $order->user_rel->email }} <br>
                    </p>
                </div>
            </div>

            <h5 class="mb-3"><strong>Order ID : {{ $order->id }}</strong></h5>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>PRODUCT NAME</th>
                            <th>QTY</th>
                            <th>PRICE</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach ($order->orderDetails_rel as $detail)
                            @php
                                $price = $detail->price_per_unit ?? 0;
                                $total = $detail->order_quantity * $price;
                                $grandTotal += $total;
                            @endphp

                            <tr>
                                <td>

                                    <img src="{{ asset($detail->variant->image) }}" width="40" height="40"
                                        class="me-5 rounded border">

                                    {{ $detail->variant->product->product_name ?? 'N/A' }}
                                </td>
                                <td>{{ $detail->order_quantity }}</td>
                                <td>₹{{ $price }}</td>
                                <td>₹{{ $total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4">
                <h5><strong>Grand Total: ₹{{ $grandTotal }}</strong></h5>
            </div>

        </div>

    </div>
@endsection
