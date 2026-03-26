@extends('admin.layout.master')

<?php
use App\Models\Product;
$products = Product::with(['categories_rel', 'variants.inventory'])->get();

?>

@section('all-product-content')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <div class="container-fluid mt-4">

        <div class="card shadow border-0">

            <!-- Success Alert -->
            @if (session('success'))
                <div class="m-3">
                    <div id="successAlert" class="alert alert-success alert-dismissible fade show shadow-sm">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Auto hide alert -->
            <script>
                setTimeout(function() {
                    let alert = document.getElementById('successAlert');
                    if (alert) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>

            <!-- Header -->
            <div class="card-header d-flex justify-content-between align-items-center text-white"
                style="background:#2C3046;">

                <h5 class="mb-0">
                    <i class="fa-solid fa-boxes-stacked"></i> All Product Stocks
                </h5>

                <span class="badge bg-info fs-6">
                    Total : {{ count($products) }}
                </span>
            </div>

            <!-- Body -->
            <div class="card-body">

                <!-- Add Button -->
                <div class="mb-3">
                    <a href="{{ route('product.create') }}" class="btn btn-danger">
                        <i class="fa fa-plus"></i> Add Product
                    </a>
                </div>

                <!-- Table -->
                <table id="productTable" class="table table-hover table-bordered align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>PRODUCT</th>
                            <th>CATEGORY</th>
                        
                            <th>SHORT DESC</th>
                            <th>DESC</th>
                            <th>CREATED</th>
                            <th>UPDATED</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr>

                                <td><strong>{{ $product->id }}</strong></td>

                                <!-- Product -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ filter_var($product->product_image, FILTER_VALIDATE_URL) ? $product->product_image : asset($product->product_image) }}"
                                            style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #ddd;"
                                            class="me-2">

                                        <div>
                                            <strong>{{ $product->product_name }}</strong>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $product->categories_rel->title ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Quantity -->
                                {{-- <td>
                                <span class="badge bg-secondary">
                                    {{ $product->inventory->quantity ?? 0 }}
                                </span>
                            </td> --}}



                                <!-- Short Desc -->
                                <td>
                                    {{ Str::limit($product->small_description, 40) }}
                                </td>

                                <!-- Desc -->
                                <td>
                                    {{ Str::limit($product->description, 50) }}
                                </td>



                                <!-- Dates -->
                                <td>{{ $product->created_at->format('d M Y') }}</td>
                                <td>{{ $product->updated_at->format('d M Y') }}</td>


                                <!-- Actions -->
                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- Edit -->
                                        <a href="{{ route('edit.page.seller.product', $product->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>

                                        <!-- Delete -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $product->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title text-danger">
                                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                                        Delete Confirmation
                                                    </h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body text-center">
                                                    Are you sure you want to delete?
                                                    <br>
                                                    <strong class="text-danger">
                                                        {{ $product->product_name }}
                                                    </strong>
                                                </div>

                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>

                                                    <a href="{{ route('delete.seller.product', $product->id) }}"
                                                        class="btn btn-danger">
                                                        Yes, Delete
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

    <!-- DataTable -->
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search products..."
                }
            });
        });
    </script>
@endsection
