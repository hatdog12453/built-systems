@extends('layouts.app')

@section('title', 'Forgot Password - Fitness Coaching')

@section('content')
<div
    id="forgot-password-form-root"
    data-csrf-token="{{ csrf_token() }}"
    data-submit-url="{{ route('password.forgot') }}"
    data-login-url="{{ route('login') }}"
    data-initial-email="{{ old('email') }}"
    data-initial-role="{{ old('role') }}"
    data-error-message="{{ $errors->first() }}"
></div>
@endsection

