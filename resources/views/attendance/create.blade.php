@extends('layouts.app')
@section('title', 'Record Attendance')

@section('content')
<div class="page-header">
    <h1 class="page-title">✅ Record Attendance</h1>
    <a href="{{ route('attendance.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card">
    <div class="card-header">Attendance Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('attendance.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Member <span style="color:red;">*</span></label>
                <select name="member_id" class="form-control" required>
                    <option value="">-- Select Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}"
                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Event <span style="color:red;">*</span></label>
                <select name="event_id" class="form-control" required>
                    <option value="">-- Select Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}"
                            {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }} — {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                        </option>
                    @endforeach
                </select>
                @error('event_id')
                    <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Status <span style="color:red;">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="present" {{ old('status') === 'present' ? 'selected' : '' }}>Present</option>
                    <option value="late" {{ old('status') === 'late' ? 'selected' : '' }}>Late</option>
                    <option value="absent" {{ old('status') === 'absent' ? 'selected' : '' }}>Absent</option>
                </select>
                @error('status')
                    <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display:flex; gap:1rem; margin-top:1rem;">
                <button type="submit" class="btn btn-gold">💾 Save Record</button>
                <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection