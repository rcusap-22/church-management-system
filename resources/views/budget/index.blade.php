@extends('layouts.app')
@section('title', 'Church Budget')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-sack-dollar"></i> Church Budget</h1>
    <a href="{{ route('budget.create') }}" class="btn btn-gold">
        <i class="fa-solid fa-plus"></i> Set Budget
    </a>
</div>

@if($budgets->isEmpty())
    <div class="card">
        <div class="empty-state">
            <i class="fa-solid fa-sack-dollar" style="font-size:2.5rem; color:#ccc;"></i>
            <p style="margin-top:0.5rem;">No budget set yet.</p>
            <a href="{{ route('budget.create') }}" class="btn btn-gold" style="margin-top:0.5rem;">Set First Budget</a>
        </div>
    </div>
@else
    @foreach($budgets as $budget)
    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
            <span><i class="fa-solid fa-calendar"></i> {{ $budget->year }} Budget</span>
            <div style="display:flex; gap:0.5rem;">
                <a href="{{ route('budget.edit', $budget) }}" class="btn btn-gold btn-sm">Edit</a>
                <form method="POST" action="{{ route('budget.destroy', $budget) }}"
                    onsubmit="return confirm('Delete this budget?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:1.5rem;">
                <div style="text-align:center; padding:1rem; background:#fdf5e6; border-radius:8px; border:1px solid var(--gold);">
                    <div style="font-size:1.4rem; font-weight:700; color:var(--maroon);">
                        ₱{{ number_format($budget->total_budget, 2) }}
                    </div>
                    <div style="font-size:0.85rem; color:#888;">Total Budget</div>
                </div>
                <div style="text-align:center; padding:1rem; background:#d4edda; border-radius:8px;">
                    <div style="font-size:1.4rem; font-weight:700; color:#155724;">
                        ₱{{ number_format($budget->breakdown->sum('amount'), 2) }}
                    </div>
                    <div style="font-size:0.85rem; color:#155724;">Allocated</div>
                </div>
                <div style="text-align:center; padding:1rem; background:#f8f9fa; border-radius:8px;">
                    <div style="font-size:1.4rem; font-weight:700; color:var(--maroon);">
                        ₱{{ number_format($budget->total_budget - $budget->breakdown->sum('amount'), 2) }}
                    </div>
                    <div style="font-size:0.85rem; color:#888;">Unallocated</div>
                </div>
            </div>

            @if($budget->notes)
                <p style="color:#888; font-size:0.9rem; margin-bottom:1rem;">
                    <i class="fa-solid fa-note-sticky"></i> {{ $budget->notes }}
                </p>
            @endif

            @if($budget->breakdown->isNotEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($budget->breakdown as $item)
                        <tr>
                            <td>{{ $item->category }}</td>
                            <td>₱{{ number_format($item->amount, 2) }}</td>
                            <td>{{ $item->notes ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @endforeach
@endif
@endsection