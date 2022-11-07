@extends('layouts.dashboard')
@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Role</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.update', $role->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value=" {{old('name',$role->name) }}"
                                    class="form-control">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <fieldset>
                                    <legend>Abilities</legend>
                                    @foreach (config('abilities') as $code=>$ability)
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                {{ $ability }}
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $code }}]" value="allow" @checked(($role_abilities[$code] ?? '')==='allow' )> Allow
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $code }}]" value="deny"  @checked(($role_abilities[$code] ?? '')==='deny' )> Deny
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $code }}]" value="inherit"  @checked(($role_abilities[$code] ?? '')==='inherit' )> Inherit
                                            </div>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
