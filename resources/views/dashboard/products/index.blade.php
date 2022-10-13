@extends('layouts.dashboard')

@section('title', 'products')

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item active">products</li>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="left mb-5">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Create</a>
        </div>

        <form action="{{ URL::current() }}" method="get" class="d-flex jsutify-content-between mb-4">
            <input type="text" placeholder="name" name="name" class="form-control mx-2" value="{{request('name')}}">
            <select name="status" id="status" class="form-control mx-2">
                <option value="">All</option>
                <option value="active" @selected(request('status')=='active')>active</option>
                <option value="draft" @selected(request('status')=='draft')>draft</option>
                <option value="archived" @selected(request('status')=='archived')>archived</option>
            </select>
            <button type="submit">Filter</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Store</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($products as $product)
                        <td scope="col">{{ $product->id }}</td>
                        <td scope="col">{{ $product->category->name }}</td>
                        <td scope="col">{{ $product->store->name }}</td>
                        <td scope="col">{{ $product->name }}</td>
                        <td scope="col">{{ $product->status }}</td>
                        <td scope="col">{{ $product->created_at }}</td>
                        <td scope="col">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                                Edit
                            </a>
                        </td>
                        <td scope="col">
                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                </tr>
            @empty
                <td colspan="7" class="text-center">No products found</td>
                @endforelse
            </tbody>
        </table>
        {{ $products->withQueryString()->links() }}
    </div>
@endsection

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
