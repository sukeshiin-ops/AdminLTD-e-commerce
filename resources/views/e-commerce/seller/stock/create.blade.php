{{-- @extends('admin.layout.master') --}}

@extends('e-commerce.seller.master')

<script src="{{ asset('admin2/plugins/jquery/jquery.min.js') }}"></script>

@php
    use App\Models\Attribute;
    $colors = Attribute::where('type', 1)->with('AttributeValue')->first();

@endphp

{{-- <pre>{{ $colors->toJson(JSON_PRETTY_PRINT) }}</pre>

@php
    dd(1)
@endphp --}}

@section('add-seller-product-content')

    <head>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <div class="container-fluid mt-3">

        <div class="card shadow border-0">



            <div class="card shadow border-0">

                <!-- Header -->
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background:#2C3046;">
                    <h5 class="mb-0"><i class="fa fa-plus"></i> Add Product</h5>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ implode('', $errors->all(':message ')) }}
                        </div>
                    @endif

                    <form action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- BASIC INFO -->
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Product Name</label>
                                <input type="text" name="product_name" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" name="quantity" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Product Image</label>
                                <input type="file" name="product_image" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Short Description</label>
                                <textarea name="small_description" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>

                        </div>

                        <hr class="my-4">

                        <!-- PRICE + STOCK -->
                        <h5 class="mb-3 fw-bold"><strong>Product Variation Configuration</strong></h5>

                        <div class="row g-3">


                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Colors</label>
                                <select name="colors[]" id="colors" class="form-control select2" multiple>
                                    @foreach ($colors->AttributeValue as $color)
                                        <option value="{{ $color->id }}">{{ $color->value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Attributes</label>
                                <select name="attributes[]" id="attributes" class="form-control select2" multiple>
                                    {{-- @foreach ($attributes as $attr)
                                        <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                                    @endforeach --}}

                                    @foreach ($attributes->where('type', '!=', 1) as $attr)
                                        <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                                    @endforeach
                                </select>
                            </div>




                        </div>

                        <!-- Dynamic Attribute Values -->
                        <div id="attribute-values-area" class="row g-3 mt-2"></div>

                        <hr class="my-4">


                        <div id="variant-area" class="mt-4"></div>




                        <!-- PRICE -->
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Unit Price *</label>
                                <input type="number" name="unit_price" class="form-control" value="0.00">
                            </div>


                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tax</label>
                                <input type="number" name="tax" class="form-control" value="0.00">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Discount</label>
                                <input type="number" name="discount" class="form-control" value="0.00">
                            </div>

                        </div>

                        <div class="text-end mt-4">
                            <button class="btn btn-success px-4">
                                <i class="fa fa-save"></i> Save Product
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>




    <script>
        $(document).ready(function() {

            initEvents();

            function initEvents() {
                $('#colors').on('change', generateVariants);
                $(document).on('change', '.dynamic-select2', generateVariants);
            }

            //  Get selected colors
            function getSelectedColors() {
                return $('#colors option:selected').map(function() {
                    return {
                        id: $(this).val(),
                        name: $(this).text()
                    };
                }).get();
            }

            //  Get selected attribute values
            function getSelectedAttributes() {
                let attributes = [];

                $('.dynamic-select2').each(function() {

                    let values = $(this).find('option:selected').map(function() {
                        return $(this).text();
                    }).get();

                    if (values.length > 0) {
                        attributes.push(values);
                    }
                });

                return attributes;
            }

            //  Generate combinations (recursive)
            function generateCombinations(arrays) {
                let result = [];

                function combine(arr, prefix = []) {
                    if (!arr.length) {
                        result.push(prefix);
                        return;
                    }

                    let first = arr[0];
                    let rest = arr.slice(1);

                    first.forEach(val => {
                        combine(rest, [...prefix, val]);
                    });
                }

                combine(arrays);
                return result;
            }

            //  Build single row HTML
            function buildRow(index, color, combination = null) {

                let variantName = color.name;

                if (combination && combination.length > 0) {
                    variantName += ' - ' + combination.join(' - ');
                }

                return `
        <tr>
            <td>
                ${variantName}
                <input type="hidden" name="variants[${index}][color_id]" value="${color.id}">
                <input type="hidden" name="variants[${index}][variant]" value="${variantName}">
            </td>

            <td><input type="number" name="variants[${index}][price]" class="form-control"></td>
            <td><input type="text" value="${variantName.toLowerCase()}" name="variants[${index}][sku]" class="form-control"></td>
            <td><input type="number" name="variants[${index}][qty]" class="form-control"></td>
            <td><input type="file" name="variants[${index}][image]" class="form-control"></td>
        </tr>
        `;
            }

            //  Build full table
            function buildTable(colors, combinations) {

                let html = `
        <h5 class="fw-bold mb-3">Variants</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Variant</th>
                    <th>Price</th>
                    <th>SKU</th>
                    <th>Qty</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
        `;

                let index = 0;

                colors.forEach(color => {

                    if (combinations.length > 0) {

                        combinations.forEach(combo => {
                            html += buildRow(index, color, combo);
                            index++;
                        });

                    } else {

                        html += buildRow(index, color);
                        index++;
                    }

                });

                html += `</tbody></table>`;

                return html;
            }

            //  MAIN FUNCTION
            function generateVariants() {

                let colors = getSelectedColors();
                let attributes = getSelectedAttributes();
                let combinations = generateCombinations(attributes);

                let html = '';

                if (colors.length > 0) {
                    html = buildTable(colors, combinations);
                }

                $('#variant-area').html(html);
            }

        });
    </script>
@endsection

<script>
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: "Select options",
            allowClear: true,
            width: '100%'
        });

        $('#attributes').on('change', function() {

            let selectedAttributes = $(this).val();

            $('#attribute-values-area').html('');

            if (selectedAttributes && selectedAttributes.length > 0) {

                $.ajax({
                    url: "{{ route('get.attribute.values') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        attribute_ids: selectedAttributes
                    },


                    success: function(response) {

                        let html = '';

                        response.forEach(function(attr) {

                            html += `
            <div class="mb-3">
                <label class="form-label fw-semibold">${attr.name}</label>
                <select name="attribute_values[${attr.id}][]"
                        class="form-control dynamic-select2" multiple>
        `;

                            attr.values.forEach(function(val) {
                                html +=
                                    `<option value="${val.id}">${val.value}</option>`;
                            });

                            html += `</select></div>`;
                        });

                        $('#attribute-values-area').html(html);

                        // 🔥 IMPORTANT
                        $('.dynamic-select2').select2({
                            placeholder: "Select " + "value",
                            allowClear: true,
                            width: '100%'
                        });

                        generateVariants();
                    }


                });

            }

        });

    });
</script>























{{-- @extends('e-commerce.seller.master')

@php
    use App\Models\Product;
    use App\Models\Category;
    $products = Product::get();
    $category = Category::get();

@endphp

@section('product-content')
    <div class="container mt-4">

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5><i class="fa fa-plus"></i> &nbsp; Add Product </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('seller.stock.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Product Name</label>
                            <input type="text" name="product_name" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}"> {{ $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tax</label>
                            <input type="text" name="tax" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3" >
                            <label>Product Image</label>

                            <input type="file" name="product_image" class="form-control " accept="image/*"
                                onchange="showImage(event)">


                            <div class="mt-3">
                                <img id="previewImage" style="height:100px; display:none;">
                            </div>
                        </div>





                        <div class="col-md-12 mb-3">
                            <label>Short Description</label>
                            <input type="text" name="short" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <textarea name="desc" class="form-control"></textarea>
                        </div>

                    </div>

                    <button class="btn btn-success">Save</button>
                </form>

            </div>
        </div>
    </div>



    <script>
        function showImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewImage');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }
    </script>
@endsection






 --}}
