@extends('layouts.dashboard')
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Product</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', $product->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name"
                                    value=" {{ old('name', $product->name) }}" class="form-control">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price"
                                    value=" {{ old('price', $product->price) }}" class="form-control">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="compare_price">Compare Price</label>
                                <input type="text" name="compare_price" id="compare_price"
                                    value=" {{ old('compare_price', $product->compare_price) }}" class="form-control">
                                @error('compare_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <input type="text" name="tags" id="tags" class="form-control"
                                    value="{{ old('tags', implode(',', $tags)) }}">
                                @error('tags')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control">

                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" width="100px">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option @selected(old('status', $product->status) === 'active') value="active">Active</option>
                                    <option @selected(old('status', $product->status) === 'draft') value="draft">Draft</option>
                                    <option @selected(old('status', $product->status) === 'archived') value="archived">Archived</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Parent</option>
                                    @foreach ($categories as $cat)
                                        <option @selected(old('category_id', $product->category_id) == $cat->id) value="{{ $cat->id }}">
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

@push('scripts')
    <script>
        var inputElm = document.querySelector("#tags"),
            tagify = new Tagify(inputElm);
    </script>
@endpush
