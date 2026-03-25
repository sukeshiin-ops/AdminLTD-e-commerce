@extends('admin.layout.master')

@php
    use App\Models\Attribute;
    $att = Attribute::where('type' , 2)->with('AttributeValue')->get();
    $att_value = Attribute::get();
    // $att_val = AttributeValue::get();
@endphp

@section('attribute-content')
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
                    <i class="fa-solid fa-boxes-stacked"></i> All Attribute
                </h5>

                <span class="badge bg-info fs-6">
                    Total : {{ count($att) }}
                </span>
            </div>

            <!-- Body -->
            <div class="card-body">

                <!-- Add Button -->
                <div class="mb-3">
                    <a href="{{ route('add.attribute.now') }}" class="btn btn-danger">
                        <i class="fa fa-plus"></i> Add Attribute
                    </a>

                    {{-- <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Edit-values
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach ($att_value as $value)
                                <li><a href="{{ route('edit-value.show', $value->id) }}"  class="dropdown-item" value="{{ $value->name }}" type="button">{{ $value->name }}</a></li>
                            @endforeach
                        </ul>

                    </div> --}}
                </div>

                <!-- Table -->
                <table id="productTable" class="table table-hover table-bordered align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>VALUES</th>
                            <th>CREATED</th>
                            <th>OPTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($att as $attribute)
                            <tr>

                                <td><strong>{{ $attribute->id }}</strong></td>


                                <td class=" fw-bold">
                                    {{ $attribute->name }}
                                </td>

                                <td>
                                    <span class="badge ">
                                        {{ $attribute->AttributeValue->pluck('value')->implode(', ') ?? 'N/A' }}
                                    </span>
                                </td>


                                {{-- <td>
                                    <span class="badge ">
                                        {{ $attribute->type ?? 'N/A' }}
                                    </span>
                                </td> --}}




                                <!-- Dates -->
                                <td>{{ $attribute->created_at->format('d M Y') }}</td>



                                <!-- Actions -->
                                <td>
                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- Edit -->
                                        <a href=" {{ route('update.page.attribute.now', $attribute->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>

                                        <!-- Delete -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $attribute->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{ $attribute->id }}" tabindex="-1">
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
                                                        {{ $attribute->value_name }}
                                                    </strong>
                                                </div>

                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>

                                                    <a href="{{ route('delete.attribute.now', $attribute->id) }}"
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
