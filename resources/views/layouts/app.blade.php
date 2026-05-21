<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>{{ config('app.name', 'Church Management System') }} - @yield('title', 'Home')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --maroon: #6b0f1a;
            --maroon-dark: #4a0a12;
            --maroon-light: #8b1a2a;
            --gold: #c9a84c;
            --gold-light: #e2c97e;
            --gold-dark: #a07830;
            --cream: #fdf8f0;
        }

        body {
            background-color: var(--cream);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--maroon-dark), var(--maroon));
            border-bottom: 3px solid var(--gold);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 65px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .navbar-brand {
            color: var(--gold);
            font-size: 1.3rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: 0.5px;
        }

        .navbar-brand span {
            color: white;
            font-weight: 400;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar-links a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 0.45rem 0.85rem;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .navbar-links a:hover {
            background: rgba(201,168,76,0.2);
            color: var(--gold-light);
        }

        .navbar-links a.active {
            background: var(--gold);
            color: var(--maroon-dark);
            font-weight: 600;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-user {
            color: rgba(255,255,255,0.85);
            font-size: 0.85rem;
        }

        .navbar-user strong {
            color: var(--gold-light);
        }

        .btn-logout {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: var(--gold);
            color: var(--maroon-dark);
        }

        .main-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gold);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-title {
            color: var(--maroon);
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: 1px solid rgba(201,168,76,0.2);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-light));
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn {
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--maroon);
            color: white;
        }

        .btn-primary:hover {
            background: var(--maroon-dark);
            color: white;
        }

        .btn-gold {
            background: var(--gold);
            color: var(--maroon-dark);
            font-weight: 600;
        }

        .btn-gold:hover {
            background: var(--gold-dark);
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #b02a37;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #565e64;
            color: white;
        }

        .btn-sm {
            padding: 0.3rem 0.75rem;
            font-size: 0.82rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.92rem;
        }

        .table th {
            background: var(--maroon);
            color: var(--gold-light);
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f0e8d8;
            vertical-align: middle;
        }

        .table tr:hover td {
            background: #fdf5e6;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--maroon);
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.55rem 0.9rem;
            border: 1px solid #d4c5a0;
            border-radius: 6px;
            font-size: 0.92rem;
            background: white;
            color: #333;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1rem;
        }

        .alert {
            padding: 0.85rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 1.2rem;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .badge {
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-gold {
            background: var(--gold-light);
            color: var(--maroon-dark);
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-left: 4px solid var(--gold);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--maroon), var(--maroon-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--maroon);
            margin: 0;
            line-height: 1;
        }

        .stat-info p {
            color: #888;
            font-size: 0.85rem;
            margin: 0.25rem 0 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.2rem;
            margin-bottom: 2rem;
        }

        .section-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        .role-badge {
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .role-admin {
            background: var(--gold-light);
            color: var(--maroon-dark);
        }

        .role-staff {
            background: #d1ecf1;
            color: #0c5460;
        }

        .role-member {
            background: #e2e3e5;
            color: #383d41;
        }

        .pagination-wrapper {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .section-grid { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; }
            .form-grid-3 { grid-template-columns: 1fr; }
            .navbar-links { display: none; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        Church Management System Draft
    </a>

    <ul class="navbar-links">
        <li>
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                Home
            </a>
        </li>
        @auth
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">
                Members
            </a>
        </li>
        <li>
            <a href="{{ route('tithes.index') }}" class="{{ request()->routeIs('tithes.*') ? 'active' : '' }}">
                Tithes
            </a>
        </li>
        @if(auth()->check() && auth()->user()->isAdmin())
        <li>
            <a href="{{ route('budget.index') }}" class="{{ request()->routeIs('budget.*') ? 'active' : '' }}">
                Budget
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">
                Events
            </a>
        </li>
        <li>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                Attendance
            </a>
        </li>
        @endauth
    </ul>

    <div class="navbar-right">
        @auth
            <span class="navbar-user">
                👤 <strong>{{ auth()->user()->name }}</strong>
                <span class="role-badge role-{{ auth()->user()->role }}">{{ auth()->user()->role }}</span>
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-gold btn-sm">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
        @endauth
    </div>
</nav>

<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert" style="background:#fff3cd; color:#856404; border:1px solid #ffeeba;">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('warning') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>