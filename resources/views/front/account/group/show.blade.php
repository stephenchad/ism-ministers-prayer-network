@extends('front.layouts.app')

@section('main')
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 60px;
    color: white;
    text-align: center;
}
.modern-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    border: none;
    overflow: hidden;
}
.member-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.member-card:hover {
    transform: translateY(-5px);
}
.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
}
.btn-leave {
    background: #f5576c;
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-leave:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(245, 87, 108, 0.3);
    color: white;
}
.discussion-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.07);
    margin-bottom: 25px;
    border: 1px solid #e9ecef;
}
.discussion-header {
    padding: 20px 25px;
    border-bottom: 1px solid #e9ecef;
}
.discussion-body {
    padding: 25px;
}
.discussion-footer {
    padding: 15px 25px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}
.reply-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}
.reply-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    margin-right: 15px;
    object-fit: cover;
}
.reply-content {
    background: #f1f3f5;
    padding: 10px 15px;
    border-radius: 15px;
    flex-grow: 1;
}
.tab-content {
    padding: 30px 0;
}
.nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    color: #6c757d;
    font-weight: 600;
}
.nav-tabs .nav-link.active {
    background: none;
    border-bottom: 2px solid #667eea;
    color: #667eea;
}
</style>

<div class="modern-hero">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 25px; overflow: hidden;">
                @if($group->image)
                    <img src="{{ asset('storage/'.$group->image) }}" alt="{{ $group->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    <i class="fas fa-users" style="font-size: 2rem;"></i>
                @endif
            </div>
            <div>
                <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 700; margin: 0;">{{ $group->title }}</h1>
                <p style="font-size: 1.2rem; opacity: 0.9; margin: 0;">{{ optional($group->category)->name }}</p>
            </div>
        </div>
        <div style="background: rgba(255,255,255,0.1); padding: 15px 25px; border-radius: 20px; display: inline-block;">
            <div class="d-flex align-items-center gap-4">
                <span><i class="fas fa-users" style="margin-right: 8px;"></i>{{ $group->current_members }}/{{ $group->max_members }} Members</span>
                <span><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>{{ optional($group->city)->name }}, {{ optional($group->country)->name }}</span>
                <span><i class="fas fa-calendar" style="margin-right: 8px;"></i>Active Community</span>
            </div>
        </div>
    </div>
</div>

        <div style="padding: 60px 0; background: #f8f9fa;">
            <div class="container">
                @include('front.message')

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                    @auth
                        @if(!$group->members->contains(Auth::user()))
                            @if($group->current_members < $group->max_members)
                                <form action="{{ route('account.joinGroup') }}" method="post" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <button type="submit" class="btn-modern">
                                        <i class="fas fa-plus-circle me-2"></i>Join This Group
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-warning mt-4">This group is currently full.</div>
                            @endif
                        @else
                            <div class="d-flex align-items-center mt-4 gap-3 flex-wrap">
                                @if(Auth::user()->id == $group->user_id)
                            <div class="alert alert-info mb-0 d-flex align-items-center justify-content-center" style="min-width: 220px; height: 40px; font-weight: 600; font-size: 0.9rem;">
                                You are the creator of this group.
                            </div>
                            <button type="button" class="btn btn-warning d-flex align-items-center justify-content-center" style="min-width: 220px; height: 40px; font-weight: 600; font-size: 0.9rem;" data-bs-toggle="modal" data-bs-target="#transferOwnershipModal">
                                <i class="fas fa-crown me-2"></i>Transfer Coordinator
                            </button>
                        @else
                            <div class="alert alert-success mb-0 d-flex align-items-center justify-content-center" style="min-width: 220px; height: 40px; font-weight: 600; font-size: 0.9rem;">
                                You are a member of this group.
                            </div>
                            <form action="{{ route('account.leaveGroup') }}" method="post" class="d-flex align-items-center justify-content-center" style="min-width: 220px; height: 40px;">
                                @csrf
                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                <button type="submit" class="btn-leave d-flex align-items-center justify-content-center" style="min-width: 220px; height: 40px; font-weight: 600; font-size: 0.9rem;">
                                    <i class="fas fa-sign-out-alt me-2"></i>Leave Group
                                </button>
                            </form>
                        @endif
                    </div>
                        @endif
                    @else
                        <div class="text-center">
                            <p class="mb-3">Join this group to participate in discussions and events.</p>
                            <form action="{{ route('login') }}" method="POST" class="d-inline-block text-start" style="max-width: 400px;">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Login to Join</button>
                                <p class="mt-3 mb-0">Do not have an account? <a href="{{ route('register') }}">Register here</a></p>
                            </form>
                        </div>
                    @endauth

        <div class="mt-4 d-flex gap-2">
            @can('update', $group)
            <a href="{{ route('account.group.edit', $group->id) }}" class="btn btn-secondary"><i class="fas fa-edit me-2"></i>Edit Group Details</a>
            @endcan
            @can('manageMembers', $group)
            <a href="{{ route('account.group.manageMembers', $group->id) }}" class="btn btn-info"><i class="fas fa-users-cog me-2"></i>Manage Members</a>
            @endcan
        </div>

                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="groupTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button" role="tab" aria-controls="members" aria-selected="false">Members</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="false">Gallery</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="discussions-tab" data-bs-toggle="tab" data-bs-target="#discussions" type="button" role="tab" aria-controls="discussions" aria-selected="false">Discussions</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="groupTabsContent">
                                    <!-- Rules Section -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <p style="color: #555; line-height: 1.8; font-size: 1.1rem; margin-bottom: 30px;">
                    @if(empty($group->description) || str_contains(strtolower($group->description), 'lorem ipsum'))
                        Welcome to {{ $group->title }}! This is a faith-based community where members come together for prayer, fellowship, and spiritual growth.
                    @else
                        {{ $group->description }}
                    @endif
                </p>
                <div class="row">
                    <!-- Rules Section -->
                    <div class="col-12 col-lg-6">
                        <div class="modern-card" style="height: 100%;">
                            <div style="padding: 30px;">
                                <h4 style="color: #333; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center;">
                                    <i class="fas fa-list-ul" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 15px; font-size: 1rem;"></i>
                                    Rules and Guidelines
                                </h4>
                                @forelse ($group->rules as $rule)
                                    <div style="background: #f8f9fa; padding: 15px 20px; border-radius: 15px; margin-bottom: 10px; border-left: 4px solid #667eea;">
                                        <p style="margin: 0; color: #555;">{{ $rule->rule }}</p>
                                    </div>
                                @empty
                                    <p style="color: #6c757d; text-align: center; padding: 20px;">No rules have been set for this group.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- Events Section -->
                    <div class="col-12 col-lg-6">
                        <div class="modern-card">
                            <div style="padding: 30px;">
                                <h4 style="color: #333; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center;">
                                    <i class="fas fa-calendar-alt" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 15px; font-size: 1rem;"></i>
                                    Upcoming Events
                                </h4>
                                @forelse ($group->events as $event)
                                    <div style="background: #f8f9fa; border-radius: 15px; padding: 25px; margin-bottom: 15px; border-left: 4px solid #667eea;">
                                        <h5 style="color: #333; font-weight: 700; margin-bottom: 10px;">{{ $event->title }}</h5>
                                        <p style="color: #555; margin-bottom: 15px;">{{ $event->description }}</p>
                                        <div style="display: flex; align-items: center; color: #6c757d;">
                                            <i class="fas fa-clock" style="margin-right: 8px;"></i>
                                            <span>{{\Carbon\Carbon::parse($event->event_date)->format('M d, Y, h:i A') }} - {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y, h:i A') }}</span>
                                            <i class="fas fa-map-marker-alt" style="margin-left: 20px; margin-right: 8px;"></i>
                                            <span>{{ $event->location }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p style="color: #6c757d; text-align: center; padding: 20px;">No upcoming events scheduled.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- Resources Section -->
                    <div class="col-12 mt-4">
                        <div class="modern-card" style="height: 100%;">
                            <div style="padding: 30px;">
                                <h4 style="color: #333; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center;">
                                    <i class="fas fa-link" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 15px; font-size: 1rem;"></i>
                                    Resource Links
                                </h4>
                                @forelse ($group->resources as $resource)
                                    <div style="background: #f8f9fa; padding: 15px 20px; border-radius: 15px; margin-bottom: 10px; border-left: 4px solid #667eea;">
                                        <a href="{{ $resource->link }}" target="_blank" style="color: #667eea; text-decoration: none; font-weight: 600;">
                                            <i class="fas fa-external-link-alt" style="margin-right: 8px;"></i>{{ $resource->title }}
                                        </a>
                                    </div>
                                @empty
                                    <p style="color: #6c757d; text-align: center; padding: 20px;">No resources shared yet.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Members Section -->
            <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                <div class="modern-card" style="height: 100%;">
                    <div style="padding: 30px;">
                        <h4 style="color: #333; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center;">
                            <i class="fas fa-users" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 15px; font-size: 1rem;"></i>
                            Members ({{ $group->members->count() }})
                        </h4>

                        @forelse ($sortedMembers as $member)
                            <div class="member-card mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 50%; display: flex; align-items-center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">
                                            @if($member->image)
                                                <img src="{{ asset('storage/profile_pic/thumb/'.$member->image) }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                            @else
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 style="margin: 0; color: #333; font-weight: 600; font-size: 0.9rem;">{{ $member->name }}</h6>
                                        <small style="color: #6c757d;">
                                            @if($group->user_id == $member->id)
                                                Owner
                                            @elseif($group->leaders->contains($member->id))
                                                Leader
                                            @else
                                                Member
                                            @endif
                                        </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p style="color: #6c757d; text-align: center; padding: 20px;">No members yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Gallery Section -->
            <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                <div class="modern-card" style="height: 100%;">
                    <div style="padding: 30px;">
                        <h4 style="color: #333; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center;">
                            <i class="fas fa-images" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 15px; font-size: 1rem;"></i>
                            Photo Gallery
                        </h4>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3" id="photo-gallery">
                            @forelse ($group->photos as $photo)
                                <div class="col position-relative">
                                    <a href="{{ asset('storage/'.$photo->path) }}" class="gallery-item" title="{{ $photo->caption }}">
                                        <img src="{{ asset('storage/'.$photo->path) }}" class="img-fluid" alt="{{ $photo->caption }}" style="border-radius: 10px; aspect-ratio: 1; object-fit: cover;">
                                    </a>
                                    @can('managePhotos', $group)
                                        <form action="{{ route('group.photo.destroy', $photo->id) }}" method="POST" class="position-absolute top-0 end-0 p-2" style="z-index: 1;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-circle" onclick="return confirm('Are you sure you want to delete this photo?')" style="width: 30px; height: 30px; line-height: 1; padding: 0;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            @empty
                                <div class="col-12">
                                    <p style="color: #6c757d; text-align: center; padding: 20px;">No photos shared yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Discussions Section -->
            <div class="tab-pane fade" id="discussions" role="tabpanel" aria-labelledby="discussions-tab">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-dark mb-0 d-flex align-items-center">
                        <i class="fas fa-comments" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 15px; font-size: 1rem;"></i>
                        Group Discussions
                    </h4>
                    <button class="btn-modern" data-bs-toggle="modal" data-bs-target="#newDiscussionModal">
                        <i class="fas fa-plus me-2"></i>Start New Discussion
                    </button>
                </div>

                <div class="discussion-list">
                    @forelse ($group->discussions as $discussion)
                        <div class="discussion-card">
                            <div class="discussion-header d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                        @if($discussion->user->image)
                                            <img src="{{ asset('storage/profile_pic/thumb/'.$discussion->user->image) }}" alt="{{ $discussion->user->name }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            {{ strtoupper(substr($discussion->user->name ?? 'A', 0, 1)) }}
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-0">{{ $discussion->title }}</h5>
                                    <small class="text-muted">
                                        Posted by <strong>{{ $discussion->user->name ?? 'Anonymous' }}</strong> &bull; {{ $discussion->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                            <div class="discussion-body">
                                <p class="text-secondary mb-0" style="line-height: 1.7;">{{ $discussion->content }}</p>
                            </div>
                            <div class="discussion-footer">
                                <a class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="collapse" href="#replies-{{ $discussion->id }}" role="button" aria-expanded="false" aria-controls="replies-{{ $discussion->id }}">
                                    <i class="fas fa-reply me-1"></i> View Replies ({{ $discussion->replies->count() }})
                                </a>
                            </div>
                            <!-- Replies Section -->
                            <div class="collapse" id="replies-{{ $discussion->id }}">
                                <div class="p-4">
                                    @forelse($discussion->replies as $reply)
                                        <div class="reply-item">
                                            <img src="{{ $reply->user->image ? asset('storage/profile_pic/thumb/'.$reply->user->image) : 'https://via.placeholder.com/35' }}" alt="{{ $reply->user->name }}" class="reply-avatar">
                                            <div class="reply-content">
                                                <p class="mb-1 text-dark">{{ $reply->content }}</p>
                                                <small class="text-muted">
                                                    <strong>{{ $reply->user->name ?? 'Anonymous' }}</strong> &bull; {{ $reply->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted small ms-5">No replies yet.</p>
                                    @endforelse
                                    <!-- Reply Form -->
                                    <form action="{{ route('discussion.reply.store') }}" method="POST" class="mt-3 ms-5 reply-form">
                                        @csrf
                                        <input type="hidden" name="discussion_id" value="{{ $discussion->id }}">
                                        <div class="input-group">
                                            <input type="text" name="content" class="form-control form-control-sm" placeholder="Write a reply..." required>
                                            <button class="btn btn-sm btn-primary" type="submit">Post</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-5 bg-light rounded-3">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No discussions yet. Be the first to start one!</p>
                        </div>
                    @endforelse
                </div>
            </div>
            


        </div>
    </div>
</div>

<!-- New Discussion Modal -->
<div class="modal fade" id="newDiscussionModal" tabindex="-1" aria-labelledby="newDiscussionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-bottom: none;">
                <h5 class="modal-title" id="newDiscussionModalLabel">Start a New Discussion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="newDiscussionForm" action="{{ route('discussion.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required placeholder="Enter a clear and concise title">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Message</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required placeholder="Share your thoughts, questions, or prayer points..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modern">
                        <i class="fas fa-paper-plane me-2"></i>Post Discussion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Transfer Coordinator Modal -->
@if(Auth::check() && Auth::user()->id == $group->user_id)
<div class="modal fade" id="transferOwnershipModal" tabindex="-1" aria-labelledby="transferOwnershipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: white; border-bottom: none;">
                <h5 class="modal-title" id="transferOwnershipModalLabel">Transfer Group Coordinator</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('account.transferCoordinator') }}" method="POST">
                @csrf
                <input type="hidden" name="group_id" value="{{ $group->id }}">
                <div class="modal-body">
                    <p>Please select a member to transfer coordinator to. This action is irreversible.</p>
                    <div class="form-group">
                        <label for="new_owner_id" class="form-label fw-bold">New Coordinator</label>
                        <select name="new_owner_id" id="new_owner_id" class="form-select" required>
                            <option value="">Select a member...</option>
                            @foreach($group->members as $member)
                                @if($member->id !== Auth::user()->id)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-warning mt-3">
                        <strong>Warning:</strong> You will no longer be the group coordinator and will lose administrative privileges for this group.
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to transfer coordinator? This action cannot be undone.')">Confirm Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('customJS')
<script>
$(document).ready(function() {
    // Initialize Magnific Popup only when Gallery tab is shown
    $('button[data-bs-target="#gallery"]').on('shown.bs.tab', function () {
        $('#photo-gallery').magnificPopup({
            delegate: 'a.gallery-item',
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1]
            }
        });
    });

    // Handle new discussion form submission with AJAX
    $('#newDiscussionForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Posting...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    // Hide modal
                    $('#newDiscussionModal').modal('hide');
                    // Reset form
                    form[0].reset();

                    var discussion = response.discussion;
                    var user = response.user;

                    var userAvatarHtml = '';
                    if (user.image) {
                        userAvatarHtml = `<img src="{{ asset('storage/profile_pic/thumb/') }}/${user.image}" alt="${user.name}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">`;
                    } else {
                        userAvatarHtml = `${user.name.charAt(0).toUpperCase()}`;
                    }

                    var newDiscussionHtml = `
                        <div class="discussion-card">
                            <div class="discussion-header d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items-center; justify-content: center; color: white; font-weight: 700;">
                                        ${userAvatarHtml}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-0">${discussion.title}</h5>
                                    <small class="text-muted">
                                        Posted by <strong>${user.name}</strong> &bull; just now
                                    </small>
                                </div>
                            </div>
                            <div class="discussion-body">
                                <p class="text-secondary mb-0" style="line-height: 1.7;">${discussion.content}</p>
                            </div>
                            <div class="discussion-footer">
                                <a class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="collapse" href="#replies-${discussion.id}" role="button" aria-expanded="false" aria-controls="replies-${discussion.id}">
                                    <i class="fas fa-reply me-1"></i> View Replies (0)
                                </a>
                            </div>
                            <div class="collapse" id="replies-${discussion.id}">
                                <div class="p-4">
                                    <p class="text-muted small ms-5">No replies yet.</p>
                                    <form action="{{ route('discussion.reply.store') }}" method="POST" class="mt-3 ms-5 reply-form">
                                        @csrf
                                        <input type="hidden" name="discussion_id" value="${discussion.id}">
                                        <div class="input-group">
                                            <input type="text" name="content" class="form-control form-control-sm" placeholder="Write a reply..." required>
                                            <button class="btn btn-sm btn-primary" type="submit">Post</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;

                    // Remove the 'no discussions' message if it exists
                    $('.discussion-list .text-center.p-5').remove();

                    // Prepend the new discussion to the list
                    $('.discussion-list').prepend(newDiscussionHtml);
                } else {
                    // Handle errors (e.g., display validation messages)
                    alert('Error: ' + JSON.stringify(response.errors));
                }
            },
            error: function() {
                alert('An unexpected error occurred. Please try again.');
            },
            complete: function() {
                submitButton.prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i>Post Discussion');
            }
        });
    });

    // Handle reply form submission with AJAX
    $('.discussion-list').on('submit', '.reply-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        var discussionId = form.find('input[name="discussion_id"]').val();
        var contentInput = form.find('input[name="content"]');

        submitButton.prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    var reply = response.reply;
                    var userName = response.user_name;
                    var userAvatar = response.user_avatar;

                    var newReplyHtml = `
                        <div class="reply-item">
                            ${userAvatar}
                            <div class="reply-content">
                                <p class="mb-1 text-dark">${reply.content}</p>
                                <small class="text-muted">
                                    <strong>${userName}</strong> &bull; just now
                                </small>
                            </div>
                        </div>
                    `;

                    // Find the reply list and append the new reply
                    var repliesContainer = form.closest('.collapse').find('.p-4');
                    
                    // Remove "No replies yet" message if it exists
                    repliesContainer.find('p.text-muted.small').remove();

                    // Insert the new reply before the form
                    form.before(newReplyHtml);

                    // Clear the input field
                    contentInput.val('');

                    // Update reply count
                    var replyCountLink = $(`a[href="#replies-${discussionId}"]`);
                    var currentCount = parseInt(replyCountLink.text().match(/\d+/)[0]);
                    replyCountLink.html(`<i class="fas fa-reply me-1"></i> View Replies (${currentCount + 1})`);

                } else {
                    alert('Error: ' + JSON.stringify(response.errors));
                }
            },
            error: function() {
                alert('An unexpected error occurred. Please try again.');
            },
            complete: function() {
                submitButton.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection