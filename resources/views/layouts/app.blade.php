<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ParkEase - Nashik City Parking Finder & Pre-Booking System')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --bg-dark: #0b0f19;
            --bg-card: #131b2e;
            --bg-card-hover: #1c2742;
            --accent-green: #10b981;
            --accent-green-glow: rgba(16, 185, 129, 0.25);
            --accent-blue: #3b82f6;
            --accent-purple: #8b5cf6;
            --accent-red: #ef4444;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
            --glass-bg: rgba(19, 27, 46, 0.7);
            --glass-border: rgba(255, 255, 255, 0.12);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Outfit', sans-serif;
        }

        /* Glassmorphism Navigation */
        .navbar-custom {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--glass-border);
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff !important;
            letter-spacing: -0.5px;
        }

        .brand-badge {
            background: linear-gradient(135deg, var(--accent-green), #059669);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-left: 8px;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent-green) !important;
        }

        /* Custom Cards */
        .park-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .park-card:hover {
            transform: translateY(-5px);
            border-color: rgba(16, 185, 129, 0.4);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.15);
        }

        /* Custom Buttons */
        .btn-park-primary {
            background: linear-gradient(135deg, var(--accent-green), #059669);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            padding: 10px 24px;
            box-shadow: 0 4px 14px var(--accent-green-glow);
            transition: all 0.2s ease;
        }

        .btn-park-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            color: #fff;
        }

        .btn-park-outline {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-park-outline:hover {
            background: var(--bg-card-hover);
            border-color: var(--accent-green);
            color: var(--accent-green);
        }

        /* Badges */
        .badge-available {
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent-green);
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        .badge-occupied {
            background: rgba(239, 68, 68, 0.15);
            color: var(--accent-red);
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Hero Banner */
        .hero-banner {
            background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.12), transparent 40%),
                        radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.12), transparent 40%),
                        var(--bg-dark);
            padding: 48px 0 32px 0;
            border-bottom: 1px solid var(--border-color);
        }

        /* Slot Visualizer Grid */
        .slot-grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 14px;
            margin-top: 20px;
        }

        .slot-box {
            background: var(--bg-card);
            border: 2px solid #334155;
            border-radius: 12px;
            padding: 16px 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
        }

        .slot-box.available {
            border-color: var(--accent-green);
            background: rgba(16, 185, 129, 0.08);
        }

        .slot-box.available:hover {
            background: rgba(16, 185, 129, 0.2);
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.4);
        }

        .slot-box.occupied {
            border-color: var(--accent-red);
            background: rgba(239, 68, 68, 0.12);
            opacity: 0.65;
            cursor: not-allowed;
        }

        .slot-box.selected {
            border-color: var(--accent-blue) !important;
            background: rgba(59, 130, 246, 0.3) !important;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.6) !important;
            transform: scale(1.08);
        }

        .slot-number {
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
        }

        .slot-type-tag {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
            font-weight: 700;
        }

        /* Footer */
        footer {
            margin-top: auto;
            background: #070a10;
            border-top: 1px solid var(--border-color);
            padding: 24px 0;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Glassmorphism Header / Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('parking.index') }}">
                <i class="fa-solid fa-square-parking text-emerald me-2" style="color: var(--accent-green); font-size: 1.8rem;"></i>
                <span>ParkEase</span>
                <span class="brand-badge">Nashik City</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('parking.index') ? 'active' : '' }}" href="{{ route('parking.index') }}">
                            <i class="fa-solid fa-location-dot me-1"></i> Parking Hubs
                        </a>
                    </li>

                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('my.bookings') ? 'active' : '' }}" href="{{ route('my.bookings') }}">
                            <i class="fa-solid fa-ticket me-1"></i> My Bookings
                        </a>
                    </li>
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle text-white fw-semibold bg-dark px-3 py-1 rounded-pill border border-secondary" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-circle-user me-1 text-success"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('my.bookings') }}"><i class="fa-solid fa-list me-2"></i> My Parking History</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item ms-2">
                        <a href="{{ route('login') }}" class="btn btn-park-outline py-2 px-3">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Log In
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-park-primary text-white text-decoration-none py-2 px-3">
                            <i class="fa-solid fa-user-plus me-1"></i> Register
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start mb-2 mb-md-0">
                    <span class="fw-bold text-white"><i class="fa-solid fa-city text-success me-1"></i> ParkEase Nashik Smart Parking System</span>
                </div>
                <div class="col-md-6 text-md-end text-secondary small">
                    <i class="fa-solid fa-location-crosshairs text-primary me-1"></i> Real-Time Slot Availability & Pre-Booking Portal
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
