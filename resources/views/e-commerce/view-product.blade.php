<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | E-commerce</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin2/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin2/dist/css/adminlte.min.css') }}">

    <style>
        /* Make product image uniform and responsive */
        .product-image {
            width: 100%;
            max-height: 450px;
            /* Adjust as needed */
            object-fit: cover;
            /* Crop if needed, keeps proportions */
            border-radius: 5px;
        }

        /* Optional: thumbnail images for multiple views */
        .product-image-thumb img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
        }

        .product-image-thumb.active {
            border: 2px solid #007bff;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <!-- Site wrapper -->
    <div class="wrapper">

        @include('e-commerce.nav-bar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('e-commerce-page') }}">Home</a></li>
                                <li class="breadcrumb-item active">E-commerce</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <div class="card card-solid">
                        <div class="card-body">
                            <div class="row">
                                <!-- Product Image -->
                                <div class="col-12 col-sm-6">
                                    <h3 class="d-inline-block d-sm-none">{{ $product->product_name }}</h3>
                                    <div class="col-12">
                                        <img src="{{ $product->product_image }}" class="product-image"
                                            alt="{{ $product->product_name }}">
                                    </div>

                                    <!-- Optional thumbnails -->
                                    {{--
                                <div class="product-image-thumbs mt-2">
                                    <div class="product-image-thumb active">
                                        <img src="{{ $product->product_image }}" alt="Thumbnail 1">
                                    </div>
                                    <div class="product-image-thumb">
                                        <img src="{{ $product->product_image2 ?? $product->product_image }}" alt="Thumbnail 2">
                                    </div>
                                </div>
                                --}}
                                </div>

                                @php
                                use App\Models\Attribute;
                                    $colors = Attribute::where('type', 1)->with('AttributeValue')->first();


                                @endphp
{{--
                            <pre>{{ $colors->toJson(JSON_PRETTY_PRINT) }}</pre>

                            @php
                                dd(4);
                            @endphp --}}

                                <!-- Product Details -->
                                <div class="col-12 col-sm-6">
                                    <h3 class="my-3">{{ $product->product_name }}</h3>
                                    <p>{{ $product->description }}</p>

                                    <hr>

                                    <h4>Available Colors</h4>
                                            @foreach ($colors->AttributeValue as $c)
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_a2"
                                                autocomplete="off">
                                         {{ $c->value }}
                                            <br>
                                            <i class="fas fa-circle fa-2x text-{{ Str::lower($c->value) }}"></i>
                                        </label>
                                    @endforeach
                                    {{-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-default text-center active">
                                            <input type="radio" name="color_option" id="color_option_a1"
                                                autocomplete="off" checked>
                                            Green
                                            <br>
                                            <i class="fas fa-circle fa-2x text-green"></i>
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_a2"
                                                autocomplete="off">
                                            Blue
                                            <br>
                                            <i class="fas fa-circle fa-2x text-blue"></i>
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_a3"
                                                autocomplete="off">
                                            Purple
                                            <br>
                                            <i class="fas fa-circle fa-2x text-purple"></i>
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_a4"
                                                autocomplete="off">
                                            Red
                                            <br>
                                            <i class="fas fa-circle fa-2x text-red"></i>
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_a5"
                                                autocomplete="off">
                                            Orange
                                            <br>
                                            <i class="fas fa-circle fa-2x text-orange"></i>
                                        </label>
                                    </div> --}}

                                    @php
                                        $categoryId = $product->category_id;

                                    @endphp




                                    <h4 class="mt-3">Size <small>Please select one</small></h4>
                                    {{-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_b1"
                                                autocomplete="off">
                                            <span class="text-xl">S</span>
                                            <br>
                                            Small
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_b2"
                                                autocomplete="off">
                                            <span class="text-xl">M</span>
                                            <br>
                                            Medium
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_b3"
                                                autocomplete="off">
                                            <span class="text-xl">L</span>
                                            <br>
                                            Large
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option_b4"
                                                autocomplete="off">
                                            <span class="text-xl">XL</span>
                                            <br>
                                            Xtra-Large
                                        </label>
                                    </div> --}}


                                    <div class="bg-gray py-2 px-3 mt-4">
                                        <h2 id="price" class="mb-0">${{ $product->product_price }}</h2>
                                        <h4 class="mt-0">
                                            <small>Ex Tax: ${{ $product->tax }}</small> <br>
                                            <small>Discount: ${{ $product->discount }}</small>
                                        </h4>
                                    </div>

                                    <div class="mt-4">
                                        <a href="{{ route('cart.access', $product->id) }} "
                                            class="btn btn-primary btn-lg btn-flat">
                                            <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                            Add to Cart
                                        </a>

                                        <div class="btn btn-default btn-lg btn-flat">
                                            <i class="fas fa-heart fa-lg mr-2"></i>
                                            Add to Wishlist
                                        </div>
                                    </div>

                                    <div class="mt-4 product-share">
                                        <a href="#" class="text-gray"><i
                                                class="fab fa-facebook-square fa-2x"></i></a>
                                        <a href="#" class="text-gray"><i
                                                class="fab fa-twitter-square fa-2x"></i></a>
                                        <a href="#" class="text-gray"><i
                                                class="fas fa-envelope-square fa-2x"></i></a>
                                        <a href="#" class="text-gray"><i class="fas fa-rss-square fa-2x"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabs -->
                            <div class="row mt-4">
                                <nav class="w-100">
                                    <div class="nav nav-tabs" id="product-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab"
                                            href="#product-desc" role="tab" aria-controls="product-desc"
                                            aria-selected="true">Description</a>
                                        <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab"
                                            href="#product-comments" role="tab" aria-controls="product-comments"
                                            aria-selected="false">Comments</a>
                                        <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab"
                                            href="#product-rating" role="tab" aria-controls="product-rating"
                                            aria-selected="false">Rating</a>
                                    </div>
                                </nav>

                                <div class="tab-content p-3" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                                        aria-labelledby="product-desc-tab">
                                        {{ $product->description }}
                                    </div>
                                    <div class="tab-pane fade" id="product-comments" role="tabpanel"
                                        aria-labelledby="product-comments-tab">
                                        {{ $product->comments ?? 'No comments yet.' }}
                                    </div>
                                    <div class="tab-pane fade" id="product-rating" role="tabpanel"
                                        aria-labelledby="product-rating-tab">
                                        {{ $product->rating ?? 'No ratings yet.' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.1.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin2/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin2/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin2/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('admin2/dist/js/demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img');
                $('.product-image').prop('src', $image_element.attr('src'));
                $('.product-image-thumb.active').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>



    <script>
        let variants = @json($product->productVariant);
        let selected = {};

        $('.option-btn').click(function() {

            let type = $(this).data('type');
            let value = $(this).data('value');

            selected[type] = value;

            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            matchVariant();
        });

        function matchVariant() {

            for (let variant of variants) {

                let match = true;

                for (let attr of variant.attributes) {

                    let name = attr.attribute_value.attribute.name;
                    let value = attr.attribute_value.value;

                    if (selected[name] && selected[name] != value) {
                        match = false;
                    }
                }

                if (match) {
                    $('#price').text('$' + variant.price);
                    $('#addToCart').attr('href', '/cart-access/' + variant.id);
                    return;
                }
            }
        }
    </script>
</body>

</html>
