@extends('front.layouts.app')

@section('main')
<div class="react-wrapper">
    <div class="react-wrapper-inner">
        
        <!-- Page Header -->
        <div style="padding: 120px 0 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center;">
            <div class="container">
                <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 20px;">News & Events</h1>
                <p style="font-size: 1.2rem; opacity: 0.9;">Stay updated with the latest news and upcoming events from ISM Ministers' Prayer Network</p>
            </div>
        </div>

        <!-- News & Events Grid -->
        <div style="padding: 100px 0; background: #f8f9fa;">
            <div class="container">
                <div class="row">
                    @forelse($news as $article)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; cursor: pointer; transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='{{ route('news.show', $article->slug) }}'">
                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $article->title }}">
                                @else
                                    <div style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas {{ $article->type == 'event' ? 'fa-calendar-alt' : 'fa-newspaper' }}" style="font-size: 5rem; color: white;"></i>
                                    </div>
                                @endif
                                <div class="card-body" style="padding: 30px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                        <span style="background: {{ $article->type == 'event' ? '#28a745' : '#667eea' }}; color: white; padding: 8px 20px; border-radius: 25px; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">{{ $article->type }}</span>
                                        <small style="color: #6c757d; font-weight: 600;">{{ $article->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <h4 style="color: #333; margin-bottom: 15px; font-weight: 600; line-height: 1.4;">{{ $article->title }}</h4>
                                    <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6;">{{ Str::limit($article->excerpt, 120) }}</p>
                                    @if($article->type == 'event' && $article->event_date)
                                        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                                <i class="fas fa-calendar" style="color: #667eea; margin-right: 10px;"></i>
                                                <small style="color: #333; font-weight: 600;">{{ $article->event_date->format('F d, Y - g:i A') }}</small>
                                            </div>
                                            @if($article->event_location)
                                                <div style="display: flex; align-items: center;">
                                                    <i class="fas fa-map-marker-alt" style="color: #667eea; margin-right: 10px;"></i>
                                                    <small style="color: #6c757d;">{{ $article->event_location }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div style="color: #667eea; font-weight: 600;">Read More →</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div style="padding: 60px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <i class="fas fa-newspaper" style="font-size: 4rem; color: #6c757d; margin-bottom: 20px;"></i>
                                <h3 style="color: #333; margin-bottom: 15px;">No News or Events Yet</h3>
                                <p style="color: #6c757d;">Check back soon for updates from ISM Ministers' Prayer Network.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($news->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection