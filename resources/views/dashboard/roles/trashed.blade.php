@extends('layouts.dashboard')

@section('title', 'Trashed Categories')

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item ">Categories</li>
    <li class="breadcrumb-item active">Trash</li>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="left">
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Create</a>
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
                    <th scope="col">Status</th>
                    <th scope="col">Deleted At</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($categories as $category)
                        <td>
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="sm">
                        </td>
                        <td scope="col">{{ $category->id }}</td>
                        <td scope="col">{{ $category->name }}</td>
                        <td scope="col">{{ $category->status }}</td>
                        <td scope="col">{{ $category->deleted_at }}</td>
                        <td scope="col">
                            <form action="{{ route('cat.restore', $category->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                <button class="btn btn-primary">
                                    restore
                                </button>
                            </form>
                        </td>
                        <td scope="col">
                            <form action="{{ route('cat.hard_delete', $category->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
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
