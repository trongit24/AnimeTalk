@extends('layouts.app')

@section('title', 'Forgot Password - AnimeTalk')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Forgot Password?</h1>
            <p>No problem! Just enter your email and we'll send you a reset link.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-primary btn-block">Send Reset Link</button>

            <div class="auth-footer">
                <p>Remember your password? <a href="{{ route('login') }}" class="link-primary">Login</a></p>
            </div>
        </form>
    </div>
</div>

<style>
.auth-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.auth-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    padding: 3rem;
    width: 100%;
    max-width: 450px;
    border: 2px solid var(--primary-purple);
}

.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-header h1 {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-purple), var(--primary-pink));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.auth-header p {
    color: var(--text-secondary);
    font-size: 0.95rem;
}

.auth-form .form-group {
    margin-bottom: 1.5rem;
}

.auth-form label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-weight: 500;
    font-size: 0.95rem;
}

.auth-form input[type="email"] {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e0e0e0;
    border-radius: var(--border-radius-sm);
    font-size: 1rem;
    transition: all 0.3s ease;
}

.auth-form input:focus {
    outline: none;
    border-color: var(--primary-purple);
    box-shadow: 0 0 0 3px rgba(168, 179, 232, 0.1);
}

.btn-block {
    width: 100%;
    padding: 1rem;
    font-size: 1.05rem;
    font-weight: 600;
}

.auth-footer {
    margin-top: 2rem;
    text-align: center;
}

.auth-footer p {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.auth-footer .link-primary {
    color: var(--primary-purple);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.auth-footer .link-primary:hover {
    color: var(--primary-pink);
}

.error-message {
    display: block;
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.alert {
    padding: 1rem;
    border-radius: var(--border-radius-sm);
    margin-bottom: 1.5rem;
}

.alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
}
</style>
@endsection
