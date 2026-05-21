@extends('layouts.app')
@section('title', 'Members')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fa-solid fa-users"></i> Members</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('members.create') }}" class="btn btn-gold">
            <i class="fa-solid fa-user-plus"></i> Add Member
        </a>
    @endif
</div>

{{-- Filters --}}
<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-body">
        <form method="GET" action="{{ route('members.index') }}" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
            <div class="form-group" style="margin:0; flex:1; min-width:200px;">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control"
                    placeholder="Name or email..." value="{{ request('search') }}">
            </div>
            <div class="form-group" style="margin:0; min-width:150px;">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div style="display:flex; gap:0.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <a href="{{ route('members.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        @if($members->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-users" style="font-size:2.5rem; color:#ccc;"></i>
                <p style="margin-top:0.5rem;">No members found.</p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('members.create') }}" class="btn btn-gold" style="margin-top:0.5rem;">Add First Member</a>
                @endif
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Birthdate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td>{{ ($members->currentPage() - 1) * $members->perPage() + $loop->iteration }}</td>
                        <td><strong>{{ $member->full_name }}</strong></td>
                        <td>{{ $member->email ?? '—' }}</td>
                        <td>{{ $member->phone ?? '—' }}</td>
                        <td>{{ $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('M d, Y') : '—' }}</td>
                        <td>
                            <span class="badge {{ $member->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                        <td style="display:flex; gap:0.4rem;">
                            <a href="{{ route('members.show', $member) }}" class="btn btn-secondary btn-sm">View</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('members.edit', $member) }}" class="btn btn-gold btn-sm">Edit</a>
                                <form method="POST" action="{{ route('members.destroy', $member) }}"
                                    onsubmit="return confirm('Delete {{ $member->full_name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper">{{ $members->links() }}</div>
        @endif
    </div>
</div>
@endsection