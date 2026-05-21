@extends('layouts.app')
@section('title', 'Event Details')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-calendar-days"></i> {{ $event->title }}</h1>
    <div style="display:flex; gap:0.5rem;">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('events.edit', $event) }}" class="btn btn-gold">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
        @endif
        <a href="{{ route('events.index') }}" class="btn btn-secondary">← Back</a>
    </div>
</div>

<div class="section-grid">
    {{-- Event Info --}}
    <div class="card">
        <div class="card-header"><i class="fa-solid fa-circle-info"></i> Event Information</div>
        <div class="card-body">
            <table style="width:100%; font-size:0.92rem;">
                <tr>
                    <td style="padding:0.5rem 0; color:#888; width:40%;">Title</td>
                    <td style="padding:0.5rem 0;"><strong>{{ $event->title }}</strong></td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Description</td>
                    <td style="padding:0.5rem 0;">{{ $event->description ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Date</td>
                    <td style="padding:0.5rem 0;">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Time</td>
                    <td style="padding:0.5rem 0;">
                        {{ $event->time ? \Carbon\Carbon::parse($event->time)->format('h:i A') : '—' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Location</td>
                    <td style="padding:0.5rem 0;">{{ $event->location ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Budget Allocated</td>
                    <td style="padding:0.5rem 0;">
                        <strong style="color:var(--maroon);">₱{{ number_format($event->budget_allocated, 2) }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Total Collected</td>
                    <td style="padding:0.5rem 0;">
                        <strong style="color:#28a745;">₱{{ number_format($event->total_collected, 2) }}</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Budget Breakdown --}}
    <div class="card">
        <div class="card-header"><i class="fa-solid fa-list"></i> Budget Breakdown</div>
        <div class="card-body" style="padding:0;">
            @if($event->budgetBreakdown->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-list" style="font-size:2rem; color:#ccc;"></i>
                    <p style="margin-top:0.5rem;">No budget breakdown added.</p>
                </div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->budgetBreakdown as $item)
                        <tr>
                            <td>{{ $item->category }}</td>
                            <td>₱{{ number_format($item->amount, 2) }}</td>
                            <td>{{ $item->notes ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding:0.85rem 1rem; background:#fdf5e6; font-weight:700;
                    color:var(--maroon); text-align:right; border-top:2px solid var(--gold);">
                    Total: ₱{{ number_format($event->budgetBreakdown->sum('amount'), 2) }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Attendance --}}
<div class="card" style="margin-top:1.5rem;">
    <div class="card-header"><i class="fa-solid fa-clipboard-check"></i> Attendance</div>
    <div class="card-body" style="padding:0;">
        @if($event->attendance->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-clipboard-check" style="font-size:2rem; color:#ccc;"></i>
                <p style="margin-top:0.5rem;">No attendance recorded.</p>
            </div>
        @else
            @php
                $present = $event->attendance->where('status','present')->count();
                $absent  = $event->attendance->where('status','absent')->count();
                $late    = $event->attendance->where('status','late')->count();
            @endphp
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; padding:1rem;">
                <div style="text-align:center; padding:1rem; background:#d4edda; border-radius:8px;">
                    <div style="font-size:1.8rem; font-weight:700; color:#155724;">{{ $present }}</div>
                    <div style="font-size:0.85rem; color:#155724;">Present</div>
                </div>
                <div style="text-align:center; padding:1rem; background:#fff3cd; border-radius:8px;">
                    <div style="font-size:1.8rem; font-weight:700; color:#856404;">{{ $late }}</div>
                    <div style="font-size:0.85rem; color:#856404;">Late</div>
                </div>
                <div style="text-align:center; padding:1rem; background:#f8d7da; border-radius:8px;">
                    <div style="font-size:1.8rem; font-weight:700; color:#721c24;">{{ $absent }}</div>
                    <div style="font-size:0.85rem; color:#721c24;">Absent</div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr><th>#</th><th>Member</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($event->attendance as $record)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $record->member->full_name }}</td>
                        <td>
                            <span class="badge {{
                                $record->status === 'present' ? 'badge-success' :
                                ($record->status === 'late' ? 'badge-warning' : 'badge-danger')
                            }}">{{ ucfirst($record->status) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection