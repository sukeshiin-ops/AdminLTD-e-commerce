@extends('admin.layout.master')

@php
    use App\Models\Attribute;
    $att = Attribute::with('AttributeValue')->first();

@endphp

@section('edit-attribute-content')
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
                    <i class="fa-solid fa-boxes-stacked"></i> Edit Attribute
                </h5>

            </div>

            <!-- Body -->
            <div class="card-body">

                <form action="{{ route('update.attribute.now', $alldata->id) }}" method="POST" class="w-100">
                    @csrf


                    <div class="mb-3 my-2">
                        <label class="form-label text-success"><strong>Attribute Name</strong></label>
                        <input type="text" name="name" value="{{ $alldata->name }}" class="form-control"
                            placeholder="Enter Attribute Name" required>
                    </div>



                    <div id="attribute-wrapper">

                        @foreach ($alldata->AttributeValue as $val)
                            <div class="d-flex mb-2 align-items-center">
                                <input type="text" name="value[]" value="{{ $val->value }}" class="form-control me-2">


                                <a href="{{ route('delete.attribute.now', $val->id) }}" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        @endforeach

                    </div>


                    <script>
                        function addField() {
                            let html = ` <input type="text" name="value[]" class="form-control mb-2" placeholder="Enter Attribute Value"> `;
                            document.getElementById('attribute-wrapper').insertAdjacentHTML('beforeend', html);
                        }
                    </script>

                    <!-- Save Button -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger w-5">
                            <i class="fa fa-save"></i> Update
                        </button>

                        <button type="submit" class="btn btn-warning w-5">
                            <i class="fa fa-plus"></i> Add More
                        </button>

                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection



<script>
    $(document).ready(function() {


        $(document).on('click', '.remove-field', function() {
            $(this).closest('div').remove();
        });


        $(document).on('click', '.delete-value', function() {
            let id = $(this).data('id');

            if (confirm('Are you sure you want to delete this value?')) {
                window.location.href = "/delete-attribute-value/" + id;
            }
        });

    });
</script>
