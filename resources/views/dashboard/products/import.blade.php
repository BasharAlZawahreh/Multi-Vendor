@extends('layouts.dashboard')
@section('content')
<div class="content-wrapper">

    <form action="{{route('products.import')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="count">Count</label>
            <input type="text" name="count" id="count" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
</div>

@endsection
