@extends('front.layouts.app')

@section('main')
<div class="react-wrapper">
    <div class="react-wrapper-inner">
        <!-- Hero Section -->
        @if($program->image)
            <div style="position: relative; height: 400px; background: url('{{ asset('storage/' . $program->image) }}') center/cover; display: flex; align-items: center; justify-content: center;">
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: {{ $program->color }}; opacity: 0.8;"></div>
                <div class="container" style="position: relative; z-index: 1; text-align: center; color: white;">
                    <i class="{{ $program->icon }}" style="font-size: 4rem; margin-bottom: 30px; display: block;"></i>
                    <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 20px;">{{ $program->title }}</h1>
                    <p style="font-size: 1.3rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">{{ $program->description }}</p>
                </div>
            </div>
        @else
            <div style="background: {{ $program->color }}; padding: 120px 0; color: white; text-align: center;">
                <div class="container">
                    <i class="{{ $program->icon }}" style="font-size: 4rem; margin-bottom: 30px; display: block;"></i>
                    <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 20px;">{{ $program->title }}</h1>
                    <p style="font-size: 1.3rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">{{ $program->description }}</p>
                </div>
            </div>
        @endif

        <!-- Program Details -->
        <div style="padding: 100px 0; background: white;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 30px;">About This Program</h2>
                        <p style="font-size: 1.1rem; line-height: 1.8; color: #6c757d; margin-bottom: 40px;">{{ $program['details'] }}</p>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div style="background: #f8f9fa; padding: 30px; border-radius: 15px; text-align: center;">
                                    <i class="fas fa-clock" style="font-size: 2.5rem; color: #667eea; margin-bottom: 20px;"></i>
                                    <h4 style="color: #333; margin-bottom: 15px;">Schedule</h4>
                                    <p style="color: #6c757d; margin: 0;">{{ $program['schedule'] }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div style="background: #f8f9fa; padding: 30px; border-radius: 15px; text-align: center;">
                                    <i class="fas fa-map-marker-alt" style="font-size: 2.5rem; color: #667eea; margin-bottom: 20px;"></i>
                                    <h4 style="color: #333; margin-bottom: 15px;">Location</h4>
                                    <p style="color: #6c757d; margin: 0;">{{ $program['location'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; border-radius: 20px; color: white; text-align: center;">
                            <h3 style="margin-bottom: 20px;">Join This Program</h3>
                            <p style="opacity: 0.9; margin-bottom: 30px;">Ready to be part of this transformative experience?</p>
                            <a href="{{ route('contact') }}" style="background: white; color: #667eea; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                Contact Us
                            </a>
                        </div>
                        
                        <div style="background: #f8f9fa; padding: 30px; border-radius: 15px; margin-top: 30px;">
                            <h4 style="color: #333; margin-bottom: 20px;">Quick Links</h4>
                            <div style="margin-bottom: 15px;">
                                <a href="{{ route('prayers') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">
                                    <i class="fas fa-praying-hands me-2"></i>Submit Prayer Request
                                </a>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <a href="{{ route('groups.index') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">
                                    <i class="fas fa-users me-2"></i>Join Prayer Groups
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('testimonies') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">
                                    <i class="fas fa-heart me-2"></i>Read Testimonies
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Programs -->
        <div style="padding: 50px 0; background: #f8f9fa; text-align: center;">
            <div class="container">
                <a href="{{ route('home') }}#programs" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    ← Back to All Programs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection