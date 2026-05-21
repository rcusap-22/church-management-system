@extends('layouts.app')
@section('title', 'Edit Member')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Member</h1>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card">
    <div class="card-header">Editing: {{ $member->full_name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('members.update', $member) }}">
            @csrf @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">First Name <span style="color:red;">*</span></label>
                    <input type="text" name="first_name" class="form-control"
                        value="{{ old('first_name', $member->first_name) }}" required>
                    @error('first_name')
                        <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Last Name <span style="color:red;">*</span></label>
                    <input type="text" name="last_name" class="form-control"
                        value="{{ old('last_name', $member->last_name) }}" required>
                    @error('last_name')
                        <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $member->email) }}">
                    @error('email')
                        <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control"
                        value="{{ old('phone', $member->phone) }}">
                    @error('phone')
                        <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control"
                    value="{{ old('address', $member->address) }}">
                @error('address')
                    <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control"
                        value="{{ old('birthdate', $member->birthdate) }}">
                    @error('birthdate')
                        <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Status <span style="color:red;">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ old('status', $member->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $member->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span style="color:red; font-size:0.82rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="display:flex; gap:1rem; margin-top:1rem;">
                <button type="submit" class="btn btn-gold">Update Member</button>
                <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection