<?php $__env->startSection('main'); ?>
<style>
.hero-section {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    padding: 4rem 0;
    color: white;
}
.music-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    overflow: hidden;
}
.music-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}
.play-button {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
}
.play-button:hover {
    transform: scale(1.1);
}
</style>

<div class="hero-section">
    <div class="container">
        <div class="text-center">
            <h1 class="display-4 fw-bold mb-3">Worship Music Resources</h1>
            <p class="lead mb-0">Inspirational music to enhance your prayer and worship time</p>
        </div>
    </div>
</div>

<div class="py-5 bg-light">
    <div class="container">
        <!-- Streaming Music Section -->
        <div class="mb-5">
            <h2 class="h3 fw-bold text-center mb-4">Stream Worship Music</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php $__empty_1 = true; $__currentLoopData = $streamingMusic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $music): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col">
                    <div class="music-card h-100">
                        <div class="p-4">
                            <div class="d-flex align-items-center mb-3">
                                <button class="play-button me-3" onclick="playMusic('music-<?php echo e($music->id); ?>')">
                                    <i class="fas fa-play" id="play-icon-<?php echo e($music->id); ?>"></i>
                                    <i class="fas fa-pause" id="pause-icon-<?php echo e($music->id); ?>" style="display: none;"></i>
                                </button>
                                <div>
                                    <h5 class="fw-bold mb-1"><?php echo e($music->title); ?></h5>
                                    <small class="text-muted"><?php echo e($music->artist); ?> <?php if($music->duration): ?>• <?php echo e($music->duration); ?><?php endif; ?></small>
                                </div>
                            </div>
                            <?php if($music->description): ?>
                            <p class="text-muted mb-3"><?php echo e($music->description); ?></p>
                            <?php endif; ?>
                            <audio id="music-<?php echo e($music->id); ?>" preload="none">
                                <source src="<?php echo e(asset($music->file_path)); ?>" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-music fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No streaming music available</h4>
                        <p class="text-muted">Check back later for worship music content.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Download Section -->
        <div class="mb-5">
            <h2 class="h3 fw-bold text-center mb-4">Download Worship Songs</h2>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php $__empty_1 = true; $__currentLoopData = $downloadMusic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $music): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col">
                    <div class="music-card h-100">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1"><?php echo e($music->title); ?></h5>
                                    <small class="text-muted"><?php echo e($music->artist); ?> <?php if($music->file_size): ?>• <?php echo e($music->file_size); ?><?php endif; ?></small>
                                </div>
                                <a href="<?php echo e(asset($music->file_path)); ?>" download class="btn btn-primary btn-sm">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            </div>
                            <?php if($music->description): ?>
                            <p class="text-muted"><?php echo e($music->description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-download fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No downloadable music available</h4>
                        <p class="text-muted">Check back later for worship music downloads.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Back to Prayers -->
        <div class="text-center">
            <a href="<?php echo e(route('prayers')); ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Prayer Center
            </a>
        </div>
    </div>
</div>

<script>
let currentPlaying = null;

function playMusic(audioId) {
    const audio = document.getElementById(audioId);
    const playIcon = document.querySelector(`#${audioId}`).parentElement.querySelector('.fa-play');
    const pauseIcon = document.querySelector(`#${audioId}`).parentElement.querySelector('.fa-pause');
    
    // Stop any currently playing audio
    if (currentPlaying && currentPlaying !== audio) {
        currentPlaying.pause();
        currentPlaying.currentTime = 0;
        // Reset previous play button
        document.querySelectorAll('.fa-play').forEach(icon => icon.style.display = 'block');
        document.querySelectorAll('.fa-pause').forEach(icon => icon.style.display = 'none');
    }
    
    if (audio.paused) {
        audio.play().catch(e => {
            console.error('Error playing audio:', e);
            alert('Unable to play audio. This is a demo - actual music files would be hosted here.');
        });
        playIcon.style.display = 'none';
        pauseIcon.style.display = 'block';
        currentPlaying = audio;
    } else {
        audio.pause();
        playIcon.style.display = 'block';
        pauseIcon.style.display = 'none';
        currentPlaying = null;
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/worship-music.blade.php ENDPATH**/ ?>