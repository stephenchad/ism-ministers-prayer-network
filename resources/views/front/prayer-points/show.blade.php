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
}
.prayer-content {
    font-size: 1.2rem;
    line-height: 1.8;
    color: #333;
    margin-bottom: 30px;
}
.back-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}
.back-link:hover {
    text-decoration: underline;
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem;">Prayer Point</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">{{ $prayerPoint->title }}</p>
    </div>
</div>

<div style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="modern-card">
                    <h2 style="color: #667eea; margin-bottom: 20px;">{{ $prayerPoint->title ?: ($prayerPoint->title_es ?: ($prayerPoint->title_fr ?: ($prayerPoint->title_zh ?: $prayerPoint->title_ar))) }}</h2>
                    @php
                        $hasMultiple = ($prayerPoint->title_es || $prayerPoint->content_es) ||
                                       ($prayerPoint->title_fr || $prayerPoint->content_fr) ||
                                       ($prayerPoint->title_zh || $prayerPoint->content_zh) ||
                                       ($prayerPoint->title_ar || $prayerPoint->content_ar);
                    @endphp
                    @if($hasMultiple)
                        <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                            @if($prayerPoint->title || $prayerPoint->content)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button" role="tab" aria-controls="en" aria-selected="true">English</button>
                                </li>
                            @endif
                            @if($prayerPoint->title_es || $prayerPoint->content_es)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="es-tab" data-bs-toggle="tab" data-bs-target="#es" type="button" role="tab" aria-controls="es" aria-selected="false">Spanish</button>
                                </li>
                            @endif
                            @if($prayerPoint->title_fr || $prayerPoint->content_fr)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="fr-tab" data-bs-toggle="tab" data-bs-target="#fr" type="button" role="tab" aria-controls="fr" aria-selected="false">French</button>
                                </li>
                            @endif
                            @if($prayerPoint->title_zh || $prayerPoint->content_zh)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="zh-tab" data-bs-toggle="tab" data-bs-target="#zh" type="button" role="tab" aria-controls="zh" aria-selected="false">Mandarin</button>
                                </li>
                            @endif
                            @if($prayerPoint->title_ar || $prayerPoint->content_ar)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="ar-tab" data-bs-toggle="tab" data-bs-target="#ar" type="button" role="tab" aria-controls="ar" aria-selected="false">Arabic</button>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="languageTabsContent">
                            @if($prayerPoint->title || $prayerPoint->content)
                                <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <div class="prayer-content">
                                        {!! nl2br(e($prayerPoint->content)) !!}
                                    </div>
                                </div>
                            @endif
                            @if($prayerPoint->title_es || $prayerPoint->content_es)
                                <div class="tab-pane fade" id="es" role="tabpanel" aria-labelledby="es-tab">
                                    <div class="prayer-content">
                                        {!! nl2br(e($prayerPoint->content_es)) !!}
                                    </div>
                                </div>
                            @endif
                            @if($prayerPoint->title_fr || $prayerPoint->content_fr)
                                <div class="tab-pane fade" id="fr" role="tabpanel" aria-labelledby="fr-tab">
                                    <div class="prayer-content">
                                        {!! nl2br(e($prayerPoint->content_fr)) !!}
                                    </div>
                                </div>
                            @endif
                            @if($prayerPoint->title_zh || $prayerPoint->content_zh)
                                <div class="tab-pane fade" id="zh" role="tabpanel" aria-labelledby="zh-tab">
                                    <div class="prayer-content">
                                        {!! nl2br(e($prayerPoint->content_zh)) !!}
                                    </div>
                                </div>
                            @endif
                            @if($prayerPoint->title_ar || $prayerPoint->content_ar)
                                <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                                    <div class="prayer-content">
                                        {!! nl2br(e($prayerPoint->content_ar)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="prayer-content">
                            {!! nl2br(e($prayerPoint->content ?: ($prayerPoint->content_es ?: ($prayerPoint->content_fr ?: ($prayerPoint->content_zh ?: $prayerPoint->content_ar))))) !!}
                        </div>
                    @endif
                    <p style="color: #6c757d; font-size: 0.9rem;">Shared on {{ $prayerPoint->created_at->format('F j, Y') }}</p>
                    <a href="{{ route('prayer-points.index') }}" class="back-link">← Back to Prayer Points</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
