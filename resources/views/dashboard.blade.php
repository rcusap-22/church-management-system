@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fa-solid fa-chart-line"></i> Dashboard
    </h1>
    <span style="color:#888; font-size:0.9rem;">{{ now()->format('l, F j, Y') }}</span>
</div>

{{-- Top Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-users" style="color:var(--gold-light);"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalMembers }}</h3>
            <p>Total Members</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-user-check" style="color:var(--gold-light);"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $activeMembers }}</h3>
            <p>Active Members</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-hand-holding-dollar" style="color:var(--gold-light);"></i>
        </div>
        <div class="stat-info">
            <h3>₱{{ number_format($totalCollected, 2) }}</h3>
            <p>Total Collected</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-calendar-days" style="color:var(--gold-light);"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $upcomingEvents }}</h3>
            <p>Upcoming Events</p>
        </div>
    </div>
</div>

{{-- Financial Summary --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.2rem; margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-calendar-check" style="color:var(--gold-light);"></i>
        </div>
        <div class="stat-info">
            <h3>₱{{ number_format($thisYearTotal, 2) }}</h3>
            <p>Collected This Year</p>
        </div>
    </div>
    <div class="stat-card" style="border-left-color:#dc3545;">
        <div class="stat-icon" style="background:linear-gradient(135deg,#dc3545,#c82333);">
            <i class="fa-solid fa-money-bill-wave" style="color:white;"></i>
        </div>
        <div class="stat-info">
            <h3 style="color:#dc3545;">₱{{ number_format($totalSpent, 2) }}</h3>
            <p>Total Spent</p>
        </div>
    </div>
    <div class="stat-card" style="border-left-color:#856404;">
        <div class="stat-icon" style="background:linear-gradient(135deg,#856404,#b8860b);">
            <i class="fa-solid fa-clock" style="color:white;"></i>
        </div>
        <div class="stat-info">
            <h3 style="color:#856404;">₱{{ number_format($totalReserved, 2) }}</h3>
            <p>Reserved for Events</p>
        </div>
    </div>
    <div class="stat-card" style="border-left-color: {{ $availableBalance >= 0 ? '#28a745' : '#dc3545' }};">
        <div class="stat-icon" style="background: {{ $availableBalance >= 0 ? 'linear-gradient(135deg,#28a745,#20c997)' : 'linear-gradient(135deg,#dc3545,#c82333)' }};">
            <i class="fa-solid fa-scale-balanced" style="color:white;"></i>
        </div>
        <div class="stat-info">
            <h3 style="color: {{ $availableBalance >= 0 ? '#28a745' : '#dc3545' }};">
                ₱{{ number_format(abs($availableBalance), 2) }}
            </h3>
            <p>{{ $availableBalance >= 0 ? 'Available Balance' : 'Over Budget' }}</p>
        </div>
    </div>
</div>

{{-- Recent Activity --}}
<div class="section-grid">
    {{-- Recent Collections --}}
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-hand-holding-dollar"></i> Recent Collections
        </div>
        <div style="overflow:hidden;">
            @if($recentTithes->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-hand-holding-dollar" style="font-size:2rem; color:#ccc;"></i>
                    <p style="margin-top:0.5rem;">No collections recorded yet.</p>
                </div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Tithe</th>
                            <th>Offering</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTithes as $tithe)
                        <tr>
                            <td>{{ $tithe->event ? $tithe->event->title : '—' }}</td>
                            <td>₱{{ number_format($tithe->tithe_amount, 2) }}</td>
                            <td>₱{{ number_format($tithe->offering_amount, 2) }}</td>
                            <td><strong>₱{{ number_format($tithe->total, 2) }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($tithe->date)->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-calendar-days"></i> Upcoming Events
        </div>
        <div style="overflow:hidden;">
            @if($upcomingEventsList->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-calendar-days" style="font-size:2rem; color:#ccc;"></i>
                    <p style="margin-top:0.5rem;">No upcoming events.</p>
                </div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingEventsList as $event)
                        <tr>
                            <td><strong>{{ $event->title }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                            <td>₱{{ number_format($event->budget_allocated, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

{{-- Church Budget Summary --}}
@if($currentBudget)
<div class="card" style="margin-top:1.5rem;">
    <div class="card-header">
        <i class="fa-solid fa-sack-dollar"></i> {{ now()->year }} Church Budget
    </div>
    <div class="card-body">
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:1rem;">
            <div style="text-align:center; padding:1rem; background:#fdf5e6; border-radius:8px; border:1px solid var(--gold);">
                <div style="font-size:1.3rem; font-weight:700; color:var(--maroon);">
                    ₱{{ number_format($currentBudget->total_budget, 2) }}
                </div>
                <div style="font-size:0.82rem; color:#888; margin-top:0.25rem;">Total Budget</div>
            </div>
            <div style="text-align:center; padding:1rem; background:#d4edda; border-radius:8px;">
                <div style="font-size:1.3rem; font-weight:700; color:#155724;">
                    ₱{{ number_format($currentBudget->breakdown->sum('amount'), 2) }}
                </div>
                <div style="font-size:0.82rem; color:#155724; margin-top:0.25rem;">Allocated</div>
            </div>
            <div style="text-align:center; padding:1rem; background:#f8f9fa; border-radius:8px;">
                <div style="font-size:1.3rem; font-weight:700; color:var(--maroon);">
                    ₱{{ number_format($currentBudget->total_budget - $currentBudget->breakdown->sum('amount'), 2) }}
                </div>
                <div style="font-size:0.82rem; color:#888; margin-top:0.25rem;">Unallocated</div>
            </div>
        </div>

        @if($currentBudget->breakdown->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Allocated</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($currentBudget->breakdown as $item)
                <tr>
                    <td>{{ $item->category }}</td>
                    <td>₱{{ number_format($item->amount, 2) }}</td>
                    <td>{{ $item->notes ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <div style="margin-top:1rem; text-align:right;">
            <a href="{{ route('budget.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-right"></i> View Full Budget
            </a>
        </div>
    </div>
</div>
@else
    @if(auth()->check() && auth()->user()->isAdmin())
    <div class="card" style="margin-top:1.5rem;">
        <div class="card-body" style="text-align:center; padding:2rem;">
            <i class="fa-solid fa-sack-dollar" style="font-size:2rem; color:#ccc;"></i>
            <p style="color:#888; margin:0.5rem 0;">No budget set for {{ now()->year }} yet.</p>
            <a href="{{ route('budget.create') }}" class="btn btn-gold" style="margin-top:0.5rem;">
                <i class="fa-solid fa-plus"></i> Set {{ now()->year }} Budget
            </a>
        </div>
    </div>
    @endif
@endif

{{-- Quick Actions --}}
@if(auth()->check() && auth()->user()->isAdmin())
<div class="card" style="margin-top:1.5rem;">
    <div class="card-header">
        <i class="fa-solid fa-bolt"></i> Quick Actions
    </div>
    <div class="card-body" style="display:flex; gap:1rem; flex-wrap:wrap;">
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-user-plus"></i> Add Member
        </a>
        <a href="{{ route('tithes.create') }}" class="btn btn-gold">
            <i class="fa-solid fa-plus"></i> Record Collection
        </a>
        <a href="{{ route('events.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-calendar-plus"></i> Create Event
        </a>
        <a href="{{ route('attendance.create') }}" class="btn btn-gold">
            <i class="fa-solid fa-clipboard-list"></i> Record Attendance
        </a>
        <a href="{{ route('budget.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-sack-dollar"></i> Set Budget
        </a>
    </div>
</div>
@endif

@endsection