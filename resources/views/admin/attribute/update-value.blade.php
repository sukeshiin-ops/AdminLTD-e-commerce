@extends('admin.layout.master')

@php
    use App\Models\Attribute;
    $att = Attribute::with('AttributeValue')->get();
@endphp

@section('update-value-content')
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
                    <i class="fa-solid fa-pencil"></i></i> Edit Value
                </h5>
            </div>


            <div class="card-body">

                <form action="{{ route('edit-value.update', $val->id) }}" method="POST">
                    @csrf
                    @method('PATCH') <!-- Important! Browser ko POST, Laravel ko PATCH bata raha hai -->

                    <input type="text" name="value" value="{{ $val->value }}" class="form-control" required>

                    <button type="submit" class="btn btn-success mt-2">Update</button>
                </form>

            </div>
        </div>

    </div>
@endsection
