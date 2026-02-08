<?php $__env->startSection('main'); ?>
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
        <p style="font-size: 1.2rem; opacity: 0.9;">Found <?php echo e($totalResults); ?> results for "<?php echo e($query); ?>"</p>
    </div>
</div>

<div style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <?php if($totalResults > 0): ?>
            <!-- Groups Results -->
            <?php if($groups->count() > 0): ?>
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">Prayer Groups (<?php echo e($groups->total()); ?>)</h3>
                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="result-card">
                            <span class="result-type">Prayer Group</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">
                                <a href="<?php echo e(route('account.group.show', $group->id)); ?>" style="color: #333; text-decoration: none;"><?php echo e($group->title); ?></a>
                            </h4>
                            <p style="color: #555; margin-bottom: 15px;"><?php echo e(Str::limit($group->description, 150)); ?></p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                <span><i class="fas fa-users" style="margin-right: 5px;"></i><?php echo e($group->current_members); ?>/<?php echo e($group->max_members); ?> Members</span>
                                <?php if($group->category): ?>
                                <span><i class="fas fa-tag" style="margin-right: 5px;"></i><?php echo e($group->category->name); ?></span>
                                <?php endif; ?>
                                <span><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i><?php echo e($group->city->name ?? 'N/A'); ?>, <?php echo e($group->country->name ?? 'N/A'); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($groups->appends(['q' => $query])->links()); ?>

                </div>
            <?php endif; ?>

            <!-- Prayer Requests Results -->
            <?php if($prayers->count() > 0): ?>
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">Prayer Requests (<?php echo e($prayers->total()); ?>)</h3>
                    <?php $__currentLoopData = $prayers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prayer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="result-card">
                            <span class="result-type">Prayer Request</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">Prayer by <?php echo e($prayer->name); ?></h4>
                            <p style="color: #555; margin-bottom: 15px;"><?php echo e(Str::limit($prayer->prayer_request, 200)); ?></p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                <span><i class="fas fa-praying-hands" style="margin-right: 5px;"></i><?php echo e($prayer->prayer_type); ?></span>
                                <span><i class="fas fa-clock" style="margin-right: 5px;"></i><?php echo e($prayer->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($prayers->appends(['q' => $query])->links()); ?>

                </div>
            <?php endif; ?>

            <!-- Testimonies Results -->
            <?php if($testimonies->count() > 0): ?>
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">Testimonies (<?php echo e($testimonies->total()); ?>)</h3>
                    <?php $__currentLoopData = $testimonies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimony): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="result-card">
                            <span class="result-type">Testimony</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;"><?php echo e($testimony->title); ?></h4>
                            <p style="color: #555; margin-bottom: 15px;"><?php echo e(Str::limit($testimony->testimony, 200)); ?></p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                <span><i class="fas fa-user" style="margin-right: 5px;"></i><?php echo e($testimony->name); ?></span>
                                <span><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i><?php echo e($testimony->location); ?></span>
                                <span><i class="fas fa-clock" style="margin-right: 5px;"></i><?php echo e($testimony->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($testimonies->appends(['q' => $query])->links()); ?>

                </div>
            <?php endif; ?>

            <!-- Programs Results -->
            <?php if($programs->count() > 0): ?>
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">Programs (<?php echo e($programs->total()); ?>)</h3>
                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="result-card">
                            <span class="result-type">Program</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">
                                <a href="<?php echo e(route('programs.show', $program->slug)); ?>" style="color: #333; text-decoration: none;"><?php echo e($program->title); ?></a>
                            </h4>
                            <p style="color: #555; margin-bottom: 15px;"><?php echo e(Str::limit($program->description, 200)); ?></p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                <?php if($program->schedule): ?>
                                <span><i class="fas fa-calendar" style="margin-right: 5px;"></i><?php echo e($program->schedule); ?></span>
                                <?php endif; ?>
                                <?php if($program->location): ?>
                                <span><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i><?php echo e($program->location); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($programs->appends(['q' => $query])->links()); ?>

                </div>
            <?php endif; ?>

            <!-- News Results -->
            <?php if($news->count() > 0): ?>
                <div class="mb-5">
                    <h3 style="color: #333; font-weight: 700; margin-bottom: 30px;">News (<?php echo e($news->total()); ?>)</h3>
                    <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="result-card">
                            <span class="result-type">News</span>
                            <h4 style="color: #333; font-weight: 700; margin-bottom: 15px;">
                                <a href="<?php echo e(route('news.show', $newsItem->slug)); ?>" style="color: #333; text-decoration: none;"><?php echo e($newsItem->title); ?></a>
                            </h4>
                            <p style="color: #555; margin-bottom: 15px;"><?php echo e(Str::limit($newsItem->excerpt ?: $newsItem->content, 200)); ?></p>
                            <div style="display: flex; align-items: center; gap: 20px; color: #6c757d; font-size: 0.9rem;">
                                <?php if($newsItem->event_date): ?>
                                <span><i class="fas fa-calendar" style="margin-right: 5px;"></i><?php echo e($newsItem->event_date->format('M d, Y')); ?></span>
                                <?php endif; ?>
                                <?php if($newsItem->event_location): ?>
                                <span><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i><?php echo e($newsItem->event_location); ?></span>
                                <?php endif; ?>
                                <span><i class="fas fa-clock" style="margin-right: 5px;"></i><?php echo e($newsItem->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($news->appends(['q' => $query])->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-results">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                    <i class="fas fa-search" style="font-size: 2.5rem; color: white;"></i>
                </div>
                <h3 style="color: #333; margin-bottom: 15px; font-weight: 700;">No Results Found</h3>
                <p style="color: #6c757d; margin-bottom: 30px; font-size: 1.1rem;">We couldn't find anything matching "<?php echo e($query); ?>". Try different keywords or browse our sections.</p>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo e(route('prayers')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">Browse Prayers</a>
                    <a href="<?php echo e(route('testimonies')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">View Testimonies</a>
                    <a href="<?php echo e(route('groups.index')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">Join Groups</a>
                    <a href="<?php echo e(route('programs.index')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">View Programs</a>
                    <a href="<?php echo e(route('news.index')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; font-weight: 600;">Read News</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/search.blade.php ENDPATH**/ ?>