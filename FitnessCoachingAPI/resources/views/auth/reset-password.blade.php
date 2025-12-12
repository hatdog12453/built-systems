@extends('layouts.app')

@section('title', 'Reset Password - Fitness Coaching')

@section('content')
<div
    id="reset-password-form-root"
    data-csrf-token="{{ csrf_token() }}"
    data-submit-url="{{ route('password.reset') }}"
    data-login-url="{{ route('login') }}"
    data-email="{{ $email ?? '' }}"
    data-error-message="{{ $errors->first() }}"
></div>
@endsection

