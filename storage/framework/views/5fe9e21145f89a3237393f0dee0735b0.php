<?php $__env->startSection('main'); ?>
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
}
.modern-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
}
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}
.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}
.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 2rem;
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
.form-floating {
    margin-bottom: 20px;
}
.form-floating input, .form-floating select, .form-floating textarea {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 20px 15px;
    transition: all 0.3s ease;
}
.form-floating input:focus, .form-floating select:focus, .form-floating textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50px;
    padding: 15px 40px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
}
.contact-info-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border-radius: 20px;
    padding: 40px;
    height: 100%;
}
.contact-info-item {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px;
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    backdrop-filter: blur(10px);
}
.contact-info-item i {
    font-size: 24px;
    margin-right: 20px;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
}
.section-modern {
    padding: 100px 0;
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
}
.stats-card {
    background: white;
    border-radius: 20px;
    padding: 40px 20px;
    text-align: center;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    margin-bottom: 30px;
}
.stats-card:hover {
    transform: translateY(-10px);
}
.stats-number {
    font-size: 3rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.team-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    margin-bottom: 30px;
}
.team-card:hover {
    transform: translateY(-10px);
}
.team-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}
.team-info {
    padding: 30px 20px;
    text-align: center;
}
</style>

<!--================= Modern Hero Section =================-->
<div class="modern-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Contact Us</h1>
            <p class="hero-subtitle">We'd love to hear from you. Reach out to us anytime.</p>
        </div>
    </div>
</div>

<!--================= Modern Contact Section =================-->
<div style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="modern-card">
                    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Send a Message</h2>
                    <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 2rem;">Fill out the form below and we'll get back to you as soon as possible.</p>
                    
                    <form action="<?php echo e(route('contact.send')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" required>
                                    <label for="email">Your Email</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" required>
                                    <label for="subject">Subject</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea name="message" class="form-control" id="message" style="height: 150px" placeholder="Your Message" required></textarea>
                                    <label for="message">Your Message</label>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn-modern">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info-card">
                    <h3 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">Get in Touch</h3>
                    <div class="contact-info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4 style="margin-bottom: 0.5rem;">Email Us</h4>
                            <p style="margin: 0; opacity: 0.9;">info@ismprayernetwork.org</p>
                            <p style="margin: 0; opacity: 0.9;">prayer@ismprayernetwork.org</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4 style="margin-bottom: 0.5rem;">Call Us</h4>
                            <p style="margin: 0; opacity: 0.9;">+1 (555) 123-4567</p>
                            <p style="margin: 0; opacity: 0.9;">+1 (555) 987-6543</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4 style="margin-bottom: 0.5rem;">Prayer Hours</h4>
                            <p style="margin: 0; opacity: 0.9;">Our prayer support team is available</p>
                            <p style="margin: 0; opacity: 0.9;">24 hours a day, 7 days a week</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--================= Prayer Request Section =================-->
<div style="padding: 100px 0; background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
    <div class="container">
        <div class="text-center" style="margin-bottom: 60px;">
            <h6 style="color: #667eea; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Submit a Prayer Request</h6>
            <h2 style="font-size: 3rem; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Pray With You</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="modern-card">
                    <form action="<?php echo e(route('prayer.request')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name" class="form-control" id="prayerName" placeholder="Your Name" required>
                                    <label for="prayerName">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" id="prayerEmail" placeholder="Your Email (Optional)">
                                    <label for="prayerEmail">Your Email (Optional)</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <select name="prayer_type" class="form-control" id="prayerType" required>
                                        <option value="">Select Prayer Type</option>
                                        <option value="healing">🙏 Healing</option>
                                        <option value="family">👨‍👩‍👧‍👦 Family</option>
                                        <option value="financial">💰 Financial</option>
                                        <option value="spiritual">✨ Spiritual Growth</option>
                                        <option value="guidance">🧭 Guidance</option>
                                        <option value="other">💝 Other</option>
                                    </select>
                                    <label for="prayerType">Prayer Type</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea name="prayer_request" class="form-control" id="prayerRequest" style="height: 150px" placeholder="Share your prayer request..." required></textarea>
                                    <label for="prayerRequest">Share your prayer request...</label>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn-modern">🙏 Submit Prayer Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--================= Ministry Team Section =================-->
<div style="padding: 100px 0; background: #f8f9fa;">
    <div class="container">
        <div class="text-center" style="margin-bottom: 60px;">
            <h6 style="color: #667eea; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Ministry Team</h6>
            <h2 style="font-size: 3rem; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Meet Our Coordinators</h2>
        </div>
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $coordinators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coordinator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6">
                <div class="team-card">
                    <?php if($coordinator->image): ?>
                        <img src="<?php echo e(asset($coordinator->image)); ?>" alt="<?php echo e($coordinator->name); ?>">
                    <?php else: ?>
                        <div style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 700;">
                            <?php echo e(strtoupper(substr($coordinator->name, 0, 2))); ?>

                        </div>
                    <?php endif; ?>
                    <div class="team-info">
                        <h4 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;"><?php echo e($coordinator->name); ?></h4>
                        <p style="color: #667eea; font-weight: 600;"><?php echo e($coordinator->title); ?></p>
                        <p style="color: #6c757d; font-size: 0.9rem;"><?php echo e(Str::limit($coordinator->description, 100)); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                        <h4 style="color: #6c757d;">No coordinators available at the moment</h4>
                        <p style="color: #adb5bd;">Please check back later or contact us directly</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!--================= Prayer Impact Section =================-->
<div class="section-modern">
    <div class="container">
        <div class="text-center" style="margin-bottom: 60px;">
            <h2 style="font-size: 3rem; font-weight: 700; color: white; margin-bottom: 1rem;">Prayer Impact</h2>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.9);">See how God is working through our prayer network</p>
        </div>
        <div class="row">
            <?php if(isset($contactStats) && $contactStats->isNotEmpty()): ?>
                <?php $__currentLoopData = $contactStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <div class="stats-number"><?php echo e($stat->value); ?></div>
                        <h4 style="font-weight: 600; color: #333; margin-top: 1rem;"><?php echo e($stat->label); ?></h4>
                        <p style="color: #6c757d;"><?php echo e($stat->description); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">50k+</div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">Prayer Partners</h4>
                    <p style="color: #6c757d;">Faithful believers worldwide</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">24/7</div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">Hours of Prayer</h4>
                    <p style="color: #6c757d;">Continuous intercession</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">150+</div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">Countries Reached</h4>
                    <p style="color: #6c757d;">Global prayer network</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">365</div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 1rem;">Days Per Year</h4>
                    <p style="color: #6c757d;">Never-ending support</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/contact.blade.php ENDPATH**/ ?>