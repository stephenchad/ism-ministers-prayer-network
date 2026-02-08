@extends('front.layouts.app')

@section('main')
<div style="padding: 100px 0; background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 style="font-size: 3rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Prayer Coordinators</h1>
            <p style="color: #6c757d; font-size: 1.2rem;">Meet our dedicated prayer coordinators who are here to support you in your spiritual journey</p>
        </div>

        <div class="row">
            @forelse($coordinators as $coordinator)
            <div class="col-lg-4 col-md-6 mb-4">
                <div style="background: white; border-radius: 20px; padding: 40px 30px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.1); height: 100%; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    @if($coordinator->image)
                        <img src="{{ asset($coordinator->image) }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 25px; display: block;" alt="{{ $coordinator->name }}">
                    @else
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; color: white; font-size: 2.5rem; font-weight: 700;">
                            {{ strtoupper(substr($coordinator->name, 0, 2)) }}
                        </div>
                    @endif
                    <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">{{ $coordinator->name }}</h4>
                    <p style="color: #667eea; font-weight: 600; margin-bottom: 15px;">{{ $coordinator->title }}</p>
                    <p style="color: #6c757d; margin-bottom: 25px; line-height: 1.6;">{{ $coordinator->description }}</p>
                    
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 15px; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <i class="fas fa-phone" style="color: #667eea; margin-right: 10px; width: 20px;"></i>
                            <a href="tel:{{ $coordinator->phone }}" style="color: #333; text-decoration: none;">{{ $coordinator->phone }}</a>
                        </div>
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <i class="fas fa-envelope" style="color: #667eea; margin-right: 10px; width: 20px;"></i>
                            <a href="mailto:{{ $coordinator->email }}" style="color: #333; text-decoration: none;">{{ $coordinator->email }}</a>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-clock" style="color: #667eea; margin-right: 10px; width: 20px;"></i>
                            <span style="color: #333;">{{ $coordinator->availability }}</span>
                        </div>
                    </div>
                    
                    <a href="mailto:{{ $coordinator->email }}?subject=Prayer%20Support%20Request&body=Dear%20{{ $coordinator->name }},%0D%0A%0D%0AI%20would%20like%20to%20request%20prayer%20support%20for:%0D%0A%0D%0A[Please%20describe%20your%20prayer%20need%20here]%0D%0A%0D%0AThank%20you%20for%20your%20ministry.%0D%0A%0D%0ABlessings," style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block;">Contact {{ $coordinator->name }}</a>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h4 style="color: #6c757d;">No coordinators available at the moment</h4>
                    <p style="color: #adb5bd;">Please check back later or contact us directly</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                <h3 style="color: #333; margin-bottom: 20px; font-weight: 600;">Need Prayer Support?</h3>
                <p style="color: #6c757d; margin-bottom: 30px; line-height: 1.6;">Our coordinators are here to pray with you, provide spiritual guidance, and connect you with the right prayer groups. Don't hesitate to reach out!</p>
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('prayers') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; display: block;">Submit Prayer Request</a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('groups.index') }}" style="background: white; color: #667eea; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; display: block; border: 2px solid #667eea;">Join Prayer Group</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection