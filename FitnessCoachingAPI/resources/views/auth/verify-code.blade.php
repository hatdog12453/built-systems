@extends('layouts.app')

@section('title', 'Verify Code - Fitness Coaching')

@section('content')
<div
    id="verify-code-form-root"
    data-csrf-token="{{ csrf_token() }}"
    data-submit-url="{{ route('password.verify-code') }}"
    data-forgot-password-url="{{ route('password.forgot') }}"
    data-email="{{ $email ?? '' }}"
    data-error-message="{{ $errors->first() }}"
    data-success-message="{{ session('success') }}"
></div>
@endsection

