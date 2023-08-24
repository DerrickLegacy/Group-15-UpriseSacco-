@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.member.update') }}">
                @csrf

                <div class="mb-3">
                    <label for="username" class="text-md-end">{{ __('Username') }}</label>

                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{old('username', $member->username)}}" required autocomplete="username"
                        autofocus>

                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="text-md-end">{{ __('Email Address') }}</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{old('email', $member->email)}}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="text-md-end">{{ __('Phone No') }}</label>

                    <input id="phone_number" type="phone_number"
                        class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" required
                        autocomplete="phone_number" value="{{old('phone_number', $member->phone_number)}}">

                    @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="text-md-end">{{ __('Password') }}</label>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password"
                        value="{{old('password', $member->password)}}">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password-confirm" class="text-md-end">{{ __('Confirm Password')
                        }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required autocomplete="new-password">

                </div>
                <div class="mb-0">
                    <button type="submit" class="btn btn-primary text-white">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection