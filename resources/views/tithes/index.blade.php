@extends('layouts.app')
@section('title', 'Tithes & Offerings')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-hand-holding-dollar"></i> Tithes & Offerings</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
        <a href="{{ route('tithes.create') }}" class="btn btn-gold">
            <i class="fa-solid fa-plus"></i> Record Collection
        </a>
    @endif
</div>

{{-- Summary Cards --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.2rem; margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-hand-holding-dollar" style="color:var(--gold-light);"></i>
        </div>
        <div class="stat-info">
            <h3>₱{{ number_format($totalCollected, 2) }}</h3>
            <p>Total Collected</p>
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

{{-- Filters --}}
<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-body">
        <form method="GET" action="{{ route('tithes.index') }}" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
            <div class="form-group" style="margin:0; min-width:180px;">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-control">
                    <option value="">All Events</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin:0; min-width:120px;">
                <label class="form-label">Year</label>
                <input type="number" name="year" class="form-control"
                    placeholder="{{ now()->year }}" value="{{ request('year') }}" min="2000" max="2099">
            </div>
            <div class="form-group" style="margin:0; min-width:150px;">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="form-group" style="margin:0; min-width:150px;">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div style="display:flex; gap:0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('tithes.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        @if($tithes->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-hand-holding-dollar" style="font-size:2.5rem; color:#ccc;"></i>
                <p style="margin-top:0.5rem;">No collections recorded yet.</p>
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Tithe</th>
                        <th>Offering</th>
                        <th>Donation</th>
                        <th>Total</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tithes as $tithe)
                    <tr>
                        <td>{{ ($tithes->currentPage() - 1) * $tithes->perPage() + $loop->iteration }}</td>
                        <td>{{ $tithe->event ? $tithe->event->title : '—' }}</td>
                        <td>{{ \Carbon\Carbon::parse($tithe->date)->format('M d, Y') }}</td>
                        <td>₱{{ number_format($tithe->tithe_amount, 2) }}</td>
                        <td>₱{{ number_format($tithe->offering_amount, 2) }}</td>
                        <td>₱{{ number_format($tithe->donation_amount, 2) }}</td>
                        <td><strong>₱{{ number_format($tithe->total, 2) }}</strong></td>
                        <td>{{ $tithe->notes ?? '—' }}</td>
                        <td style="display:flex; gap:0.4rem;">
                            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                                <a href="{{ route('tithes.edit', $tithe) }}" class="btn btn-gold btn-sm">Edit</a>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('tithes.destroy', $tithe) }}"
                                    onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:0.85rem 1rem; background:#fdf5e6; font-weight:700;
                color:var(--maroon); text-align:right; border-top:2px solid var(--gold);">
                Page Total: ₱{{ number_format($tithes->sum('tithe_amount') + $tithes->sum('offering_amount') + $tithes->sum('donation_amount'), 2) }}
            </div>
            <div class="pagination-wrapper">{{ $tithes->links() }}</div>
        @endif
    </div>
</div>
@endsection