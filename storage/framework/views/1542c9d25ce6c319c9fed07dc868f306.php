<?php $__env->startSection('main'); ?>
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 60px;
    color: white;
    text-align: center;
}
.chat-container {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    overflow: hidden;
    height: 600px;
    display: flex;
    flex-direction: column;
}
.chat-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.chat-body {
    flex: 1;
    padding: 30px;
    overflow-y: auto;
    background: #f8f9fa;
}
.chat-footer {
    padding: 25px 30px;
    background: white;
    border-top: 1px solid #e9ecef;
}
.message-bubble {
    background: white;
    padding: 15px 20px;
    border-radius: 20px;
    margin-bottom: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid #667eea;
    max-width: 80%;
}
.message-user {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}
.user-avatar {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    margin-right: 10px;
    font-size: 0.8rem;
}
.btn-send {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 25px;
    padding: 12px 25px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
}
.chat-input {
    border: 2px solid #e9ecef;
    border-radius: 25px;
    padding: 12px 20px;
    font-size: 1rem;
    transition: all 0.3s ease;
}
.chat-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
.empty-chat {
    text-align: center;
    color: #6c757d;
    padding: 60px 20px;
}
.group-info {
    background: rgba(255,255,255,0.1);
    padding: 15px 20px;
    border-radius: 15px;
    margin-bottom: 20px;
}
</style>

<div class="modern-hero">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                <i class="fas fa-comments" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h1 style="font-size: 3rem; font-weight: 700; margin: 0;"><?php echo e($group->title); ?></h1>
                <p style="font-size: 1.1rem; opacity: 0.9; margin: 0;">Prayer Group Chat</p>
            </div>
        </div>
        <div class="group-info">
            <div class="d-flex align-items-center justify-content-center gap-4">
                <span><i class="fas fa-users" style="margin-right: 8px;"></i><?php echo e($group->current_members); ?> Members</span>
                <?php if($group->category): ?>
                <span><i class="fas fa-tag" style="margin-right: 8px;"></i><?php echo e($group->category->name); ?></span>
                <?php endif; ?>
                <span><i class="fas fa-clock" style="margin-right: 8px;"></i>Active Now</span>
            </div>
        </div>
    </div>
</div>

<div style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="chat-container">
                    <div class="chat-header">
                        <div class="d-flex align-items-center">
                            <div style="width: 45px; height: 45px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                <i class="fas fa-praying-hands" style="font-size: 1.1rem;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-weight: 700;">Live Prayer Chat</h4>
                                <p style="margin: 0; font-size: 0.9rem; opacity: 0.8;">Share prayers, encouragement, and fellowship</p>
                            </div>
                        </div>
                        <a href="<?php echo e(route('account.group.show', $group->id)); ?>" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: none; border-radius: 15px; padding: 8px 15px;">
                            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>Back to Group
                        </a>
                    </div>
                    
                    <div class="chat-body" id="chatBox">
                        <div class="empty-chat">
                            <i class="fas fa-praying-hands" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;"></i>
                            <h5 style="margin-bottom: 10px;">Welcome to the Prayer Chat</h5>
                            <p style="margin: 0;">Share your heart, prayers, and encouragement with your faith community.</p>
                        </div>
                    </div>
                    
                    <div class="chat-footer">
                        <div class="input-group">
                            <input type="text" id="chatMessageInput" class="form-control chat-input" placeholder="Type your prayer or message...">
                            <button class="btn btn-send" id="sendMessageBtn">
                                <i class="fas fa-paper-plane" style="margin-right: 8px;"></i>Send
                            </button>
                        </div>
                        <div class="text-center mt-2">
                            <small style="color: #6c757d;">Press Enter to send • Be kind and prayerful</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendMessageBtn = document.getElementById('sendMessageBtn');
    const chatMessageInput = document.getElementById('chatMessageInput');
    const chatBox = document.getElementById('chatBox');

    function sendMessage() {
        const message = chatMessageInput.value;
        if (message.trim() !== '') {
            // Clear empty state if it exists
            const emptyChat = chatBox.querySelector('.empty-chat');
            if (emptyChat) {
                emptyChat.remove();
            }

            const messageElement = document.createElement('div');
            messageElement.className = 'message-bubble';
            messageElement.innerHTML = `
                <div class="message-user">
                    <div class="user-avatar"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?></div>
                    <div>
                        <strong style="color: #333; font-size: 0.9rem;"><?php echo e(auth()->user()->name ?? 'You'); ?></strong>
                        <small style="color: #6c757d; margin-left: 10px;">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</small>
                    </div>
                </div>
                <p style="margin: 0; color: #555; line-height: 1.6;">${message}</p>
            `;
            chatBox.appendChild(messageElement);
            chatMessageInput.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }

    sendMessageBtn.addEventListener('click', sendMessage);
    
    chatMessageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/account/group/chat.blade.php ENDPATH**/ ?>