@extends('layouts.app')
@section('title', 'Attendance')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-clipboard-check"></i> Attendance Records</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
        <a href="{{ route('attendance.create') }}" class="btn btn-gold">
            <i class="fa-solid fa-plus"></i> Record Attendance
        </a>
    @endif
</div>

{{-- Filters --}}
<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-body">
        <form method="GET" action="{{ route('attendance.index') }}" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
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
            <div class="form-group" style="margin:0; min-width:160px;">
                <label class="form-label">Member</label>
                <select name="member_id" class="form-control">
                    <option value="">All Members</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin:0; min-width:140px;">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="present" {{ request('status') === 'present' ? 'selected' : '' }}>Present</option>
                    <option value="late" {{ request('status') === 'late' ? 'selected' : '' }}>Late</option>
                    <option value="absent" {{ request('status') === 'absent' ? 'selected' : '' }}>Absent</option>
                </select>
            </div>
            <div style="display:flex; gap:0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        @if($attendance->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-clipboard-check" style="font-size:2.5rem; color:#ccc;"></i>
                <p style="margin-top:0.5rem;">No attendance records found.</p>
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Event</th>
                        <th>Event Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendance as $record)
                    <tr>
                      <td>{{ ($attendance->currentPage() - 1) * $attendance->perPage() + $loop->iteration }}</td>
                        <td><strong>{{ $record->member->full_name }}</strong></td>
                        <td>{{ $record->event->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->event->date)->format('M d, Y') }}</td>
                        <td>
                            <span class="badge {{
                                $record->status === 'present' ? 'badge-success' :
                                ($record->status === 'late' ? 'badge-warning' : 'badge-danger')
                            }}">{{ ucfirst($record->status) }}</span>
                        </td>
                        <td style="display:flex; gap:0.4rem;">
                            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                                <a href="{{ route('attendance.edit', $record) }}" class="btn btn-gold btn-sm">Edit</a>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('attendance.destroy', $record) }}"
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
            <div class="pagination-wrapper">{{ $attendance->links() }}</div>
        @endif
    </div>
</div>
@endsection