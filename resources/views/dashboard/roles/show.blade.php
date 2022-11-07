@extends('layouts.dashboard')
@section('content')
    <div class="content-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">store</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody>
                
                @forelse ($products as $product)
                    <tr>
                        <td scope="col">{{ $product->name }}</td>
                        <td scope="col">{{ $product->store->name }}</td>
                        <td scope="col">{{ $product->status }}</td>
                        <td scope="col">{{ $product->created_at }}</td>
                    </tr>

                @empty
                    <p colspan="5">No products</p>
                @endforelse
        </table>

        {{ $products->withQueryString()->links() }}
    </div>
@endsection
