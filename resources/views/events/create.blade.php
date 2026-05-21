@extends('layouts.app')
@section('title', 'Create Event')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-calendar-plus"></i> Create Event</h1>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card">
    <div class="card-header">Event Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('events.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Event Title <span style="color:red;">*</span></label>
                <input type="text" name="title" class="form-control"
                    value="{{ old('title') }}" placeholder="e.g. Sunday Worship Service" required>
                @error('title')
                    <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"
                    placeholder="Optional description...">{{ old('description') }}</textarea>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Date <span style="color:red;">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Time</label>
                    <input type="time" name="time" class="form-control" value="{{ old('time') }}">
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control"
                        value="{{ old('location') }}" placeholder="e.g. Main Sanctuary">
                </div>
                <div class="form-group">
                    <label class="form-label">Total Budget Allocated (₱)</label>
                    <input type="number" name="budget_allocated" class="form-control"
                        step="0.01" min="0" value="{{ old('budget_allocated', 0) }}">
                </div>
            </div>

            {{-- Budget Breakdown --}}
            <div style="background:#fdf5e6; border-radius:8px; padding:1.2rem; margin-bottom:1.2rem; border:1px solid var(--gold);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                    <h4 style="color:var(--maroon); margin:0; font-size:0.95rem;">
                        <i class="fa-solid fa-list"></i> Budget Breakdown <span style="color:#888; font-weight:400;">(optional)</span>
                    </h4>
                    <button type="button" onclick="addRow()" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Add Item
                    </button>
                </div>
                <div id="breakdown-rows">
                    <div class="breakdown-row" style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:0.75rem; margin-bottom:0.75rem;">
                        <input type="text" name="categories[]" class="form-control" placeholder="Category (e.g. Venue)">
                        <input type="number" name="amounts[]" class="form-control" placeholder="Amount" step="0.01" min="0">
                        <input type="text" name="breakdown_notes[]" class="form-control" placeholder="Notes (optional)">
                        <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:1rem; margin-top:1rem;">
                <button type="submit" class="btn btn-gold">
                    <i class="fa-solid fa-floppy-disk"></i> Save Event
                </button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function addRow() {
    const container = document.getElementById('breakdown-rows');
    const row = document.createElement('div');
    row.className = 'breakdown-row';
    row.style = 'display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:0.75rem; margin-bottom:0.75rem;';
    row.innerHTML = `
        <input type="text" name="categories[]" class="form-control" placeholder="Category (e.g. Food)">
        <input type="number" name="amounts[]" class="form-control" placeholder="Amount" step="0.01" min="0">
        <input type="text" name="breakdown_notes[]" class="form-control" placeholder="Notes (optional)">
        <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">
            <i class="fa-solid fa-trash"></i>
        </button>`;
    container.appendChild(row);
}
function removeRow(btn) {
    btn.closest('.breakdown-row').remove();
}
</script>
@endsection