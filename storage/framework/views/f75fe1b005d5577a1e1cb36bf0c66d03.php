

<?php
    // Get all contents for this section
    $contents = $contents ?? collect();
    
    if ($contents->isEmpty()) {
        return;
    }

    // Get layout settings from the first item (or use defaults)
    $firstContent = $contents->first();
    $columnCount = $firstContent->column_count ?? '1';
    $layoutStyle = $firstContent->layout_style ?? 'default';
    $contentWidth = $firstContent->content_width ?? 'default';
    $bgType = $firstContent->bg_type ?? 'none';
    $bgColor = $firstContent->bg_color ?? '';
    $bgImage = $firstContent->bg_image ?? '';
    $bgGradient = $firstContent->bg_gradient ?? '';
    $paddingTop = $firstContent->padding_top ?? 'default';
    $paddingBottom = $firstContent->padding_bottom ?? 'default';
    $textAlign = $firstContent->text_align ?? 'default';
    $cssClass = $firstContent->css_class ?? '';

    // Build background style
    $bgStyle = '';
    if ($bgType === 'color' && $bgColor) {
        $bgStyle = "background-color: {$bgColor};";
    } elseif ($bgType === 'image' && $bgImage) {
        $bgStyle = "background-image: url('{$bgImage}'); background-size: cover; background-position: center;";
    } elseif ($bgType === 'gradient' && $bgGradient) {
        $colors = explode(',', $bgGradient);
        if (count($colors) >= 2) {
            $bgStyle = "background: linear-gradient(135deg, {$colors[0]}, {$colors[1]});";
        }
    }

    // Build padding
    $paddingMap = [
        'default' => '',
        '0' => '0',
        'small' => '20px',
        'medium' => '40px',
        'large' => '60px',
        'xlarge' => '80px',
    ];
    $pt = $paddingMap[$paddingTop] ?? '';
    $pb = $paddingMap[$paddingBottom] ?? '';
    $sectionPadding = '';
    if ($pt) $sectionPadding .= "padding-top: {$pt};";
    if ($pb) $sectionPadding .= "padding-bottom: {$pb};";

    // Text alignment
    $textAlignClass = '';
    if ($textAlign === 'left') $textAlignClass = 'text-left';
    elseif ($textAlign === 'right') $textAlignClass = 'text-right';
    elseif ($textAlign === 'center') $textAlignClass = 'text-center';

    // Column classes based on count
    $colClassMap = [
        '1' => 'col-12',
        '2' => 'col-lg-6 col-md-6',
        '3' => 'col-lg-4 col-md-6',
        '4' => 'col-lg-3 col-md-6',
    ];
    $colClass = $colClassMap[$columnCount] ?? 'col-12';

    // Content width class
    $widthClass = '';
    if ($contentWidth === 'container') $widthClass = 'container';
    elseif ($contentWidth === 'narrow') $widthClass = 'narrow-content';
    elseif ($contentWidth === 'wide') $widthClass = 'wide-content';

    // Button style class
    $btnClassMap = [
        'primary' => 'react-btn',
        'secondary' => 'react-btn-border',
        'success' => 'react-btn-success',
        'danger' => 'react-btn-danger',
        'warning' => 'react-btn-warning',
        'info' => 'react-btn-info',
    ];
?>

<section class="page-section page-section-<?php echo e($sectionName); ?> <?php echo e($cssClass); ?>" 
         style="<?php echo e($bgStyle); ?><?php echo e($sectionPadding); ?>"
         data-section="<?php echo e($sectionName); ?>"
         data-layout="<?php echo e($layoutStyle); ?>"
         data-columns="<?php echo e($columnCount); ?>">

    <div class="<?php echo e($widthClass ?: 'container'); ?>">
        
        
        <?php if($contents->count() == 1 || in_array($layoutStyle, ['image-left', 'image-right', 'image-top', 'image-bottom', 'full-width', 'centered', 'boxed', 'card'])): ?>
            <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('front.partials.page-content-section', ['content' => $content], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        
        <?php if($contents->count() > 1 && in_array($columnCount, ['2', '3', '4']) && !in_array($layoutStyle, ['image-left', 'image-right', 'image-top', 'image-bottom', 'full-width'])): ?>
        <div class="row <?php echo e($textAlignClass); ?>">
            <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="<?php echo e($colClass); ?> mb-4">
                <div class="section-item <?php echo e($layoutStyle === 'card' ? 'card-style' : ''); ?>"
                     style="<?php echo e($layoutStyle === 'card' ? 'background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); height: 100%;' : ''); ?>">
                    
                    <?php
                        $title = $content->translated_title ?? $content->title ?? '';
                        $subtitle = $content->translated_subtitle ?? $content->subtitle ?? '';
                        $bodyContent = $content->translated_content ?? $content->content ?? '';
                        $image = $content->image ?? '';
                        $videoEmbed = $content->video_embed ?? '';
                        $linkText = $content->link_text ?? '';
                        $linkUrl = $content->link_url ?? '';
                        $linkStyle = $content->link_style ?? 'primary';
                        $btnClass = $btnClassMap[$linkStyle] ?? 'react-btn';
                    ?>

                    
                    <?php if($image): ?>
                        <div class="item-image mb-3">
                            <img src="<?php echo e(asset($image)); ?>" class="img-fluid rounded" alt="<?php echo e($title); ?>" 
                                 style="<?php echo e($layoutStyle === 'card' ? 'width: 100%; height: 200px; object-fit: cover;' : ''); ?>">
                        </div>
                    <?php endif; ?>

                    
                    <?php if($videoEmbed && !$image): ?>
                        <div class="item-video mb-3">
                            <div class="video-wrapper">
                                <?php echo $videoEmbed; ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($subtitle): ?>
                        <span class="item-subtitle" style="color: #667eea; font-size: 0.9rem; font-weight: 600;"><?php echo e($subtitle); ?></span>
                    <?php endif; ?>

                    
                    <?php if($title): ?>
                        <h4 class="item-title" style="margin: 10px 0; font-size: 1.3rem; font-weight: 600; color: #333;">
                            <?php echo e($title); ?>

                        </h4>
                    <?php endif; ?>

                    
                    <?php if($bodyContent): ?>
                        <div class="item-content" style="color: #6c757d; line-height: 1.6;">
                            <?php echo Str::limit(strip_tags($bodyContent), 200); ?>

                        </div>
                    <?php endif; ?>

                    
                    <?php if($linkText && $linkUrl): ?>
                        <div class="item-action mt-3">
                            <a href="<?php echo e($linkUrl); ?>" class="<?php echo e($btnClass); ?>" style="font-size: 0.9rem;">
                                <?php echo e($linkText); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<style>
.page-section {
    position: relative;
    width: 100%;
}

.page-section .content-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.page-section .content-subtitle {
    display: block;
    font-size: 1rem;
    color: #667eea;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.page-section .content-text {
    color: #6c757d;
    font-size: 1.1rem;
    line-height: 1.8;
}

.page-section .content-text p {
    margin-bottom: 1rem;
}

/* Video Wrapper */
.video-wrapper {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    border-radius: 10px;
}

.video-wrapper iframe,
.video-wrapper video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Button Styles */
.react-btn {
    display: inline-block;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 30px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.react-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
}

.react-btn-border {
    display: inline-block;
    background: transparent;
    color: #667eea;
    padding: 10px 25px;
    border-radius: 50px;
    border: 2px solid #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.react-btn-border:hover {
    background: #667eea;
    color: white;
}

/* Narrow/Wide Content */
.narrow-content {
    max-width: 800px;
    margin: 0 auto;
}

.wide-content {
    max-width: 1400px;
}

/* Text alignment */
.text-left {
    text-align: left;
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

.text-center .section-item {
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .page-section .content-title {
        font-size: 1.8rem;
    }
    
    .page-section .content-text {
        font-size: 1rem;
    }
}
</style>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/partials/page-section.blade.php ENDPATH**/ ?>