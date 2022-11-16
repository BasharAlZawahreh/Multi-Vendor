@extends('layouts.dashboard')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" @class(['form-control', 'is-invalid' => $errors->has('name')])
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <fieldset>
                                    <legend>Abilities</legend>
                                    @foreach (app('abilities') as $code=>$ability)
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                {{ $ability }}
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $code }}]" value="allow" checked> Allow
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $code }}]" value="deny"> Deny
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $code }}]" value="inherit"> Inherit
                                            </div>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
