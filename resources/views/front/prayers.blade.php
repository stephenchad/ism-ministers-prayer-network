@extends('front.layouts.app')

@section('main')
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 120px 0 80px;
    color: white;
    text-align: center;
}
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 40px;
    margin-bottom: 30px;
    transition: transform 0.3s ease;
}
.modern-card:hover {
    transform: translateY(-5px);
}
.prayer-tab {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 15px 30px;
    margin: 0 10px;
    transition: all 0.3s ease;
}
.prayer-tab.active {
    background: white;
    color: #667eea;
}
.form-floating {
    margin-bottom: 20px;
}
.form-floating input, .form-floating select, .form-floating textarea {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 20px 15px;
}
.form-floating input:focus, .form-floating select:focus, .form-floating textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50px;
    padding: 15px 40px;
    color: white;
    font-weight: 600;
}
.prayer-wall-item {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem;">Prayer and Support</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Share your prayer request or pray with others</p>
    </div>
</div>

<div style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <button class="prayer-tab active" onclick="showTab('request')">Submit Request</button>
            <button class="prayer-tab" onclick="showTab('wall')">Prayer Wall</button>
            <button class="prayer-tab" onclick="showTab('resources')">Resources</button>
        </div>

        <div id="request" class="tab-content">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="modern-card">
                        <h3 class="text-center mb-4" style="color: #667eea;">Submit a Prayer Request</h3>
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        <form action="{{ route('prayer.request') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name">
                                        <label for="name">Name (optional)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Your Email">
                                        <label for="email">Email (optional)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="prayer_type" class="form-control" id="prayerType" required>
                                            <option value="">Select Prayer Type</option>
                                            @foreach($prayerTypes as $type)
                                                <option value="{{ $type->slug }}">{{ $type->icon }} {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="prayerType">Prayer Category</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="language" class="form-control" id="language" required>
                                            <option value="">Select language</option>
                                            <option value="en">English</option>
                                            <option value="es">Español</option>
                                            <option value="fr">Français</option>
                                            <option value="pt">Português</option>
                                            <option value="de">Deutsch</option>
                                        </select>
                                        <label for="language">Language</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea name="prayer_request" class="form-control" id="prayerRequest" style="height: 150px" placeholder="Share your prayer request..." required></textarea>
                                        <label for="prayerRequest">Your prayer request</label>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn-modern">Submit Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="wall" class="tab-content" style="display: none;">
            <div class="modern-card">
                <h3 class="text-center mb-4" style="color: #667eea;">Prayer Wall</h3>
                @forelse($prayerRequests as $request)
                    <div class="prayer-wall-item">
                        <h5>
                            @php
                                $type = $prayerTypes->firstWhere('slug', $request->prayer_type);
                            @endphp
                            {{ $type->icon ?? '💝' }} {{ $type->name ?? ucfirst($request->prayer_type) }} Prayer
                        </h5>
                        <p>{{ Str::limit($request->prayer_request, 150) }}</p>
                        <small class="text-muted">
                            {{ $request->created_at ? $request->created_at->diffForHumans() : 'Recently' }}
                            @if($request->name) • by {{ $request->name }} @endif
                        </small>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-praying-hands fa-3x"></i>
                        </div>
                        <h3>No prayer requests yet</h3>
                        <p>Be the first to submit a prayer request</p>
                        <a href="#request" onclick="showTab('request')" class="btn-primary-gradient">
                            Submit a Prayer Request
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <div id="resources" class="tab-content" style="display: none;">
            <div class="row">
                <div class="col-md-4">
                    <a href="{{ route('prayer.resources') }}" style="text-decoration: none; color: inherit;">
                        <div class="modern-card text-center" style="cursor: pointer;">
                            <div style="font-size: 3rem; margin-bottom: 20px;">📖</div>
                            <h4>Prayer Guides</h4>
                            <p>Explore guides to strengthen your prayer life.</p>
                            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 20px; border-radius: 25px; display: inline-block; margin-top: 15px; font-weight: 600;">View Resources</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('worship.music') }}" style="text-decoration: none; color: inherit;">
                        <div class="modern-card text-center" style="cursor: pointer;">
                            <div style="font-size: 3rem; margin-bottom: 20px;">🎵</div>
                            <h4>Worship Music</h4>
                            <p>Listen to inspiring worship music.</p>
                            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 20px; border-radius: 25px; display: inline-block; margin-top: 15px; font-weight: 600;">Listen Now</div>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="modern-card text-center">
                        <div style="font-size: 3rem; margin-bottom: 20px;">📱</div>
                        <h4>Prayer Apps</h4>
                        <p>Helpful apps to support your prayer time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
    document.querySelectorAll('.prayer-tab').forEach(btn => btn.classList.remove('active'));
    document.getElementById(tabName).style.display = 'block';
    event.target.classList.add('active');
}
</script>

@endsection