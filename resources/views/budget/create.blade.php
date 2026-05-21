@extends('layouts.app')
@section('title', 'Set Budget')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-sack-dollar"></i> Set Church Budget</h1>
    <a href="{{ route('budget.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card">
    <div class="card-header">Budget Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('budget.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Year <span style="color:red;">*</span></label>
                    <input type="number" name="year" class="form-control"
                        value="{{ old('year', now()->year) }}" min="2000" max="2099" required>
                    @error('year')
                        <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Total Budget (₱) <span style="color:red;">*</span></label>
                    <input type="number" name="total_budget" class="form-control"
                        step="0.01" min="0" value="{{ old('total_budget') }}"
                        placeholder="0.00" required>
                    @error('total_budget')
                        <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Notes</label>
                <input type="text" name="notes" class="form-control"
                    value="{{ old('notes') }}" placeholder="Optional notes...">
            </div>

            {{-- Budget Breakdown --}}
            <div style="background:#fdf5e6; border-radius:8px; padding:1.2rem; margin-bottom:1.2rem; border:1px solid var(--gold);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
                    <h4 style="color:var(--maroon); margin:0; font-size:0.95rem;">
                        <i class="fa-solid fa-list"></i> Budget Breakdown <span style="color:#888; font-weight:400;">(optional)</span>
                    </h4>
                    <button type="button" onclick="addRow()" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Add Category
                    </button>
                </div>
                <div id="breakdown-rows">
                    <div class="breakdown-row" style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:0.75rem; margin-bottom:0.75rem;">
                        <input type="text" name="categories[]" class="form-control" placeholder="Category (e.g. Events)">
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
                    <i class="fa-solid fa-floppy-disk"></i> Save Budget
                </button>
                <a href="{{ route('budget.index') }}" class="btn btn-secondary">Cancel</a>
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