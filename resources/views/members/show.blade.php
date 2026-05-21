@extends('layouts.app')
@section('title', 'Member Details')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-user"></i> {{ $member->full_name }}</h1>
    <div style="display:flex; gap:0.5rem;">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('members.edit', $member) }}" class="btn btn-gold">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
        @endif
        <a href="{{ route('members.index') }}" class="btn btn-secondary">← Back</a>
    </div>
</div>

<div class="section-grid">
    {{-- Member Info --}}
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-circle-info"></i> Member Information
        </div>
        <div class="card-body">
            <table style="width:100%; font-size:0.92rem;">
                <tr>
                    <td style="padding:0.5rem 0; color:#888; width:40%;">Full Name</td>
                    <td style="padding:0.5rem 0;"><strong>{{ $member->full_name }}</strong></td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Email</td>
                    <td style="padding:0.5rem 0;">{{ $member->email ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Phone</td>
                    <td style="padding:0.5rem 0;">{{ $member->phone ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Address</td>
                    <td style="padding:0.5rem 0;">{{ $member->address ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Birthdate</td>
                    <td style="padding:0.5rem 0;">
                        {{ $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('F d, Y') : '—' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Status</td>
                    <td style="padding:0.5rem 0;">
                        <span class="badge {{ $member->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($member->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0.5rem 0; color:#888;">Member Since</td>
                    <td style="padding:0.5rem 0;">{{ $member->created_at->format('F d, Y') }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Tithe Summary --}}
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-hand-holding-dollar"></i> Tithe & Offering
        </div>
        <div class="card-body" style="text-align:center; padding:2rem;">
            <i class="fa-solid fa-hand-holding-dollar" style="font-size:2rem; color:#ccc;"></i>
            <p style="color:#888; margin:0.75rem 0 0.25rem;">
                Tithes are recorded as anonymous collections per service.
            </p>
            <p style="color:#aaa; font-size:0.85rem; margin:0 0 1rem;">
                Individual contributions are not tracked per member.
            </p>
            <a href="{{ route('tithes.index') }}" class="btn btn-gold btn-sm">
                <i class="fa-solid fa-arrow-right"></i> View All Collections
            </a>
        </div>
    </div>
</div>

{{-- Attendance History --}}
<div class="card" style="margin-top:1.5rem;">
    <div class="card-header">
        <i class="fa-solid fa-clipboard-check"></i> Attendance History
    </div>
    <div class="card-body" style="padding:0;">
        @if($member->attendance->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-clipboard-check" style="font-size:2rem; color:#ccc;"></i>
                <p style="margin-top:0.5rem;">No attendance records yet.</p>
            </div>
        @else
            {{-- Summary Stats --}}
            @php
                $present = $member->attendance->where('status', 'present')->count();
                $late    = $member->attendance->where('status', 'late')->count();
                $absent  = $member->attendance->where('status', 'absent')->count();
                $total   = $member->attendance->count();
            @endphp
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; padding:1rem;">
                <div style="text-align:center; padding:0.75rem; background:#d4edda; border-radius:8px;">
                    <div style="font-size:1.4rem; font-weight:700; color:#155724;">{{ $present }}</div>
                    <div style="font-size:0.78rem; color:#155724;">Present</div>
                </div>
                <div style="text-align:center; padding:0.75rem; background:#fff3cd; border-radius:8px;">
                    <div style="font-size:1.4rem; font-weight:700; color:#856404;">{{ $late }}</div>
                    <div style="font-size:0.78rem; color:#856404;">Late</div>
                </div>
                <div style="text-align:center; padding:0.75rem; background:#f8d7da; border-radius:8px;">
                    <div style="font-size:1.4rem; font-weight:700; color:#721c24;">{{ $absent }}</div>
                    <div style="font-size:0.78rem; color:#721c24;">Absent</div>
                </div>
                <div style="text-align:center; padding:0.75rem; background:#fdf5e6; border-radius:8px; border:1px solid var(--gold);">
                    <div style="font-size:1.4rem; font-weight:700; color:var(--maroon);">{{ $total }}</div>
                    <div style="font-size:0.78rem; color:var(--maroon);">Total</div>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($member->attendance as $record)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $record->event->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->event->date)->format('M d, Y') }}</td>
                        <td>
                            <span class="badge {{
                                $record->status === 'present' ? 'badge-success' :
                                ($record->status === 'late' ? 'badge-warning' : 'badge-danger')
                            }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection