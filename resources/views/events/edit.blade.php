@extends('layouts.app')
@section('title', 'Edit Event')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-pen-to-square"></i> Edit Event</h1>
    <a href="{{ route('events.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card">
    <div class="card-header">Editing: {{ $event->title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('events.update', $event) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Event Title <span style="color:red;">*</span></label>
                <input type="text" name="title" class="form-control"
                    value="{{ old('title', $event->title) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Date <span style="color:red;">*</span></label>
                    <input type="date" name="date" class="form-control"
                        value="{{ old('date', $event->date) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Time</label>
                    <input type="time" name="time" class="form-control"
                        value="{{ old('time', $event->time) }}">
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control"
                        value="{{ old('location', $event->location) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Total Budget Allocated (₱)</label>

                    {{-- Available Funds Banner --}}
                    @php
                        $collected = \App\Models\Tithe::selectRaw('SUM(tithe_amount + offering_amount + donation_amount) as total')->value('total') ?? 0;
                        $allocated = \App\Models\Event::where('id', '!=', $event->id)->sum('budget_allocated');
                        $available = $collected - $allocated;
                    @endphp
                    <div style="background: {{ $available > 0 ? '#d4edda' : '#fff3cd' }};
                        border-radius:8px; padding:0.75rem 1rem; margin-bottom:0.6rem;
                        border: 1px solid {{ $available > 0 ? '#c3e6cb' : '#ffeeba' }};">
                        <i class="fa-solid fa-circle-info" style="color: {{ $available > 0 ? '#155724' : '#856404' }};"></i>
                        <strong style="color: {{ $available > 0 ? '#155724' : '#856404' }};">
                            Available Funds: ₱{{ number_format($available, 2) }}
                        </strong>
                        <span style="color:#555; font-size:0.82rem; margin-left:0.4rem;">
                            (₱{{ number_format($collected, 2) }} collected − ₱{{ number_format($allocated, 2) }} already allocated)
                        </span>
                    </div>

                    <input type="number" name="budget_allocated" class="form-control"
                        step="0.01" min="0" value="{{ old('budget_allocated', $event->budget_allocated) }}">
                </div>
            </div>

            {{-- Budget Breakdown --}}
            <div style="background:#fdf5e6; border-radius:8px; padding:1.2rem; margin-bottom:1.2rem; border:1px solid var(--gold);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                    <h4 style="color:var(--maroon); margin:0; font-size:0.95rem;">
                        <i class="fa-solid fa-list"></i> Budget Breakdown
                    </h4>
                    <button type="button" onclick="addRow()" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Add Item
                    </button>
                </div>
                <div id="breakdown-rows">
                    @forelse($event->budgetBreakdown as $item)
                    <div class="breakdown-row" style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:0.75rem; margin-bottom:0.75rem;">
                        <input type="text" name="categories[]" class="form-control"
                            placeholder="Category" value="{{ $item->category }}">
                        <input type="number" name="amounts[]" class="form-control"
                            placeholder="Amount" step="0.01" min="0" value="{{ $item->amount }}">
                        <input type="text" name="breakdown_notes[]" class="form-control"
                            placeholder="Notes (optional)" value="{{ $item->notes }}">
                        <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    @empty
                    <div class="breakdown-row" style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:0.75rem; margin-bottom:0.75rem;">
                        <input type="text" name="categories[]" class="form-control" placeholder="Category (e.g. Venue)">
                        <input type="number" name="amounts[]" class="form-control" placeholder="Amount" step="0.01" min="0">
                        <input type="text" name="breakdown_notes[]" class="form-control" placeholder="Notes (optional)">
                        <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>

            <div style="display:flex; gap:1rem; margin-top:1rem;">
                <button type="submit" class="btn btn-gold">
                    <i class="fa-solid fa-floppy-disk"></i> Update Event
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
        <input type="text" name="categories[]" class="form-control" placeholder="Category">
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