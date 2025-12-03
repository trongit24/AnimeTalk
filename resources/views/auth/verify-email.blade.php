@extends('layouts.app')

@section('title', 'Verify Email - AnimeTalk')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Verify Your Email</h1>
            <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Resend Verification Email</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link">Log Out</button>
            </form>
        </div>
    </div>
</div>
@endsection
