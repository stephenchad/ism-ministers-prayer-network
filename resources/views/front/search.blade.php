@extends('front.layouts.app')

@section('main')
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 60px;
    color: white;
    text-align: center;
}
.result-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    padding: 25px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    border-left: 5px solid #667eea;
}
.result-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}
.result-type {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 15px;
}
.no-results {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 20px;">Search Results</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Found {{ $totalResults }} results for "{{ $query }}"</p>
    </div>
</div>

<div style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        @if($totalResults > 0)
            <!-- Groups Results -->
            @if($groups->count() > 0)
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">Prayer Groups ({{ $groups->total() }})</h3>
                    @foreach($groups as $group)
                        <div class="result-card">
                            <span class="result-type">Prayer Group</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">
                                <a href="{{ route('account.group.show', $group->id) }}" style="color: #333; text-decoration: none;">{{ $group->title }}</a>
                            </h4>
                            <p style="color: #555; margin-bottom: 15px;">{{ Str::limit($group->description, 150) }}</p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                <span><i class="fas fa-users" style="margin-right: 5px;"></i>{{ $group->current_members }}/{{ $group->max_members }} Members</span>
                                @if($group->category)
                                <span><i class="fas fa-tag" style="margin-right: 5px;"></i>{{ $group->category->name }}</span>
                                @endif
                                <span><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i>{{ $group->city->name ?? 'N/A' }}, {{ $group->country->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    @endforeach
                    {{ $groups->appends(['q' => $query])->links() }}
                </div>
            @endif

            <!-- Prayer Requests Results -->
            @if($prayers->count() > 0)
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">Prayer Requests ({{ $prayers->total() }})</h3>
                    @foreach($prayers as $prayer)
                        <div class="result-card">
                            <span class="result-type">Prayer Request</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">Prayer by {{ $prayer->name }}</h4>
                            <p style="color: #555; margin-bottom: 15px;">{{ Str::limit($prayer->prayer_request, 200) }}</p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                <span><i class="fas fa-praying-hands" style="margin-right: 5px;"></i>{{ $prayer->prayer_type }}</span>
                                <span><i class="fas fa-clock" style="margin-right: 5px;"></i>{{ $prayer->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                    {{ $prayers->appends(['q' => $query])->links() }}
                </div>
            @endif

            <!-- Testimonies Results -->
            @if($testimonies->count() > 0)
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">Testimonies ({{ $testimonies->total() }})</h3>
                    @foreach($testimonies as $testimony)
                        <div class="result-card">
                            <span class="result-type">Testimony</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">{{ $testimony->title }}</h4>
                            <p style="color: #555; margin-bottom: 15px;">{{ Str::limit($testimony->testimony, 200) }}</p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                <span><i class="fas fa-user" style="margin-right: 5px;"></i>{{ $testimony->name }}</span>
                                <span><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i>{{ $testimony->location }}</span>
                                <span><i class="fas fa-clock" style="margin-right: 5px;"></i>{{ $testimony->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                    {{ $testimonies->appends(['q' => $query])->links() }}
                </div>
            @endif

            <!-- Programs Results -->
            @if($programs->count() > 0)
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">Programs ({{ $programs->total() }})</h3>
                    @foreach($programs as $program)
                        <div class="result-card">
                            <span class="result-type">Program</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">
                                <a href="{{ route('programs.show', $program->slug) }}" style="color: #333; text-decoration: none;">{{ $program->title }}</a>
                            </h4>
                            <p style="color: #555; margin-bottom: 15px;">{{ Str::limit($program->description, 200) }}</p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                @if($program->schedule)
                                <span><i class="fas fa-calendar" style="margin-right: 5px;"></i>{{ $program->schedule }}</span>
                                @endif
                                @if($program->location)
                                <span><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i>{{ $program->location }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    {{ $programs->appends(['q' => $query])->links() }}
                </div>
            @endif

            <!-- News Results -->
            @if($news->count() > 0)
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">News ({{ $news->total() }})</h3>
                    @foreach($news as $newsItem)
                        <div class="result-card">
                            <span class="result-type">News</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">
                                <a href="{{ route('news.show', $newsItem->slug) }}" style="color: #333; text-decoration: none;">{{ $newsItem->title }}</a>
                            </h4>
                            <p style="color: #555; margin-bottom: 15px;">{{ Str::limit($newsItem->excerpt ?: $newsItem->content, 200) }}</p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                @if($newsItem->event_date)
                                <span><i class="fas fa-calendar" style="margin-right: 5px;"></i>{{ $newsItem->event_date->format('M d, Y') }}</span>
                                @endif
                                @if($newsItem->event_location)
                                <span><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i>{{ $newsItem->event_location }}</span>
                                @endif
                                <span><i class="fas fa-clock" style="margin-right: 5px;"></i>{{ $newsItem->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                    {{ $news->appends(['q' => $query])->links() }}
                </div>
            @endif
        @else
            <div class="no-results">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                    <i class="fas fa-search" style="font-size: 2.5rem; color: white;"></i>
                </div>
                <h3 style="color: #333; margin-bottom: 15px; font-weight: 700;">No Results Found</h3>
                <p style="color: #6c757d; margin-bottom: 30px; font-size: 1.1rem;">We couldn't find anything matching "{{ $query }}". Try different keywords or browse our sections.</p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('prayers') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">Browse Prayers</a>
                    <a href="{{ route('testimonies') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">View Testimonies</a>
                    <a href="{{ route('groups.index') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">Join Groups</a>
                    <a href="{{ route('programs.index') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">View Programs</a>
                    <a href="{{ route('news.index') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">Read News</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
