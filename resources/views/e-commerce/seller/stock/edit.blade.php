@extends('e-commerce.seller.master')

@section('stock-content')
    <div class="container mt-4">

        <div class="card shadow">

            @if (session('success'))
                <div id="successAlert" class="alert alert-success alert-dismissible fade show shadow-sm mt-3" role="alert"
                    style="transition: all 0.5s ease;">

                    <strong>Success!</strong> {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('successAlert');
                        if (alert) {
                            alert.classList.remove('show'); // fade out
                            alert.classList.add('fade');

                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 2000); // ⏱️ 2 seconds
                </script>
            @endif


            <h5>
                Product: <strong>{{ $product->product_name }}</strong>
            </h5>

            <form action="{{ route('seller.stock.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- VARIANT SELECT -->
                <select name="variant_id" class="form-control mb-3" required>
                    <option value="">Select Variant</option>

                    @foreach ($product->variants as $variant)
                        <option value="{{ $variant->id }}">
                            {{ $variant->variant }} (Stock: {{ $variant->inventory->quantity ?? 0 }})
                        </option>
                    @endforeach
                </select>

                <!-- STOCK INPUT -->
                <input type="number" name="new_stock" class="form-control mb-3" placeholder="Add Stock" required>

                <button class="btn btn-success">Update Stock</button>
            </form>

            <hr>


            <hr>

            <h4>Stock History (Variant-wise)</h4>

            @foreach ($product->variants as $variant)
                <h5 class="mt-3">
                    Variant: <strong class="text-warning">{{ $variant->variant }}</strong>
                </h5>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Added</th>
                            <th>Old</th>
                            <th>New Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($variant->histories as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d M Y H:i') }}</td>
                                <td class="text-success">+{{ $history->added_stock }}</td>
                                <td>{{ $history->old_stock }}</td>
                                <td><strong>{{ $history->new_total }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No history</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
@endsection
