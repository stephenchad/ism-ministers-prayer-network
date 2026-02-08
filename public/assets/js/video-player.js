function togglePlay() {
    const video = document.querySelector('.video-player');
    const playBtn = document.querySelector('.play-pause-btn i');
    const button = document.querySelector('.play-pause-btn');
    
    if (video.paused) {
        video.play();
        playBtn.className = 'fas fa-pause';
        button.style.transform = 'scale(1.2)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 200);
    } else {
        video.pause();
        playBtn.className = 'fas fa-play';
        button.style.transform = 'scale(1.2)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 200);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const video = document.querySelector('.video-player');
    const playBtn = document.querySelector('.play-pause-btn i');
    const overlay = document.querySelector('.video-controls-overlay');
    const wrapper = document.querySelector('.video-player-wrapper');
    
    if (video && playBtn) {
        // Update button icon based on video state
        video.addEventListener('play', function() {
            playBtn.className = 'fas fa-pause';
        });
        
        video.addEventListener('pause', function() {
            playBtn.className = 'fas fa-play';
        });
        
        // Hide overlay when video is playing
        video.addEventListener('play', function() {
            setTimeout(() => {
                if (!video.paused) {
                    overlay.style.opacity = '0';
                    overlay.style.pointerEvents = 'none';
                }
            }, 1500);
        });
        
        // Show overlay when video is paused
        video.addEventListener('pause', function() {
            overlay.style.opacity = '1';
            overlay.style.pointerEvents = 'auto';
        });
        
        // Click on video to play/pause
        video.addEventListener('click', function() {
            togglePlay();
        });
        
        // Mouse movement shows controls temporarily
        wrapper.addEventListener('mousemove', function() {
            if (!video.paused) {
                overlay.style.opacity = '1';
                overlay.style.pointerEvents = 'auto';
                
                clearTimeout(wrapper.hideTimeout);
                wrapper.hideTimeout = setTimeout(() => {
                    if (!video.paused) {
                        overlay.style.opacity = '0';
                        overlay.style.pointerEvents = 'none';
                    }
                }, 2000);
            }
        });
        
        // Loading animation
        video.addEventListener('loadstart', function() {
            wrapper.style.opacity = '0.7';
        });
        
        video.addEventListener('canplay', function() {
            wrapper.style.opacity = '1';
        });
        
        // Add smooth transitions for better UX
        video.addEventListener('waiting', function() {
            overlay.style.opacity = '1';
            playBtn.className = 'fas fa-spinner fa-spin';
        });
        
        video.addEventListener('playing', function() {
            if (playBtn.className.includes('fa-spinner')) {
                playBtn.className = 'fas fa-pause';
            }
        });
    }
});