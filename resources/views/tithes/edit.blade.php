@extends('layouts.app')
@section('title', 'Edit Collection')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-pen-to-square"></i> Edit Collection</h1>
    <a href="{{ route('tithes.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card">
    <div class="card-header">Editing Record #{{ $tithe->id }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('tithes.update', $tithe) }}">
            @csrf @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Related Event</label>
                    <select name="event_id" class="form-control">
                        <option value="">-- No specific event --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}"
                                {{ old('event_id', $tithe->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} — {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Date <span style="color:red;">*</span></label>
                    <input type="date" name="date" class="form-control"
                        value="{{ old('date', $tithe->date) }}" required>
                </div>
            </div>

            <div style="background:#fdf5e6; border-radius:8px; padding:1.2rem; margin-bottom:1.2rem; border:1px solid var(--gold);">
                <h4 style="color:var(--maroon); margin:0 0 1rem; font-size:0.95rem;">
                    <i class="fa-solid fa-coins"></i> Collection Breakdown
                </h4>
                <div class="form-grid-3">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Tithe Amount (₱)</label>
                        <input type="number" name="tithe_amount" class="form-control"
                            step="0.01" min="0" value="{{ old('tithe_amount', $tithe->tithe_amount) }}" required>
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Offering Amount (₱)</label>
                        <input type="number" name="offering_amount" class="form-control"
                            step="0.01" min="0" value="{{ old('offering_amount', $tithe->offering_amount) }}" required>
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Donation Amount (₱)</label>
                        <input type="number" name="donation_amount" class="form-control"
                            step="0.01" min="0" value="{{ old('donation_amount', $tithe->donation_amount) }}" required>
                    </div>
                </div>
                <div style="margin-top:1rem; padding-top:1rem; border-top:1px dashed var(--gold); text-align:right;">
                    <strong style="color:var(--maroon);">Total: ₱<span id="total">{{ number_format($tithe->total, 2) }}</span></strong>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Notes</label>
                <input type="text" name="notes" class="form-control" value="{{ old('notes', $tithe->notes) }}">
            </div>

            <div style="display:flex; gap:1rem; margin-top:1rem;">
                <button type="submit" class="btn btn-gold">
                    <i class="fa-solid fa-floppy-disk"></i> Update Record
                </button>
                <a href="{{ route('tithes.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    function updateTotal() {
        const tithe    = parseFloat(document.querySelector('[name=tithe_amount]').value) || 0;
        const offering = parseFloat(document.querySelector('[name=offering_amount]').value) || 0;
        const donation = parseFloat(document.querySelector('[name=donation_amount]').value) || 0;
        document.getElementById('total').textContent = (tithe + offering + donation).toFixed(2);
    }
    document.querySelectorAll('[name=tithe_amount],[name=offering_amount],[name=donation_amount]')
        .forEach(el => el.addEventListener('input', updateTotal));
</script>
@endsection