<div class="content-wrapper  layout-top-nav">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Envato Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @php
        use App\Models\Product;
        $allDatas = Product::with('productVariant')->get();
    @endphp




    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                @foreach ($allDatas as $alldata)
                    @php
                        $variant = $alldata->productVariant->first();
                    @endphp

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card card-primary card-outline h-100">
                            <!-- Fixed image size with object-fit cover -->
                            <img src="{{ $alldata->product_image }}" class="card-img-top"
                                alt="{{ $alldata->product_name }}"
                                style="width: 100%; height: 250px; object-fit: cover;">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $alldata->product_name }}</h5>
                                <p class="card-text flex-grow-1">{{ $alldata->small_description }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <a href="{{ route('view.image.now', $alldata->id) }}"
                                        class="btn btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                              @if ($variant)
                                        <a href="{{ route('cart.access', $variant->id) }}" class="btn btn-primary">
                                            Add to Cart
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            Out of Stock
                                        </button>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach



            </div> <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
