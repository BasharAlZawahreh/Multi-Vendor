@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="left mb-5">
            @can('categories.create')
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Create</a>
            @endcan
            <a href="{{ route('cat.trashed') }}" class="btn btn-outline-dark">Trashed</a>
        </div>

        <form action="{{ URL::current() }}" method="get" class="d-flex jsutify-content-between mb-4">
            <input type="text" placeholder="name" name="name" class="form-control mx-2" value="{{request('name')}}">
            <select name="status" id="status" class="form-control mx-2">
                <option value="">All</option>
                <option value="active" @selected(request('status')=='active')>active</option>
                <option value="inactive" @selected(request('status')=='inactive')>inactive</option>
            </select>
            <button type="submit">Filter</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Parent</th>
                    <th scope="col">Products #</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($categories as $category)
                        <td scope="col">{{ $category->id }}</td>
                        <td scope="col">
                            <a href="{{route('categories.show',$category->id)}}">
                                {{ $category->name }}
                            </a>
                        </td>
                        <td scope="col">{{ $category->parento->name }}</td>
                        <td scope="col">{{ $category->products_count }}</td>
                        <td scope="col">{{ $category->status }}</td>
                        <td scope="col">{{ $category->created_at }}</td>
                        @can('categories.update')
                         <td scope="col">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                                Edit
                            </a>
                        </td>
                        @endcan
                        @can('categories.delete')
                            <td scope="col">
                                <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>

                        @endcan
                </tr>
            @empty
                <td colspan="7" class="text-center">No categories found</td>
                @endforelse
            </tbody>
        </table>
        {{ $categories->withQueryString()->links() }}
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
