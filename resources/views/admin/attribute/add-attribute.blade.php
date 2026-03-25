@extends('admin.layout.master')

@php
    use App\Models\Attribute;
    $att = Attribute::with('AttributeValue')->get();
@endphp

@section('add-attribute-content')
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
                    <i class="fa-solid fa-boxes-stacked"></i> Attribute Information
                </h5>
            </div>


            <div class="card-body">

                <form action="{{ route('store.attribute.now') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Attribute Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>

                    <div id="attribute-values-wrapper">
                        <label class="form-label">Attribute Value</label>

                        <div class="input-group mb-2">
                            <input type="text" name="values[]" class="form-control" placeholder="Enter Attribute Value"
                                required>
                            <button type="button" class="btn btn-danger remove-field" style="display:none;">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>


                    <div class="mb-3">
                        <button type="button" id="add-more" class="btn btn-outline-secondary w-100">
                            + Add More
                        </button>
                    </div>


                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Save</button>
                    </div>
                </form>

            </div>
        </div>

    </div>



    <script>
        $(document).ready(function() {

            $('#add-more').click(function() {
                let field = `
                <div class="input-group mb-2">
                    <input type="text" name="values[]" class="form-control" placeholder="Enter Attribute Value" required>
                    <button type="button" class="btn btn-danger remove-field">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            `;
                $('#attribute-values-wrapper').append(field);
            });

            $(document).on('click', '.remove-field', function() {
                $(this).closest('.input-group').remove();
            });

        });
    </script>
@endsection
