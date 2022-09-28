@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="left">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Create</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">image</th>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Parent</th>
                    <th scope="col">Created At</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($categories as $category)
                        <td>
                            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" class="sm" >
                        </td>
                        <td scope="col">{{ $category->id }}</td>
                        <td scope="col">{{ $category->name }}</td>
                        <td scope="col">{{ $category->parent_id }}</td>
                        <td scope="col">{{ $category->created_at }}</td>
                        <td scope="col">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                                Edit
                            </a>
                        </td>
                        <td scope="col">
                            <form action="{{ route('categories.destroy', $category->id) }}" method="post">
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
