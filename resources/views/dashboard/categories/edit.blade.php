@extends('layouts.dashboard')
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value=" {{old('name',$category->name) }}"
                                    class="form-control">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" name="description" id="description" class="form-control">{{old('description',$category->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control">

                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="" width="100px">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option @selected(old('status',$category->status) === 'active') value="active">Active</option>
                                    <option @selected(old('status',$category->status) === 'inactive') value="inactive">Inactive</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Parent</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">Select Parent</option>
                                    @foreach ($categories as $cat)
                                        <option @selected(old('parent_id',$category->parent_id) == $cat->id) value="{{ $cat->id }}">
                                            {{ $cat->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
