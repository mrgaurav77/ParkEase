@extends('layouts.app')

@section('title', 'Driver Login - ParkEase')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 p-4 p-md-5" style="background: var(--bg-card); border: 1px solid var(--glass-border) !important; border-radius: 24px;">
                <div class="text-center mb-4">
                    <div class="badge bg-success bg-opacity-20 text-success mb-2 px-3 py-2 border border-success border-opacity-30 rounded-pill">
                        <i class="fa-solid fa-user-lock me-1"></i> Driver Portal
                    </div>
                    <h3 class="fw-bold text-white mb-1">Welcome Back</h3>
                    <p class="text-secondary small">Log in to view and manage your parking bookings</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger border-0 bg-danger bg-opacity-20 text-danger rounded-3 p-3 mb-4 small">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-secondary border-secondary"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-dark text-white border-secondary" placeholder="driver@example.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-secondary border-secondary"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input bg-dark border-secondary" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-secondary small" for="remember">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-park-primary w-100 py-3 fw-bold mb-3">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Log In
                    </button>

                    <p class="text-center text-secondary small mb-0">
                        Don't have an account? <a href="{{ route('register') }}" class="text-success fw-semibold text-decoration-none">Register here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
