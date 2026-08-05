@extends('layouts.app')

@section('title', 'Driver Registration - ParkEase')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 p-4 p-md-5" style="background: var(--bg-card); border: 1px solid var(--glass-border) !important; border-radius: 24px;">
                <div class="text-center mb-4">
                    <div class="badge bg-success bg-opacity-20 text-success mb-2 px-3 py-2 border border-success border-opacity-30 rounded-pill">
                        <i class="fa-solid fa-user-plus me-1"></i> New Driver Account
                    </div>
                    <h3 class="fw-bold text-white mb-1">Create Account</h3>
                    <p class="text-secondary small">Register to track and manage your city parking reservations</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger border-0 bg-danger bg-opacity-20 text-danger rounded-3 p-3 mb-4 small">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-secondary border-secondary"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="name" class="form-control bg-dark text-white border-secondary" placeholder="Rahul Sharma" value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-secondary border-secondary"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-dark text-white border-secondary" placeholder="driver@example.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-secondary border-secondary"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="Minimum 6 characters" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-semibold">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-secondary border-secondary"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-secondary" placeholder="Repeat password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-park-primary w-100 py-3 fw-bold mb-3">
                        <i class="fa-solid fa-user-check me-2"></i> Register Account
                    </button>

                    <p class="text-center text-secondary small mb-0">
                        Already have an account? <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">Log in here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
