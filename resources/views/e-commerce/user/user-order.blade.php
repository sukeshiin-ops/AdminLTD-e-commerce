@extends('e-commerce.seller.master')

@if (session('success'))
    <div id="success-message" class="alert alert-success" style="background-color:#1e7e34; color:#fff;">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            let msg = document.getElementById('success-message');
            if (msg) {
                msg.style.transition = "opacity 0.5s ease";
                msg.style.opacity = 0;
                setTimeout(() => msg.remove(), 500);
            }
        }, 2000);
    </script>
@endif

@section('product-content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .card {
            border-radius: 12px;
        }

        .card-header {
            background: linear-gradient(135deg, #2C3046, #3f4664);
            border-radius: 12px 12px 0 0;
        }

        .badge-status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
    </style>

    <div class="container-fluid mt-4">

        <div class="card shadow-lg border-0">

            <div class="card-header text-white">
                <h5 class="mb-0">
                    <i class="fa-solid fa-boxes-stacked me-2"></i> My Orders
                </h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="orderTable" class="table table-hover table-bordered text-center">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>QUANTITY</th>
                                <th>PRODUCT</th>
                                <th>ADDRESS</th>
                                <th>AMOUNT</th>
                                <th>STATUS</th>
                                <th>ORDER DATE</th>
                                {{-- <th>ACTION</th> --}}
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($orders as $order)
                                <tr>


                                    <td><strong>#{{ $order->id }}</strong></td>


                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $order->orderDetails_rel->sum('order_quantity') }}
                                        </span>
                                    </td>

                                    <td class="text-start">
                                        @foreach ($order->orderDetails_rel as $detail)
                                            <div class="mb-2 p-2 border rounded">


                                                <strong class="d-block">
                                                    {{ optional($detail->variant->product)->product_name }}
                                                </strong>


                                                <small class="text-muted">
                                                    @foreach ($detail->variant->attributes as $attr)
                                                        <span class="badge bg-light text-dark border">
                                                            {{ $attr->attributeValue->attribute->name }}:
                                                            {{ $attr->attributeValue->value }}
                                                        </span>
                                                    @endforeach
                                                </small>



                                            </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        <strong class="text-primary">
                                            {{ $order->order_address }}
                                        </strong>
                                    </td>


                                    <td>
                                        <strong class="text-success">
                                            ${{ $order->final_amount }}
                                        </strong>
                                    </td>


                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($order->status == 'cancle')
                                            <span class="badge bg-danger">Cancle</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-primary">Shipped</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @endif
                                    </td>


                                    <td>
                                        <strong> {{ $order->created_at->format('d M Y') }}</strong>
                                    </td>

                                    <!-- Action -->
                                    {{-- <td>
                                    <a href="{{ route('invoice.page', $order->id) }}"
                                        class="btn btn-danger btn-sm">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                </td> --}}

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="text-center p-4">
                                            <h6>No Orders Found </h6>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#orderTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25],
                responsive: true
            });
        });
    </script>
@endsection
