@extends('front.layouts.app')

@section('main')
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 40px;
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
.radio-player {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    border-radius: 20px;
    padding: 40px;
    text-align: center;
    margin-bottom: 30px;
}
.play-button {
    width: 80px;
    height: 80px;
    background: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: #667eea;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.play-button:hover {
    transform: scale(1.1);
}
.live-badge {
    background: #dc3545;
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    margin-bottom: 20px;
}
.live-dot {
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
    margin-right: 8px;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
.schedule-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border-left: 5px solid #667eea;
}
.schedule-card:hover {
    transform: translateY(-3px);
}
.schedule-card.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.volume-control {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
}
.volume-slider {
    flex: 1;
    height: 6px;
    border-radius: 3px;
    background: rgba(255,255,255,0.3);
    outline: none;
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 1rem;">ISM Prayer Radio</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">24/7 spiritual guidance and prayer broadcasts</p>
    </div>
</div>

<div style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        @auth
        @if($radios->isNotEmpty())
        <!-- Radio Stations -->
        <div class="row mb-5">
            @foreach($radios as $index => $radio)
            <div class="col-lg-6 mb-4">
                <div class="radio-player">
                    <div class="live-badge">
                        <div class="live-dot"></div>
                        LIVE
                    </div>
                    <h3 style="color: #333; margin-bottom: 0.5rem;">{{ $radio->name }}</h3>
                    <p style="color: #6c757d; margin-bottom: 1rem;">{{ $radio->description }}</p>
                    @if($radio->genre)
                    <span style="background: rgba(102, 126, 234, 0.1); color: #667eea; padding: 4px 12px; border-radius: 15px; font-size: 0.8rem; margin-bottom: 1rem; display: inline-block;">{{ $radio->genre }}</span>
                    @endif
                    
                    <button class="play-button" onclick="toggleRadio({{ $index }}, '{{ $radio->stream_url }}')">
                        <i class="fas fa-play" id="playIcon{{ $index }}"></i>
                        <i class="fas fa-pause" id="pauseIcon{{ $index }}" style="display: none;"></i>
                    </button>
                    
                    <audio id="radioPlayer{{ $index }}" preload="none" controls style="display: none;">
                        Your browser does not support the audio element.
                    </audio>
                    
                    <div class="volume-control">
                        <i class="fas fa-volume-down" style="color: #667eea;"></i>
                        <input type="range" class="volume-slider" min="0" max="100" value="50" onchange="setVolume({{ $index }}, this.value)">
                        <i class="fas fa-volume-up" style="color: #667eea;"></i>
                    </div>
                    
                    <!-- Schedule for this radio -->
                    @if($radio->schedules->isNotEmpty())
                    <div style="margin-top: 25px; text-align: left; background: rgba(255,255,255,0.9); border-radius: 15px; padding: 20px;">
                        <h5 style="color: #333; margin-bottom: 15px; font-weight: 600; display: flex; align-items: center;"><i class="fas fa-calendar-alt me-2" style="color: #667eea;"></i>Weekly Schedule</h5>
                        <div style="max-height: 250px; overflow-y: auto;">
                            @foreach($radio->schedules->sortBy('day_of_week') as $schedule)
                            <div style="background: white; padding: 15px; margin-bottom: 10px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #667eea;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                            <strong style="color: #333; font-size: 0.95rem;">{{ ucfirst($schedule->day_of_week) }}</strong>
                                            <span style="background: #667eea; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; margin-left: 10px;">{{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</span>
                                        </div>
                                        @if($schedule->program_name)
                                        <div style="color: #333; font-weight: 600; font-size: 0.9rem;">{{ $schedule->program_name }}</div>
                                        @endif
                                        @if($schedule->host_name)
                                        <small style="color: #6c757d;"><i class="fas fa-microphone me-1"></i>{{ $schedule->host_name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="row mb-5">
            <div class="col-12">
                <div class="modern-card text-center">
                    <h3 style="color: #333; margin-bottom: 1rem;">No Radio Stations Available</h3>
                    <p style="color: #6c757d;">Radio stations will appear here once added by administrators</p>
                </div>
            </div>
        </div>
        @endif


        @else
        <div class="row">
            <div class="col-12">
                <div class="modern-card text-center">
                    <h3 style="color: #333; margin-bottom: 1rem;">Access Required</h3>
                    <p style="color: #6c757d; margin-bottom: 2rem;">Please log in to access our 24/7 prayer radio broadcasts</p>
                    <a href="{{ route('account.login') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border-radius: 50px; text-decoration: none; font-weight: 600;">Login to Listen</a>
                </div>
            </div>
        </div>
        @endauth
    </div>
</div>

<script>
let currentPlaying = -1;

function toggleRadio(index, streamUrl) {
    const radioPlayer = document.getElementById('radioPlayer' + index);
    const playIcon = document.getElementById('playIcon' + index);
    const pauseIcon = document.getElementById('pauseIcon' + index);
    
    // Stop any currently playing radio
    if (currentPlaying !== -1 && currentPlaying !== index) {
        const currentPlayer = document.getElementById('radioPlayer' + currentPlaying);
        const currentPlayIcon = document.getElementById('playIcon' + currentPlaying);
        const currentPauseIcon = document.getElementById('pauseIcon' + currentPlaying);
        
        currentPlayer.pause();
        currentPlayer.src = '';
        currentPlayIcon.style.display = 'block';
        currentPauseIcon.style.display = 'none';
    }
    
    if (radioPlayer.paused || radioPlayer.src === '') {
        // Show loading state
        playIcon.className = 'fas fa-spinner fa-spin';
        
        // Try different approaches for different stream types
        if (streamUrl.includes('.m3u8')) {
            // HLS stream
            if (Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource(streamUrl);
                hls.attachMedia(radioPlayer);
                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                    radioPlayer.play().then(() => {
                        playIcon.className = 'fas fa-play';
                        playIcon.style.display = 'none';
                        pauseIcon.style.display = 'block';
                        currentPlaying = index;
                    }).catch(handlePlayError);
                });
            } else if (radioPlayer.canPlayType('application/vnd.apple.mpegurl')) {
                radioPlayer.src = streamUrl;
                radioPlayer.play().then(() => {
                    playIcon.className = 'fas fa-play';
                    playIcon.style.display = 'none';
                    pauseIcon.style.display = 'block';
                    currentPlaying = index;
                }).catch(handlePlayError);
            }
        } else {
            // Regular stream
            radioPlayer.src = streamUrl;
            radioPlayer.load();
            
            // Add event listeners
            radioPlayer.addEventListener('canplay', function() {
                radioPlayer.play().then(() => {
                    playIcon.className = 'fas fa-play';
                    playIcon.style.display = 'none';
                    pauseIcon.style.display = 'block';
                    currentPlaying = index;
                }).catch(handlePlayError);
            }, { once: true });
            
            radioPlayer.addEventListener('error', handlePlayError, { once: true });
        }
        
        function handlePlayError(e) {
            console.error('Error playing radio:', e);
            playIcon.className = 'fas fa-play';
            playIcon.style.display = 'block';
            pauseIcon.style.display = 'none';
            
            // Try alternative approach
            const newWindow = window.open(streamUrl, '_blank');
            if (newWindow) {
                alert('Stream opened in new tab. If it doesn\'t play automatically, try a different browser or check if the stream URL is valid.');
            } else {
                alert('Unable to play radio stream. This may be due to:\n\n1. Invalid stream URL\n2. Stream server is down\n3. Browser compatibility issues\n4. Network connectivity\n\nTry opening the stream URL directly in your browser.');
            }
        }
    } else {
        radioPlayer.pause();
        radioPlayer.src = '';
        playIcon.style.display = 'block';
        pauseIcon.style.display = 'none';
        currentPlaying = -1;
    }
}

function setVolume(index, value) {
    const radioPlayer = document.getElementById('radioPlayer' + index);
    radioPlayer.volume = value / 100;
}umeSlider.addEventListener('input', function() {
    radioPlayer.volume = this.value / 100;
});

// Set initial volume
radioPlayer.volume = 0.5;

// Schedule data
const schedule = [
    { time: '06:00', title: 'Morning Prayer', description: 'Start your day with divine blessings', timeDisplay: '6:00 AM' },
    { time: '09:00', title: 'Bible Study', description: 'Deep dive into scripture', timeDisplay: '9:00 AM' },
    { time: '12:00', title: 'Midday Reflection', description: 'Spiritual guidance for your day', timeDisplay: '12:00 PM' },
    { time: '15:00', title: 'Afternoon Worship', description: 'Praise and worship session', timeDisplay: '3:00 PM' },
    { time: '18:00', title: 'Evening Worship', description: 'Community prayer and praise', timeDisplay: '6:00 PM' },
    { time: '21:00', title: 'Night Prayers', description: 'Peaceful meditation and rest', timeDisplay: '9:00 PM' },
    { time: '00:00', title: 'Midnight Prayer', description: 'Late night intercession', timeDisplay: '12:00 AM' },
    { time: '03:00', title: 'Early Morning Prayer', description: 'Dawn prayer session', timeDisplay: '3:00 AM' }
];

function getCurrentProgram() {
    const now = new Date();
    const currentTime = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    
    let currentProgram = schedule[0];
    for (let i = 0; i < schedule.length; i++) {
        if (currentTime >= schedule[i].time) {
            currentProgram = schedule[i];
        } else {
            break;
        }
    }
    
    return currentProgram;
}

function updateSchedule() {
    const scheduleContainer = document.getElementById('scheduleContainer');
    const currentProgram = getCurrentProgram();
    
    // Update now playing
    document.getElementById('currentProgram').textContent = currentProgram.title;
    
    // Clear and rebuild schedule
    scheduleContainer.innerHTML = '';
    
    schedule.forEach(program => {
        const isActive = program.time === currentProgram.time;
        const col = document.createElement('div');
        col.className = 'col-lg-6 col-md-6';
        
        col.innerHTML = `
            <div class="schedule-card ${isActive ? 'active' : ''}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 style="margin-bottom: 5px; ${isActive ? '' : 'color: #333;'}">${program.title}</h5>
                        <p style="margin: 0; ${isActive ? 'opacity: 0.8;' : 'color: #6c757d;'}">${program.description}</p>
                    </div>
                    <div style="font-weight: 700; font-size: 1.1rem; ${isActive ? '' : 'color: #333;'}">${program.timeDisplay}</div>
                </div>
            </div>
        `;
        
        scheduleContainer.appendChild(col);
    });
}

// Initialize schedule on page load
updateSchedule();

// Update schedule every minute
setInterval(updateSchedule, 60000);
</script>

@endsection