<?php $__env->startSection('main'); ?>
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
}
.testimony-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    border-left: 5px solid #667eea;
}
.testimony-card:hover {
    transform: translateY(-5px);
}
.category-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem;">Testimonies</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Share and read inspiring stories of God's faithfulness</p>
    </div>
</div>

<div style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size: 2.5rem; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Share Your Testimony</h2>
            <p style="color: #6c757d; font-size: 1.1rem;">We would love to hear how God has moved in your life</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="modern-card">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('testimonies.store')); ?>" method="POST">
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
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="location" class="form-control" id="location" placeholder="Your Location">
                                    <label for="location">Your Location</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="category" class="form-control" id="category" required>
                                        <option value="">Select Category</option>
                                        <option value="healing">🙏 Healing</option>
                                        <option value="financial">💰 Financial Breakthrough</option>
                                        <option value="family">👨👩👧👦 Family Restoration</option>
                                        <option value="salvation">✨ Salvation</option>
                                        <option value="other">💝 Other</option>
                                    </select>
                                    <label for="category">Category</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Testimony Title" required>
                                    <label for="title">Testimony Title</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea name="testimony" class="form-control" id="testimony" style="height: 150px" placeholder="Share your testimony..." required></textarea>
                                    <label for="testimony">Share your testimony...</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="allow_publish" value="1" class="form-check-input" id="publish">
                                    <label class="form-check-label" for="publish">
                                        I allow this testimony to be published on the website
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn-modern">✨ Submit Testimony</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="padding: 80px 0; background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 style="font-size: 2.5rem; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Browse Testimonies</h2>
            <p style="color: #6c757d; font-size: 1.1rem;">Read inspiring testimonies from our community</p>
        </div>
        
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $testimonies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimony): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-lg-6">
                    <div class="testimony-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="category-badge">
                                <?php switch($testimony->category):
                                    case ('healing'): ?> 🙏 <?php break; ?>
                                    <?php case ('financial'): ?> 💰 <?php break; ?>
                                    <?php case ('family'): ?> 👨👩👧👦 <?php break; ?>
                                    <?php case ('salvation'): ?> ✨ <?php break; ?>
                                    <?php default: ?> 💝
                                <?php endswitch; ?>
                                <?php echo e(ucfirst($testimony->category)); ?>

                            </span>
                            <small class="text-muted"><?php echo e($testimony->created_at->diffForHumans()); ?></small>
                        </div>
                        <h4 style="color: #333; margin-bottom: 1rem;"><?php echo e($testimony->title); ?></h4>
                        <p style="color: #6c757d; line-height: 1.6;">"<?php echo e(Str::limit($testimony->testimony, 200)); ?>"</p>
                        <div class="d-flex align-items-center mt-3">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; margin-right: 15px;">
                                <?php echo e(strtoupper(substr($testimony->name, 0, 2))); ?>

                            </div>
                            <div>
                                <h6 style="margin: 0; color: #333;"><?php echo e($testimony->name); ?></h6>
                                <?php if($testimony->location): ?>
                                    <small class="text-muted"><?php echo e($testimony->location); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No testimonies yet. Be the first to share your testimony!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/testimony.blade.php ENDPATH**/ ?>