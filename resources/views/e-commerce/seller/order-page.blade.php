@extends('e-commerce.seller.master')

@section('product-content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .table th {
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .badge-status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .btn-view {
            border-radius: 20px;
            padding: 5px 15px;
        }

        .dataTables_filter input {
            border-radius: 20px !important;
            padding-left: 15px !important;
        }

        .dataTables_length select {
            border-radius: 10px;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f7ff;
            transition: 0.2s;
        }
    </style>

    <div class="container-fluid mt-4">

        <div class="card shadow-lg border-0">

            <div class="card-header d-flex justify-content-between align-items-center text-white">

                <h5 class="mb-0">
                    <i class="fa-solid fa-boxes-stacked me-2"></i> My Order Page
                </h5>


            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="productTable" class="table table-hover table-bordered align-middle text-center">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>QUANTITY</th>
                                <th>PRODUCT</th>
                                <th>CUSTOMER</th>
                                <th>AMOUNT</th>
                                <th>STATUS</th>
                                <th>CREATE</th>
                                <th>OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>

                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $order->orderDetails_rel->sum('order_quantity') }}
                                        </span>
                                    </td>



                                    <td class="text-start">
                                        @foreach ($order->orderDetails_rel as $detail)
                                            <div class="d-flex align-items-center mb-2">

                                                <img src="{{ asset($detail->variant->image) }}"
                                                    width="40" height="40" class="me-5 rounded border">

                                                <div>
                                                    <strong>{{ $detail->variant->product->product_name }}</strong>

                                                    <br>

                                                    <small class="text-muted">
                                                        @foreach ($detail->variant->variantAttributes as $attr)
                                                            <strong class="text-warning">
                                                                {{ $attr->attribute->name }} :
                                                                {{ $attr->attributeValue->value }}
                                                            </strong>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </small>

                                                </div>

                                            </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        <i class="fa fa-user me-1 text-muted"></i>
                                        {{ $order->user_rel->name }}
                                    </td>

                                    <td><strong class="text-success">
                                            ${{ $order->final_amount }}
                                        </strong>
                                    </td>

                                    <td>
                                        <span
                                            class="badge
                                            @if ($order->status == 'pending') bg-warning text-dark
                                            @elseif($order->status == 'completed') bg-success
                                            @elseif($order->status == 'cancelled') bg-danger
                                            @else bg-success @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td>{{ $order->created_at->format('d M Y') }}</td>

                                    <td>
                                        <a href="{{ route('invoice.page', $order->id) }}"
                                            class="btn btn-danger btn-sm btn-view">
                                            <i class="fa fa-eye me-1"></i> View
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <script>
        $(document).ready(function() {

            $('#productTable').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search orders..."
                }
            });

        });
    </script>
@endsection
