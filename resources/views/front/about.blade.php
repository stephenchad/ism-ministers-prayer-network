@extends('front.layouts.app')

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
.stats-section {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    padding: 100px 0;
}
.stats-card {
    background: white;
    border-radius: 20px;
    padding: 40px 20px;
    text-align: center;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    margin-bottom: 30px;
}
.stats-card:hover {
    transform: translateY(-10px);
}
.stats-number {
    font-size: 3rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.team-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    margin-bottom: 30px;
}
.team-card:hover {
    transform: translateY(-10px);
}
.team-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}
.team-info {
    padding: 30px 20px;
    text-align: center;
}
.gradient-text {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<!--================= Modern Hero Section =================-->
<div class="modern-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">About Us</h1>
            <p class="hero-subtitle">Learn about the ISM Ministers Prayer Network</p>
        </div>
    </div>
</div>

<!--================= About Section =================-->
<div style="padding: 100px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div style="position: relative;">
                    <img src="{{ asset('assets/images/about/ab.png') }}" alt="About" style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.2rem;">24/7</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div style="padding-left: 40px;">
                    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 2rem;" class="gradient-text">Welcome to the Prayer Network</h2>
                    <p style="font-size: 1.1rem; color: #6c757d; line-height: 1.8; margin-bottom: 2rem;">We unite ministers around the world in strategic, faith-filled prayer to impact nations.</p>
                    <p style="font-size: 1.1rem; color: #6c757d; line-height: 1.8; margin-bottom: 2rem;">Through prayer groups, resources, and programs, we equip ministers to pray effectively and consistently.</p>
                    <div style="display: flex; gap: 20px; margin-top: 30px;">
                        <a href="{{ route('contact') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Get Support</a>
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
            <h6 style="color: #667eea; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Our Ministry Focus</h6>
            <h2 style="font-size: 3rem; font-weight: 700;" class="gradient-text">How We Serve</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-praying-hands"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">24/7 Prayer</h3>
                    <p style="color: #6c757d; line-height: 1.6;">We maintain continuous prayer coverage every day.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Global Network</h3>
                    <p style="color: #6c757d; line-height: 1.6;">Ministers connected across nations, languages, and cultures.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Support & Care</h3>
                    <p style="color: #6c757d; line-height: 1.6;">We provide prayer support, resources, and guidance.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!--================= Stats Section =================-->
<div class="stats-section">
    <div class="container">
        <div class="text-center" style="margin-bottom: 60px;">
            <h2 style="font-size: 3rem; font-weight: 700; color: white; margin-bottom: 1rem;">Global Impact</h2>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.9);">United in prayer across the world</p>
        </div>
        <div class="row">
            @if(isset($aboutStats) && $aboutStats->isNotEmpty())
                @foreach($aboutStats as $stat)
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stat->value }}</div>
                        <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">{{ $stat->label }}</h4>
                        <p style="color: #6c757d;">{{ $stat->description }}</p>
                    </div>
                </div>
                @endforeach
            @else
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">50k+</div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">Prayer Partners</h4>
                    <p style="color: #6c757d;">Ministers worldwide standing in faith</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">24/7</div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">24/7 Prayer</h4>
                    <p style="color: #6c757d;">Never-ending intercession</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">150+</div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">Countries</h4>
                    <p style="color: #6c757d;">Reaching nations globally</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">365</div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">Days a Year</h4>
                    <p style="color: #6c757d;">Continuous service to the body of Christ</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!--================= Leadership Section =================-->
<div style="padding: 100px 0; background: #f8f9fa;">
    <div class="container">
        <div class="text-center" style="margin-bottom: 60px;">
            <h6 style="color: #667eea; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Leadership Team</h6>
            <h2 style="font-size: 3rem; font-weight: 700;" class="gradient-text">Meet Our Coordinators</h2>
            <p style="color: #6c757d; margin-top: 1rem;">Our regional and national coordinators lead groups and support ministers.</p>
        </div>
        <div class="row">
            @forelse($coordinators as $coordinator)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('coordinators') }}" style="text-decoration: none; color: inherit;">
                    <div class="team-card" style="cursor: pointer;">
                        @if($coordinator->image)
                            <img src="{{ asset($coordinator->image) }}" alt="{{ $coordinator->name }}">
                        @else
                            <div style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 700;">
                                {{ strtoupper(substr($coordinator->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="team-info">
                            <h4 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $coordinator->name }}</h4>
                            <p style="color: #667eea; font-weight: 600; margin-bottom: 1rem;">{{ $coordinator->title }}</p>
                            <p style="color: #6c757d; font-size: 0.9rem;">{{ Str::limit($coordinator->description, 100) }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                        <h4 style="color: #6c757d;">No coordinators available at the moment</h4>
                        <p style="color: #adb5bd;">Coordinators will appear here once they are added by the admin</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        @if($coordinators->isNotEmpty())
        <div class="text-center" style="margin-top: 50px;">
            <a href="{{ route('coordinators') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-phone me-2"></i>Contact Coordinators
            </a>
        </div>
        @endif
    </div>
</div>

@endsection
