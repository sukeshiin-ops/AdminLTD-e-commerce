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
                                    $productColors = collect();
                                    $productSizes = collect();

                                    foreach ($product->productVariant as $variant) {
                                        foreach ($variant->attributes as $attr) {
                                            // Color (type = 1)
                                            if (
                                                $attr->attributeValue &&
                                                $attr->attributeValue->attribute &&
                                                $attr->attributeValue->attribute->type == 1
                                            ) {
                                                $productColors->push($attr->attributeValue);
                                            }

                                            // Size (type = 2)
                                            if (
                                                $attr->attributeValue &&
                                                $attr->attributeValue->attribute &&
                                                $attr->attributeValue->attribute->type == 2
                                            ) {
                                                $productSizes->push($attr->attributeValue);
                                            }
                                        }
                                    }

                                    $productColors = $productColors->unique('id');
                                    $productSizes = $productSizes->unique('id');
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
                                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                                        @foreach ($productColors as $c)
                                            <label class="btn btn-default text-center m-1 option-btn" data-type="color"
                                                data-value="{{ $c->value }}">
                                                <input type="radio" name="color_option" autocomplete="off">
                                                {{ $c->value }}
                                                <br>
                                                <i class="fas fa-circle fa-2x"
                                                    style="color: {{ strtolower($c->value) }};"></i>
                                            </label>
                                        @endforeach
                                    </div>

                                    <h4 class="mt-3">Available Sizes</h4>
                                    <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                                        @foreach ($productSizes as $s)
                                            <label class="btn btn-outline-secondary option-btn m-1" data-type="size"
                                                data-value="{{ $s->value }}" style="min-width:25px;">
                                                <input type="radio" name="size_option" autocomplete="off">
                                                {{ $s->value }}
                                            </label>
                                        @endforeach
                                    </div>



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
                                        <h2 id="price" class="mb-0">$0</h2>
                                        <h4 class="mt-0">
                                            <small id="exTax">Ex Tax: $0</small> <br>
                                            <small id="discount">Discount: $0</small>
                                        </h4>


                                        {{-- <h5 id="stockText" class="mt-2 text-success">In Stock</h5> --}}

                                    </div>


                                    <div class="mt-4">
                                        <a href="#" id="addToCart" class="btn btn-primary btn-lg btn-flat">
                                            <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                            Add to Cart
                                        </a>
                                        {{-- <a href="#" id="addToCart" class="btn btn-primary btn-lg btn-flat"></a> --}}
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

        $(document).ready(function() {

            // First color select
            let firstColor = $('.option-btn[data-type="color"]').first();
            if (firstColor.length) {
                firstColor.addClass('active');
                selected['color'] = firstColor.data('value');
            }

            // First size select
            let firstSize = $('.option-btn[data-type="size"]').first();
            if (firstSize.length) {
                firstSize.addClass('active');
                selected['size'] = firstSize.data('value');
            }

            // Load default price
            matchVariant();
        });

        // Click handler for color & size
        $('.option-btn').click(function() {
            let type = $(this).data('type');
            let value = $(this).data('value');

            selected[type] = value;

            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            matchVariant();
        });



        function matchVariant() {



            //  Check: dono select hue kya?
            if (!selected['color'] || !selected['size']) {
                return; // kuch mat kar
            }

            for (let variant of variants) {

                let colorMatch = false;
                let sizeMatch = false;

                for (let attr of variant.attributes) {

                    let attrType = attr.attribute_value.attribute.type;
                    let value = attr.attribute_value.value;

                    if (attrType == 1 && selected['color'] == value) {
                        colorMatch = true;
                    }

                    if (attrType == 2 && selected['size'] == value) {
                        sizeMatch = true;
                    }
                }

                //FULL MATCH (color + size both)
                if (colorMatch && sizeMatch) {

                    // $('#price').text('$' + variant.price);

                    let basePrice = parseFloat(variant.price) || 0;
                    let tax = parseFloat(variant.tax) || 0;
                    let discount = parseFloat(variant.discount) || 0;

                    // Final calculation
                    let finalPrice = basePrice + tax - discount;

                    // UI update
                    $('#price').text('$' + finalPrice.toFixed(2));
                    $('#exTax').text('Ex Tax: $' + basePrice.toFixed(2));
                    $('#discount').text('Discount: $' + discount.toFixed(2));

                    // image bhi change karna hai to
                    if (variant.image) {
                        $('.product-image').attr('src', '/' + variant.image);
                    }

                    $('#addToCart').attr('href', '/cart-access/' + variant.id);

                    return;
                }
            }

            //  agar koi exact match nahi mila
            $('#price').text('Not Available');
        }
    </script>
</body>

</html>
