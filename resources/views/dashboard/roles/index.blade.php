@extends('layouts.dashboard')

@section('title', 'Roles')

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="left mb-5">
            {{-- @can('roles.create') --}}
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Create</a>
            {{-- @endcan --}}
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
                    <th scope="col">Created At</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @forelse ($roles as $role)
                        <td scope="col">{{ $role->id }}</td>
                        <td scope="col">
                            <a href="{{route('roles.show',$role->id)}}">
                                {{ $role->name }}
                            </a>
                        </td>
                        <td scope="col">{{ $role->name }}</td>
                        <td scope="col">{{ $role->created_at }}</td>
                        @can('roles.update')
                         <td scope="col">
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                                Edit
                            </a>
                        </td>
                        @endcan
                        @can('roles.delete')
                            <td scope="col">
                                <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>

                        @endcan
                </tr>
            @empty
                <td colspan="9" class="text-center">No roles found</td>
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
