@extends('front.layouts.app')

@section('main')
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 60px;
    color: white;
    text-align: center;
}
.management-container {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    padding: 40px;
    margin-top: -50px;
    position: relative;
    z-index: 10;
}
.member-row {
    display: flex;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.2s ease;
}
.member-row:last-child {
    border-bottom: none;
}
.member-row:hover {
    background-color: #f8f9fa;
}
.member-info {
    flex-grow: 1;
    display: flex;
    align-items: center;
}
.member-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
    object-fit: cover;
}
.member-name {
    font-weight: 600;
    color: #333;
}
.member-role {
    font-size: 0.9rem;
    color: #6c757d;
}
.owner-badge, .leader-badge {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
    color: white;
}
.owner-badge {
    background: #ffc107;
}
.leader-badge {
    background: #17a2b8;
}
.btn-action {
    border-radius: 20px;
    font-size: 0.8rem;
    padding: 5px 15px;
    font-weight: 600;
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 700; margin: 0;">Manage Members</h1>
        <p style="font-size: 1.1rem; opacity: 0.9; margin: 0;">{{ $group->title }}</p>
    </div>
</div>

<div class="container">
    <div class="management-container">
        @include('front.message')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Member List ({{ $group->members()->count() }})</h4>
            <a href="{{ route('account.group.show', $group->id) }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back to Group</a>
        </div>

        <form method="GET" action="{{ route('account.group.manageMembers', $group->id) }}" class="mb-4">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search members by name..." class="form-control" />
        </form>

        <div>
            @foreach($sortedMembers as $member)
                <div class="member-row">
                    <div class="member-info">
                        <img src="{{ $member->image ? asset('storage/profile_pic/thumb/'.$member->image) : 'https://via.placeholder.com/50' }}" alt="{{ $member->name }}" class="member-avatar">
                        <div>
                            <div class="member-name">{{ $member->name }}</div>
                            <div class="member-role">{{ $member->email }}</div>
                        </div>
                    </div>
                    <div class="member-status mx-4">
                        @if($group->user_id == $member->id)
                            <span class="owner-badge"><i class="fas fa-crown me-1"></i>Coordinator</span>
                        @elseif($group->leaders->contains($member->id))
                            <span class="leader-badge"><i class="fas fa-shield-alt me-1"></i>Leader</span>
                        @endif
                    </div>
                    <div class="member-actions">
                        @php
                            $isOwner = $group->user_id == Auth::id();
                            $isLeader = $group->leaders->contains(Auth::id());
                        @endphp
                        @if($isOwner && $group->user_id != $member->id)
                            @if($group->leaders->contains($member->id))
                                <form action="{{ route('account.group.demoteLeader') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="user_id" value="{{ $member->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary btn-action">Demote</button>
                                </form>
                            @else
                                <form action="{{ route('account.group.promoteLeader') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <input type="hidden" name="user_id" value="{{ $member->id }}">
                                    <button type="submit" class="btn btn-sm btn-info btn-action">Promote to Leader</button>
                                </form>
                            @endif
                            <form action="{{ route('account.group.removeMember') }}" method="POST" class="d-inline ms-2">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <input type="hidden" name="user_id" value="{{ $member->id }}">
                                <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Are you sure you want to remove this member?')">Remove</button>
                            </form>
                        @elseif($isLeader && $group->user_id != $member->id && !$group->leaders->contains($member->id))
                            {{-- Leaders can remove regular members, but not the coordinator or other leaders --}}
                            <form action="{{ route('account.group.removeMember') }}" method="POST" class="d-inline ms-2">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <input type="hidden" name="user_id" value="{{ $member->id }}">
                                <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Are you sure you want to remove this member?')">Remove</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
