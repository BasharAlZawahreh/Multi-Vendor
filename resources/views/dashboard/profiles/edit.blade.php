@extends('layouts.dashboard')
@section('content')

<div class="content-wrapper">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profiles.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name"
                                    value=" {{ old('first_name', $profile->first_name) }}" class="form-control">
                                @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name"
                                    value=" {{ old('last_name', $profile->last_name) }}" class="form-control">
                                @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="birth_date">Birthdate</label>
                                <input type="date" name="birth_date" id="birth_date"
                                    value="{{ date(old('birth_date', $profile->birth_date)) }}" class="form-control">
                                @error('birth_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div>
                                    <label for="gender">Gender</label> <br />
                                    <input type="radio" name="gender" id="gender" value="male"
                                        @checked(old('gender', $profile->gender) == 'male')>
                                    <label>Male</label>
                                </div>


                                <input type="radio" name="gender" id="gender" value="female" class="form-control"
                                    @checked(old('gender', $profile->gender) == 'female')>

                                <label>Female</label>

                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">address</label>

                                <textarea name="address" id="address" class="form-control">{{ old('address', $profile->address) }}</textarea>
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>

                                <select name="country" id="country" class="form-control">
                                    @foreach ($countries as $key => $country)
                                        <option @selected(old('country', $profile->country) == $key) value="{{ $key }}">
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>

                                <input name="city" id="city" class="form-control"
                                    value="{{ old('city', $profile->city) }}">

                                @error('city')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="locale">locale</label>

                                <select name="locale" id="locale" class="form-control">
                                    @foreach ($locales as $key => $locale)
                                        {{ old('locale', $profile->locale) }}
                                        <option @selected(old('locale', $profile->locale) == $key) value="{{ $key }}">
                                            {{ $locale }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('locale')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
