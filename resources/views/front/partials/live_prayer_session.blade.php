<div style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Live Prayer</h2>
            <p style="color: #6c757d; font-size: 1.1rem;">Join the ongoing session or check back soon</p>
        </div>
        @if($streams->isNotEmpty())
            @php $stream = $streams->first() @endphp
            <div class="modern-card mx-auto" style="max-width: 700px;">
                <div class="video-player" style="position: relative;">
                    <video id="live-prayer-player" style="width: 100%; height: 400px; border-radius: 15px; background: #000;">
                        @if($stream->format === 'hls')
                            <source src="{{ $stream->stream_url }}" type="application/x-mpegURL">
                        @else
                            <source src="{{ $stream->stream_url }}" type="video/mp4">
                        @endif
                        Your browser does not support the video tag.
                    </video>
                    <div id="stream-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; text-align: center; border-radius: 15px;">
                        <div>
                            <i class="fas fa-lock" style="font-size: 2rem; margin-bottom: 10px;"></i><br>
                            Please complete the form to join the live prayer session.
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px; text-align: center;">
                    <h3 id="live-prayer-title" style="color: #333; margin-bottom: 10px;">Now Playing: {{ $stream->title }}</h3>
                    <p id="live-prayer-description" style="color: #6c757d;">{{ $stream->description ?? 'Join us in prayer.' }}</p>
                    <button id="join-live-prayer-btn" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 8px; font-weight: 600;">Join Live Prayer</button>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-video" style="font-size: 4rem; color: #dee2e6; margin-bottom: 20px;"></i>
                <h4 style="color: #6c757d;">No live sessions at the moment</h4>
                <p style="color: #adb5bd;">Please check back later.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="livePrayerModal" tabindex="-1" aria-labelledby="livePrayerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 15px;">
      <div class="modal-header">
        <h5 class="modal-title" id="livePrayerModalLabel">Join Live Prayer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="livePrayerForm">
          <div class="modal-body">
              <input type="hidden" name="stream_id" value="{{ $stream->id ?? '' }}">
              <div class="mb-3">
                  <label for="name" class="form-label">Name *</label>
                  <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                  <label for="email" class="form-label">Email *</label>
                  <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                  <label for="phone" class="form-label">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone">
              </div>
              <div class="mb-3">
                  <label for="country" class="form-label">Country *</label>
                  <input type="text" class="form-control" id="country" name="country" required>
              </div>
              <div class="mb-3">
                  <label for="gender" class="form-label">Gender *</label>
                  <select class="form-select" id="gender" name="gender" required>
                      <option value="" selected disabled>Select gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                  </select>
              </div>
              <div class="mb-3">
                  <label for="participants_count" class="form-label">Number of Participants *</label>
                  <input type="number" class="form-control" id="participants_count" name="participants_count" min="1" required>
              </div>
              <div id="formError" class="text-danger mb-3" style="display:none;"></div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Join Now</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
let hlsLive = null;
let formSubmitted = false;

document.addEventListener('DOMContentLoaded', function() {
    const streams = @json($streams);
    console.log('Available streams:', streams);

    if (streams.length > 0) {
        const stream = streams[0];
        const player = document.getElementById('live-prayer-player');
        const overlay = document.getElementById('stream-overlay');

        // Disable controls until form is submitted
        player.controls = false;

        console.log('Loading stream:', stream);

        // Add error handling to video element
        player.addEventListener('error', function(e) {
            console.error('Video error:', e);
            alert('Unable to load the live stream. Please check your connection and try again.');
        });

        player.addEventListener('loadstart', function() {
            console.log('Video load started');
        });

        player.addEventListener('canplay', function() {
            console.log('Video can play');
        });

        player.addEventListener('play', function() {
            console.log('Video started playing');
        });

        player.addEventListener('pause', function() {
            console.log('Video paused');
        });

        // Prevent play if form not submitted
        player.addEventListener('play', function(e) {
            if (!formSubmitted) {
                e.preventDefault();
                player.pause();
                alert('Please fill out the participation form first.');
            }
        });

        if (stream.format === 'hls') {
            if (Hls.isSupported()) {
                console.log('Using HLS.js for HLS stream');
                hlsLive = new Hls({
                    debug: true,
                    enableWorker: false
                });

                hlsLive.loadSource(stream.stream_url);
                hlsLive.attachMedia(player);

                hlsLive.on(Hls.Events.MANIFEST_PARSED, function() {
                    console.log('HLS manifest parsed, ready to play after form submission');
                });

                hlsLive.on(Hls.Events.ERROR, function(event, data) {
                    console.error('HLS error:', data);
                    if (data.fatal) {
                        switch(data.type) {
                            case Hls.ErrorTypes.NETWORK_ERROR:
                                alert('Network error while loading stream. Please check your connection.');
                                break;
                            case Hls.ErrorTypes.MEDIA_ERROR:
                                alert('Media error. Trying to recover...');
                                hlsLive.recoverMediaError();
                                break;
                            default:
                                alert('An error occurred while loading the stream.');
                                hlsLive.destroy();
                                break;
                        }
                    }
                });

            } else if (player.canPlayType('application/vnd.apple.mpegurl')) {
                console.log('Using native HLS support');
                player.src = stream.stream_url;
                player.addEventListener('loadedmetadata', function() {
                    console.log('Native HLS loaded, ready to play after form submission');
                });
            } else {
                console.error('HLS not supported');
                alert('Your browser does not support HLS streaming.');
            }
        } else {
            console.log('Using direct video source');
            player.src = stream.stream_url;
            player.addEventListener('loadedmetadata', function() {
                console.log('Video metadata loaded, ready to play after form submission');
            });
        }
    } else {
        console.log('No active streams available');
    }

    // Move event listeners inside DOMContentLoaded to ensure elements exist
    const joinBtn = document.getElementById('join-live-prayer-btn');
    const prayerForm = document.getElementById('livePrayerForm');
    
    if (joinBtn) {
        joinBtn.addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('livePrayerModal'));
            modal.show();
        });
    }
    
    if (prayerForm) {
        prayerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var form = e.target;
            var formData = new FormData(form);
            var errorDiv = document.getElementById('formError');
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';

            fetch("{{ route('stream.participate') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('livePrayerModal'));
                    modal.hide();
                    // Enable and start playing the stream after submission
                    formSubmitted = true;
                    var overlay = document.getElementById('stream-overlay');
                    if (overlay) {
                        overlay.style.display = 'none';
                    }
                    var player = document.getElementById('live-prayer-player');
                    if (player) {
                        player.controls = true;
                        player.play();
                    }
                    alert(data.message);
                } else {
                    errorDiv.style.display = 'block';
                    errorDiv.textContent = data.message || 'An error occurred. Please try again.';
                }
            })
            .catch((error) => {
                console.error('Form submission error:', error);
                errorDiv.style.display = 'block';
                errorDiv.textContent = 'Network error. Please check your connection and try again.';
            });
        });
    }
});
</script>
