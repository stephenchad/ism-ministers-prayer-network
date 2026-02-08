@extends('front.layouts.app')

@section('title', 'Prayer Room | ISM Ministers Prayer Network')

@section('description', 'Enter the sacred space where heaven meets earth. Join our virtual prayer room for guided prayer, scripture meditation, and community intercession.')

@section('main')
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
}
.modern-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
}
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}
.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}
.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
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
.feature-card {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    margin-bottom: 30px;
    border: 2px solid transparent;
}
.feature-card:hover {
    transform: translateY(-10px);
    border-color: #667eea;
}
.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
}
.prayer-room-section {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    padding: 100px 0;
}
.scripture-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
.gradient-text {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.resource-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.resource-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}
.resource-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}
.featured-resources-section {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 80px 0;
}
</style>

<!--================= Modern Hero Section =================-->
<div class="modern-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Prayer Room</h1>
            <p class="hero-subtitle">Enter the sacred space where heaven meets earth</p>
        </div>
    </div>
</div>

<!--================= Welcome Section =================-->
<div style="padding: 100px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div style="position: relative;">
                    <img src="{{ asset('assets/images/hero/hero1.jpg') }}" alt="Prayer Room" style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);" onerror="this.src='{{ asset('assets/images/preload.png') }}'">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.2rem;">24/7</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div style="padding-left: 40px;">
                    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 2rem;" class="gradient-text">Welcome to Our Virtual Prayer Room</h2>
                    <p style="font-size: 1.1rem; color: #6c757d; line-height: 1.8; margin-bottom: 2rem;">Step into this sacred digital sanctuary where believers from around the world gather in spirit to commune with God. Here, prayer transcends time and space as we unite our hearts in worship, intercession, and thanksgiving.</p>
                    <p style="font-size: 1.1rem; color: #6c757d; line-height: 1.8; margin-bottom: 2rem;">Whether you're seeking peace, guidance, healing, or simply desiring to draw closer to God, this prayer room provides a dedicated space for intimate fellowship with the Divine.</p>
                    <div style="display: flex; gap: 20px; margin-top: 30px;">
                        <a href="#prayer-guide" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Begin Prayer</a>
                        <a href="{{ route('prayers') }}" style="border: 2px solid #667eea; color: #667eea; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#667eea'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#667eea';">Submit Request</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--================= Features Section =================-->
<div style="padding: 100px 0; background: white;">
    <div class="container">
        <div class="text-center" style="margin-bottom: 60px;">
            <h6 style="color: #667eea; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Prayer Room Features</h6>
            <h2 style="font-size: 3rem; font-weight: 700;" class="gradient-text">Experience Sacred Moments</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-praying-hands"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Guided Prayer</h3>
                    <p style="color: #6c757d; line-height: 1.6;">Follow structured prayer guides for different seasons and needs in your spiritual journey.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bible"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Scripture Meditation</h3>
                    <p style="color: #6c757d; line-height: 1.6;">Dive deep into God's Word with curated verses and reflections for prayer and contemplation.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Community Prayer</h3>
                    <p style="color: #6c757d; line-height: 1.6;">Join believers worldwide in united prayer for nations, churches, and global concerns.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!--================= Scripture Section =================-->
<div class="prayer-room-section">
    <div class="container">
        <div class="text-center" style="margin-bottom: 60px;">
            <h2 style="font-size: 3rem; font-weight: 700; color: white; margin-bottom: 1rem;">Daily Scripture Focus</h2>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.9);">Let these words guide your prayer time today</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="scripture-card">
                    <div style="font-size: 4rem; margin-bottom: 20px; color: #667eea;">❝</div>
                    <p style="font-size: 1.3rem; font-style: italic; color: #333; line-height: 1.6; margin-bottom: 20px;">
                        "Pray without ceasing. In everything give thanks: for this is the will of God in Christ Jesus concerning you."
                    </p>
                    <cite style="font-weight: 600; color: #667eea;">- 1 Thessalonians 5:17-18 (KJV)</cite>
                </div>
            </div>
        </div>
    </div>
</div>

<!--================= Prayer Guide Section =================-->
<div id="prayer-guide" style="padding: 100px 0; background: #f8f9fa;">
    <div class="container">
        <div class="text-center" style="margin-bottom: 60px;">
            <h6 style="color: #667eea; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">How to Pray</h6>
            <h2 style="font-size: 3rem; font-weight: 700;" class="gradient-text">Your Prayer Guide</h2>
            <p style="color: #6c757d; margin-top: 1rem;">Simple steps to enrich your prayer experience</p>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="modern-card text-center">
                    <div style="font-size: 3rem; margin-bottom: 20px; color: #667eea;">1</div>
                    <h4 style="margin-bottom: 1rem;">Prepare Your Heart</h4>
                    <p style="color: #6c757d; line-height: 1.6;">Find a quiet place, center your thoughts, and approach God with reverence and expectation.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="modern-card text-center">
                    <div style="font-size: 3rem; margin-bottom: 20px; color: #667eea;">2</div>
                    <h4 style="margin-bottom: 1rem;">Express Gratitude</h4>
                    <p style="color: #6c757d; line-height: 1.6;">Begin with thanksgiving, acknowledging God's goodness and faithfulness in your life.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="modern-card text-center">
                    <div style="font-size: 3rem; margin-bottom: 20px; color: #667eea;">3</div>
                    <h4 style="margin-bottom: 1rem;">Share Your Heart</h4>
                    <p style="color: #6c757d; line-height: 1.6;">Pour out your requests, concerns, and praises honestly before your Heavenly Father.</p>
                </div>
            </div>
        </div>
        <div class="text-center" style="margin-top: 50px;">
            <a href="{{ route('prayer.resources') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-book-open me-2"></i>Explore Prayer Resources
            </a>
        </div>
    </div>
</div>

<!-- Featured Prayer Resources Section -->
@php
    $featured = collect($resources)->merge($videos)->merge($guides)->shuffle()->take(4);
@endphp

@if($featured->isNotEmpty())
<div class="featured-resources-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h3 fw-bold gradient-text mb-3">Featured Prayer Resources</h2>
            <p class="lead text-muted">Discover enriching materials to deepen your prayer life</p>
        </div>
        <div class="row g-4">
            @foreach($featured as $item)
            <div class="col-lg-3 col-md-6">
                <div class="resource-card p-4 text-center">
                    <div class="resource-icon">
                        @if($item->resource_type == 'file')
                            <i class="fas fa-file-pdf"></i>
                        @elseif($item->resource_type == 'video')
                            <i class="fas fa-play"></i>
                        @else
                            <i class="fas fa-book"></i>
                        @endif
                    </div>
                    <h6 class="fw-bold mb-2">{{ Str::limit($item->title, 40) }}</h6>
                    <p class="text-muted small mb-3">{{ Str::limit($item->description, 80) }}</p>
                    @if($item->resource_type == 'file')
                        <a href="{{ route('prayer.download', $item->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-download me-1"></i>Download
                        </a>
                    @elseif($item->resource_type == 'video')
                        @if($item->video_url)
                            <a href="{{ $item->video_url }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-play me-1"></i>Watch
                            </a>
                        @else
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#videoModal{{ $item->id }}">
                                <i class="fas fa-play me-1"></i>Watch
                            </button>
                        @endif
                    @else
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#guideModal{{ $item->id }}">
                            <i class="fas fa-eye me-1"></i>Read
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('prayer.resources') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-right me-2"></i>View All Resources
            </a>
        </div>
    </div>
</div>
@endif

<!-- Guide Modals for Featured Resources -->
@foreach($guides as $guide)
@if(in_array($guide->id, $featured->pluck('id')->toArray()))
<div class="modal fade" id="guideModal{{ $guide->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $guide->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {!! $guide->guide_content !!}
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

<!-- Video Modals for Featured Resources -->
@foreach($videos as $video)
@if($video->video_file && in_array($video->id, $featured->pluck('id')->toArray()))
<div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $video->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <video controls class="w-100" style="max-height: 400px;">
                    <source src="{{ asset($video->video_file) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

<script>
    // Fallback to hide preloader if main.js fails
    setTimeout(function() {
        var preloader = document.getElementById('react__preloader');
        if (preloader) {
            preloader.style.display = 'none';
        }
    }, 2000);
</script>

@endsection
