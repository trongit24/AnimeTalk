@extends('layouts.app')

@section('title', 'Forgot Password - AnimeTalk')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="{{ asset('storage/image_4k/logo.jpg') }}" alt="AnimeTalk Logo">
            </div>
            <h1>Forgot Password?</h1>
            <p>No problem! Just enter your email and we'll send you a reset link.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    Email Address
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="your.email@example.com" required autofocus>
                @error('email')
                    <span class="error-message">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-primary btn-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
                Send Reset Link
            </button>

            <div class="auth-footer">
                <a href="{{ route('login') }}" class="link-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Login
                </a>
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
    background: url('{{ asset('storage/image_4k/pexels-padrinan-19670.jpg') }}') center/cover;
    position: relative;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    padding: 3rem;
    width: 100%;
    max-width: 500px;
    border: 3px solid transparent;
    background-clip: padding-box;
    overflow: hidden;
}

.auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(168, 179, 232, 0.95), rgba(255, 111, 199, 0.85));
    backdrop-filter: blur(10px);
    border-radius: 20px;
    z-index: 0;
}

.auth-card::after {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(135deg, var(--primary-purple), var(--primary-pink));
    border-radius: 20px;
    z-index: -1;
}

.auth-card > * {
    position: relative;
    z-index: 1;
}

.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-logo {
    margin-bottom: 1.5rem;
}

.auth-logo img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    margin: 0 auto;
    display: block;
    border: 4px solid white;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.auth-header h1 {
    font-size: 2.2rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.auth-header p {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1rem;
    font-weight: 500;
}

.auth-form .form-group {
    margin-bottom: 1.5rem;
}

.auth-form label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
}

.auth-form label svg {
    opacity: 0.9;
}

.auth-form input[type="email"] {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.95);
    color: var(--text-primary);
}

.auth-form input::placeholder {
    color: rgba(0, 0, 0, 0.4);
}

.auth-form input:focus {
    outline: none;
    border-color: white;
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
    background: white;
}

.btn-block {
    width: 100%;
    padding: 1rem;
    font-size: 1.1rem;
    font-weight: 700;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary.btn-block {
    background: linear-gradient(135deg, var(--primary-purple), var(--primary-pink));
    border: 2px solid white;
    color: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-primary.btn-block:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.auth-footer {
    margin-top: 2rem;
    text-align: center;
}

.link-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
}

.link-back:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-3px);
}

.error-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #fca5a5;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    background: rgba(239, 68, 68, 0.1);
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.alert {
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: rgba(16, 185, 129, 0.95);
    color: white;
    border: 2px solid #10b981;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

@media (max-width: 768px) {
    .auth-card {
        padding: 2rem 1.5rem;
    }
    
    .auth-header h1 {
        font-size: 1.8rem;
    }
    
    .auth-logo img {
        width: 100px;
        height: 100px;
    }
}
</style>
@endsection
