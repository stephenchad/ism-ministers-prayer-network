<?php $__env->startSection('main'); ?>
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 50px;
    color: white;
    text-align: center;
}
@media (min-width: 768px) {
    .modern-hero {
        padding: 100px 0 60px;
    }
}
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 30px;
    margin-bottom: 30px;
    transition: transform 0.3s ease;
    border: none;
}
.modern-card:hover {
    transform: translateY(-5px);
}
.group-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: none;
    height: 100%;
}
.group-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}
.group-image {
    height: 200px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 700;
}
@media (min-width: 768px) {
    .group-image {
        font-size: 3rem;
    }
}
.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50px;
    padding: 10px 20px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}
@media (min-width: 768px) {
    .btn-modern {
        padding: 12px 30px;
    }
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
}
.btn-outline-modern {
    border: 2px solid #667eea;
    color: #667eea;
    border-radius: 25px;
    padding: 6px 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}
@media (min-width: 768px) {
    .btn-outline-modern {
        padding: 8px 20px;
    }
}
.btn-outline-modern:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
}
.stats-badge {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}
@media (min-width: 768px) {
    .stats-badge {
        padding: 5px 15px;
        font-size: 0.85rem;
    }
}
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}
@media (min-width: 768px) {
    .empty-state {
        padding: 80px 20px;
    }
}
/* Make images responsive */
.group-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Responsive Modal Styles */
@media (max-width: 991px) {
    #meetingModal .modal-body {
        padding: 15px !important;
    }
    #meetingModal .modal-header {
        padding: 15px 20px !important;
    }
    #meetingModal .modal-header i {
        font-size: 1rem !important;
        width: 35px !important;
        height: 35px !important;
    }
    #meetingModal .modal-header p {
        font-size: 0.8rem !important;
    }
    #media-container {
        height: 300px !important;
    }
    #meetingModal .col-lg-4 {
        margin-top: 15px;
    }
    #meetingModal .col-lg-4 > div {
        height: 350px !important;
    }
    #meetingModal .col-lg-4 > div > div:first-child {
        padding: 15px !important;
    }
    #meetingModal .col-lg-4 > div > div:first-child i {
        font-size: 1.2rem !important;
    }
    #meetingModal .col-lg-4 > div > div:first-child h5 {
        font-size: 1rem !important;
    }
    #meetingModal .col-lg-4 > div > div:first-child p {
        font-size: 0.75rem !important;
    }
    #chatBox {
        padding: 15px !important;
    }
    #chatBox p {
        font-size: 0.85rem !important;
    }
    #chatMessageInput {
        padding: 10px 15px !important;
        font-size: 0.9rem !important;
    }
    #sendMessageBtn {
        padding: 10px 15px !important;
    }
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.75rem;">Prayer Groups</h1>
        <p style="font-size: 1rem; opacity: 0.9;">Connect with fellow believers in our community groups</p>
    </div>
</div>
<style>
@media (min-width: 768px) {
    .modern-hero h1 {
        font-size: 3.5rem !important;
        margin-bottom: 1rem !important;
    }
    .modern-hero p {
        font-size: 1.2rem !important;
    }
}
</style>

<div style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <?php echo $__env->make('front.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 style="color: #333; font-weight: 700; margin: 0;">Your Groups</h2>
                <p style="color: #6c757d; margin: 0;">Manage and participate in your prayer communities</p>
            </div>
            <a href="<?php echo e(route('account.createGroup')); ?>" class="btn-modern">
                <i class="fas fa-plus" style="margin-right: 10px;"></i>Create New Group
            </a>
        </div>

        <?php if($groups->isNotEmpty()): ?>
            <div class="row">
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="group-card">
                        <div class="group-image">
                            <?php if($group->image): ?>
                                <img src="<?php echo e(asset('storage/'.$group->image)); ?>" alt="<?php echo e($group->title); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <?php echo e(strtoupper(substr($group->title, 0, 2))); ?>

                            <?php endif; ?>
                        </div>
                        <div style="padding: 25px;">
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 700;"><?php echo e(Str::limit($group->title, 30)); ?></h4>
                            <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6;"><?php echo e(Str::limit($group->description ?? 'Join this prayer group to connect with fellow believers.', 80)); ?></p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="stats-badge">
                                    <i class="fas fa-users" style="margin-right: 5px;"></i>
                                    <?php echo e($group->current_members); ?>/<?php echo e($group->max_members); ?>

                                </span>
                                <?php if($group->category): ?>
                                <span class="stats-badge">
                                    <i class="fas fa-tag" style="margin-right: 5px;"></i>
                                    <?php echo e($group->category->name); ?>

                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="<?php echo e(route('account.group.show', $group->id)); ?>" class="btn btn-outline-modern btn-sm">
                                    <i class="fas fa-eye" style="margin-right: 5px;"></i>View
                                </a>
                                <a href="<?php echo e(route('account.group.chat', $group->id)); ?>" class="btn btn-outline-modern btn-sm">
                                    <i class="fas fa-comments" style="margin-right: 5px;"></i>Chat
                                </a>
                                <button class="btn btn-outline-modern btn-sm" data-bs-toggle="modal" data-bs-target="#meetingModal" 
                                        data-stream-url="<?php echo e($group->stream_url ?? 'https://d2zihajmogu5jn.cloudfront.net/bipbop-advanced/bipbop_16x9_variant.m3u8'); ?>" 
                                        data-stream-type="<?php echo e($group->stream_type ?? 'hls'); ?>">
                                    <i class="fas fa-video" style="margin-right: 5px;"></i>Live
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="d-flex justify-content-center mt-5">
                <?php echo e($groups->links()); ?>

            </div>
        <?php else: ?>
            <div class="empty-state">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                    <i class="fas fa-users" style="font-size: 2.5rem; color: white;"></i>
                </div>
                <h3 style="color: #333; margin-bottom: 15px; font-weight: 700;">No Groups Yet</h3>
                <p style="color: #6c757d; margin-bottom: 30px; font-size: 1.1rem;">Start by creating your first prayer group</p>
                <a href="<?php echo e(route('account.createGroup')); ?>" class="btn-modern">
                    <i class="fas fa-plus" style="margin-right: 10px;"></i>Create Your First Group
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Live Prayer Meeting Modal -->
<div class="modal fade" id="meetingModal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" style="background: #f8f9fa; border: none; border-radius: 20px;">
      <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 20px 30px; border-radius: 20px 20px 0 0;">
        <div class="d-flex align-items-center">
          <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
            <i class="fas fa-video" style="color: white; font-size: 1.2rem;"></i>
          </div>
          <div>
            <h4 class="modal-title" id="meetingModalLabel" style="color: white; margin: 0; font-weight: 700;">Live Prayer Meeting</h4>
            <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.9rem;">Connect with your community in prayer</p>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
      </div>
      <div class="modal-body" style="padding: 30px;">
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div style="background: white; border-radius: 20px; padding: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    <div id="media-container" style="background: #000; border-radius: 15px; overflow: hidden; position: relative; width: 100%; height: 450px;">
                        <video-js id="videoPlayer" class="video-js vjs-default-skin vjs-big-play-centered" 
                                  controls 
                                  preload="auto" 
                                  style="width: 100%; height: 100%;" 
                                  data-setup="{\"fluid\": false, \"responsive\": false}">
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>.
                            </p>
                        </video-js>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div style="background: white; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); height: 490px; display: flex; flex-direction: column;">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 20px 20px 0 0; text-align: center;">
                        <i class="fas fa-comments" style="font-size: 1.5rem; margin-bottom: 10px;"></i>
                        <h5 style="margin: 0; font-weight: 600;">Prayer Chat</h5>
                        <p style="margin: 0; font-size: 0.85rem; opacity: 0.9;">Share your prayer requests and praises</p>
                    </div>
                    <div id="chatBox" style="flex: 1; padding: 20px; overflow-y: auto; background: #f8f9fa;">
                        <div style="text-align: center; color: #6c757d; padding: 40px 20px;">
                            <i class="fas fa-praying-hands" style="font-size: 2rem; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p style="margin: 0; font-size: 0.9rem;">Welcome to the prayer chat!<br>Share your heart with the community.</p>
                        </div>
                    </div>
                    <div style="padding: 20px; background: white; border-radius: 0 0 20px 20px;">
                        <div class="input-group">
                            <input type="text" id="chatMessageInput" class="form-control" placeholder="Type your message..." style="border: 2px solid #e9ecef; border-radius: 25px 0 0 25px; padding: 12px 20px;">
                            <button class="btn" id="sendMessageBtn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 0 25px 25px 0; padding: 12px 20px;">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="text-center mt-2">
                            <small style="color: #6c757d;">Press Enter to send your message</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('customCSS'); ?>
<link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('customJS'); ?>
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-hls@5.15.0/dist/videojs-contrib-hls.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var meetingModal = document.getElementById('meetingModal');
    var player;

    if (meetingModal) {
        meetingModal.addEventListener('show.bs.modal', function (event) {
            // Clear chat when modal opens
            const chatBox = document.getElementById('chatBox');
            if (chatBox) {
                chatBox.innerHTML = `
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-comments fa-2x mb-2 opacity-50"></i>
                        <p class="mb-0">Chat messages will appear here</p>
                    </div>
                `;
            }
            
            var button = event.relatedTarget;
            var streamUrl = button.getAttribute('data-stream-url');
            var streamType = button.getAttribute('data-stream-type');
            
            // Wait for modal to be fully shown before initializing video
            setTimeout(function() {
                var videoNode = document.querySelector('#videoPlayer');
                
                if (videoNode && !player) {
                    player = videojs(videoNode, {
                        autoplay: false,
                        controls: true,
                        preload: 'auto',
                        fluid: false,
                        responsive: false,
                        width: '100%',
                        height: 450
                    });
                    
                    player.ready(function() {
                        console.log('Video player ready');
                        
                        if (streamType === 'hls') {
                            player.src({
                                src: streamUrl,
                                type: 'application/x-mpegURL'
                            });
                        } else if (streamType === 'mp4') {
                            player.src({
                                src: streamUrl,
                                type: 'video/mp4'
                            });
                        } else if (streamType === 'mp3') {
                            player.src({
                                src: streamUrl,
                                type: 'audio/mpeg'
                            });
                        }
                        
                        // Try to load the video
                        player.load();
                    });
                }
            }, 300);
        });

        meetingModal.addEventListener('hidden.bs.modal', function () {
            if (player) {
                player.dispose();
                player = null;
            }
        });
    }

    // Chat functionality
    const sendMessageBtn = document.getElementById('sendMessageBtn');
    const chatMessageInput = document.getElementById('chatMessageInput');
    const chatBox = document.getElementById('chatBox');

    if (sendMessageBtn && chatMessageInput && chatBox) {
        sendMessageBtn.addEventListener('click', function() {
            const message = chatMessageInput.value;
            if (message.trim() !== '') {
                const messageElement = document.createElement('div');
                messageElement.style.cssText = 'background: white; padding: 15px; border-radius: 15px; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-left: 4px solid #667eea;';
                messageElement.innerHTML = `
                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                        <div style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; margin-right: 10px; font-size: 0.8rem;">U</div>
                        <div>
                            <strong style="color: #333; font-size: 0.9rem;">You</strong>
                            <small style="color: #6c757d; margin-left: 10px;">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</small>
                        </div>
                    </div>
                    <p style="margin: 0; color: #555; line-height: 1.5;">${message}</p>
                `;
                chatBox.appendChild(messageElement);
                chatMessageInput.value = '';
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });

        chatMessageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessageBtn.click();
            }
        });


    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/groups.blade.php ENDPATH**/ ?>