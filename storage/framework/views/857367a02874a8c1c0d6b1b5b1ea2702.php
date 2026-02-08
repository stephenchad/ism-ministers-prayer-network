<?php $__env->startSection('main'); ?>
<div class="react-wrapper">
    <div class="react-wrapper-inner">
        
        <!-- Article Header -->
        <div style="padding: 120px 0 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <span style="background: rgba(255,255,255,0.2); padding: 8px 20px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; text-transform: uppercase; display: inline-block; margin-bottom: 20px;"><?php echo e($article->type); ?></span>
                        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 20px; line-height: 1.3;"><?php echo e($article->title); ?></h1>
                        <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 30px;"><?php echo e($article->excerpt); ?></p>
                        <div style="display: flex; justify-content: center; align-items: center; gap: 30px; flex-wrap: wrap;">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-calendar" style="margin-right: 10px;"></i>
                                <span><?php echo e($article->created_at->format('F d, Y')); ?></span>
                            </div>
                            <?php if($article->type == 'event' && $article->event_date): ?>
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-clock" style="margin-right: 10px;"></i>
                                    <span><?php echo e($article->event_date->format('F d, Y - g:i A')); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($article->event_location): ?>
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i>
                                    <span><?php echo e($article->event_location); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Content -->
        <div style="padding: 100px 0; background: white;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?php if($article->image): ?>
                            <div style="margin-bottom: 50px; text-align: center;">
                                <img src="<?php echo e(asset('storage/' . $article->image)); ?>" alt="<?php echo e($article->title); ?>" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                            </div>
                        <?php endif; ?>
                        
                        <div style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                            <?php echo nl2br(e($article->content)); ?>

                        </div>

                        <!-- Share Section -->
                        <div style="margin-top: 50px; padding: 30px; background: #f8f9fa; border-radius: 20px; text-align: center;">
                            <h4 style="color: #333; margin-bottom: 20px; font-weight: 600;">Share this <?php echo e($article->type); ?></h4>
                            <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url()->current()); ?>" target="_blank" onclick="shareAndNotify('facebook')" style="background: #4267B2; color: white; padding: 12px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo e(url()->current()); ?>&text=<?php echo e(urlencode($article->title)); ?>" target="_blank" onclick="shareAndNotify('twitter')" style="background: #1DA1F2; color: white; padding: 12px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                    <i class="fab fa-twitter"></i> Twitter
                                </a>
                             
                              
                            </div>
                            <p id="copyMessage" style="margin-top: 15px; color: #28a745; display: none;">Link copied to clipboard!</p>
                        </div>

                        <?php if($article->type == 'event' && $article->event_date && $article->event_date->isFuture()): ?>
                            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 20px; text-align: center; margin-top: 50px;">
                                <h3 style="margin-bottom: 20px; font-weight: 600;">Don't Miss This Event!</h3>
                                <p style="margin-bottom: 30px; opacity: 0.9;">Mark your calendar and join us for this special gathering.</p>
                                <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                                    <div style="background: rgba(255,255,255,0.2); padding: 15px 25px; border-radius: 15px; backdrop-filter: blur(10px);">
                                        <i class="fas fa-calendar" style="margin-right: 10px;"></i>
                                        <?php echo e($article->event_date->format('F d, Y')); ?>

                                    </div>
                                    <div style="background: rgba(255,255,255,0.2); padding: 15px 25px; border-radius: 15px; backdrop-filter: blur(10px);">
                                        <i class="fas fa-clock" style="margin-right: 10px;"></i>
                                        <?php echo e($article->event_date->format('g:i A')); ?>

                                    </div>
                                    <?php if($article->event_location): ?>
                                        <div style="background: rgba(255,255,255,0.2); padding: 15px 25px; border-radius: 15px; backdrop-filter: blur(10px);">
                                            <i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i>
                                            <?php echo e($article->event_location); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        <?php if($related->count() > 0): ?>
            <div style="padding: 100px 0; background: #f8f9fa;">
                <div class="container">
                    <div class="text-center mb-5">
                        <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Related <?php echo e(ucfirst($article->type)); ?>s</h2>
                        <p style="color: #6c757d; font-size: 1.1rem;">More updates from ISM Ministers' Prayer Network</p>
                    </div>
                    <div class="row">
                        <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedArticle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 mb-4">
                                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; cursor: pointer; transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='<?php echo e(route('news.show', $relatedArticle->slug)); ?>'">
                                    <?php if($relatedArticle->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $relatedArticle->image)); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo e($relatedArticle->title); ?>">
                                    <?php else: ?>
                                        <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                            <i class="fas <?php echo e($relatedArticle->type == 'event' ? 'fa-calendar-alt' : 'fa-newspaper'); ?>" style="font-size: 3rem; color: white;"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body" style="padding: 25px;">
                                        <span style="background: <?php echo e($relatedArticle->type == 'event' ? '#28a745' : '#667eea'); ?>; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;"><?php echo e($relatedArticle->type); ?></span>
                                        <h5 style="color: #333; margin: 15px 0; font-weight: 600; line-height: 1.4;"><?php echo e($relatedArticle->title); ?></h5>
                                        <p style="color: #6c757d; margin-bottom: 15px; line-height: 1.6;"><?php echo e(Str::limit($relatedArticle->excerpt, 80)); ?></p>
                                        <small style="color: #6c757d;"><?php echo e($relatedArticle->created_at->format('M d, Y')); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Back to News -->
        <div style="padding: 50px 0; background: white; text-align: center;">
            <div class="container">
                <a href="<?php echo e(route('news.index')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    ← Back to News & Events
                </a>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('js/social-share.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/news/show.blade.php ENDPATH**/ ?>