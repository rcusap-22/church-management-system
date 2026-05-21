@extends('layouts.app')
@section('title', 'Events')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-calendar-days"></i> Events</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('events.create') }}" class="btn btn-gold">
            <i class="fa-solid fa-calendar-plus"></i> Create Event
        </a>
    @endif
</div>

{{-- Filters --}}
<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-body">
        <form method="GET" action="{{ route('events.index') }}" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
            <div class="form-group" style="margin:0; min-width:160px;">
                <label class="form-label">Show</label>
                <select name="filter" class="form-control">
                    <option value="">All Events</option>
                    <option value="upcoming" {{ request('filter') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="past" {{ request('filter') === 'past' ? 'selected' : '' }}>Past</option>
                </select>
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
                <a href="{{ route('events.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        @if($events->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-calendar-days" style="font-size:2.5rem; color:#ccc;"></i>
                <p style="margin-top:0.5rem;">No events found.</p>
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Attendance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                        <td>{{ ($events->currentPage() - 1) * $events->perPage() + $loop->iteration }}</td>
                        <td><strong>{{ $event->title }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                        <td>{{ $event->time ? \Carbon\Carbon::parse($event->time)->format('h:i A') : '—' }}</td>
                        <td>{{ $event->location ?? '—' }}</td>
                        <td>₱{{ number_format($event->budget_allocated, 2) }}</td>
                        <td>
                            <span class="badge {{ $event->status === 'completed' ? 'badge-success' : ($event->status === 'ongoing' ? 'badge-warning' : 'badge-gold') }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td>
                            <span style="display:inline-block;
                                         background:var(--gold-light);
                                         color:var(--maroon-dark);
                                         padding:0.3rem 0.8rem;
                                         border-radius:20px;
                                         font-size:0.82rem;
                                         font-weight:600;
                                         white-space:nowrap;">
                                {{ $event->attendance_count }} {{ $event->attendance_count === 1 ? 'attendee' : 'attendees' }}
                            </span>
                        </td>
                        <td style="display:flex; gap:0.4rem; flex-wrap:wrap;">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-secondary btn-sm">View</a>
                            @if(auth()->user()->isAdmin())
                                @if(!$event->isCompleted())
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-gold btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('events.complete', $event) }}"
                                        onsubmit="return confirm('Mark {{ $event->title }} as completed? ₱{{ number_format($event->budget_allocated, 2) }} will be recorded as spent.')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm" style="background:#28a745; color:white;">
                                            <i class="fa-solid fa-check"></i> Complete
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('events.destroy', $event) }}"
                                        onsubmit="return confirm('Delete {{ $event->title }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @else
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-check"></i> Completed
                                    </span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper">{{ $events->links() }}</div>
        @endif
    </div>
</div>
@endsection