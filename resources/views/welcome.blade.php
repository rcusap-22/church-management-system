@extends('layouts.app')
@section('title', 'Welcome')

@section('content')
<div style="text-align:center; padding: 4rem 2rem;">

    <div style="
        width: 80px; height: 80px;
        background: linear-gradient(135deg, var(--maroon-dark), var(--maroon));
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 25px rgba(107,15,26,0.3);
        border: 2px solid var(--gold);
    ">
        <i class="fa-solid fa-cross" style="font-size:2rem; color:var(--gold);"></i>
    </div>

    <h1 style="color: var(--maroon); font-size:2.5rem; font-weight:800; margin-bottom:0.5rem;">
        Church Management System
    </h1>
    <p style="color:#888; font-size:1.1rem; max-width:500px; margin:0 auto 2rem;">
        Manage your church members, tithes, events, and attendance all in one place.
    </p>

    @guest
    <div style="display:flex; gap:1rem; justify-content:center;">
        <a href="{{ route('login') }}" class="btn btn-gold" style="font-size:1rem; padding:0.75rem 2rem;">
            <i class="fa-solid fa-right-to-bracket"></i> Login
        </a>
        <a href="{{ route('register') }}" class="btn btn-primary" style="font-size:1rem; padding:0.75rem 2rem;">
            <i class="fa-solid fa-user-plus"></i> Register
        </a>
    </div>
    @else
    <a href="{{ route('dashboard') }}" class="btn btn-gold" style="font-size:1rem; padding:0.75rem 2rem;">
        <i class="fa-solid fa-chart-line"></i> Go to Dashboard
    </a>
    @endguest

    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; margin-top:4rem; max-width:900px; margin-left:auto; margin-right:auto;">
        <div class="card" style="padding:1.5rem; text-align:center;">
            <div style="
                width:55px; height:55px;
                background:linear-gradient(135deg, var(--maroon), var(--maroon-light));
                border-radius:12px;
                display:flex; align-items:center; justify-content:center;
                margin: 0 auto 0.75rem;
            ">
                <i class="fa-solid fa-users" style="font-size:1.3rem; color:var(--gold-light);"></i>
            </div>
            <h3 style="color:var(--maroon); margin:0 0 0.25rem;">Members</h3>
            <p style="color:#888; font-size:0.85rem; margin:0;">Track church members</p>
        </div>

        <div class="card" style="padding:1.5rem; text-align:center;">
            <div style="
                width:55px; height:55px;
                background:linear-gradient(135deg, var(--maroon), var(--maroon-light));
                border-radius:12px;
                display:flex; align-items:center; justify-content:center;
                margin: 0 auto 0.75rem;
            ">
                <i class="fa-solid fa-hand-holding-dollar" style="font-size:1.3rem; color:var(--gold-light);"></i>
            </div>
            <h3 style="color:var(--maroon); margin:0 0 0.25rem;">Tithes</h3>
            <p style="color:#888; font-size:0.85rem; margin:0;">Record offerings</p>
        </div>

        <div class="card" style="padding:1.5rem; text-align:center;">
            <div style="
                width:55px; height:55px;
                background:linear-gradient(135deg, var(--maroon), var(--maroon-light));
                border-radius:12px;
                display:flex; align-items:center; justify-content:center;
                margin: 0 auto 0.75rem;
            ">
                <i class="fa-solid fa-calendar-days" style="font-size:1.3rem; color:var(--gold-light);"></i>
            </div>
            <h3 style="color:var(--maroon); margin:0 0 0.25rem;">Events</h3>
            <p style="color:#888; font-size:0.85rem; margin:0;">Schedule activities</p>
        </div>

        <div class="card" style="padding:1.5rem; text-align:center;">
            <div style="
                width:55px; height:55px;
                background:linear-gradient(135deg, var(--maroon), var(--maroon-light));
                border-radius:12px;
                display:flex; align-items:center; justify-content:center;
                margin: 0 auto 0.75rem;
            ">
                <i class="fa-solid fa-clipboard-check" style="font-size:1.3rem; color:var(--gold-light);"></i>
            </div>
            <h3 style="color:var(--maroon); margin:0 0 0.25rem;">Attendance</h3>
            <p style="color:#888; font-size:0.85rem; margin:0;">Monitor presence</p>
        </div>
    </div>
</div>
@endsection