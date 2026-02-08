

<?php
    // Get layout settings with defaults
    $columnCount = $content->column_count ?? '1';
    $layoutStyle = $content->layout_style ?? 'default';
    $contentWidth = $content->content_width ?? 'default';
    $bgType = $content->bg_type ?? 'none';
    $bgColor = $content->bg_color ?? '';
    $bgImage = $content->bg_image ?? '';
    $bgGradient = $content->bg_gradient ?? '';
    $paddingTop = $content->padding_top ?? 'default';
    $paddingBottom = $content->padding_bottom ?? 'default';
    $textAlign = $content->text_align ?? 'default';
    $cssClass = $content->css_class ?? '';

    // Get translated content
    $title = $content->translated_title ?? $content->title ?? '';
    $subtitle = $content->translated_subtitle ?? $content->subtitle ?? '';
    $bodyContent = $content->translated_content ?? $content->content ?? '';
    $image = $content->image ?? '';
    $imageMobile = $content->image_mobile ?? '';
    $videoUrl = $content->video_url ?? '';
    $videoEmbed = $content->video_embed ?? '';
    $linkText = $content->link_text ?? '';
    $linkUrl = $content->link_url ?? '';
    $linkStyle = $content->link_style ?? 'primary';

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

    // Button style class
    $btnClassMap = [
        'primary' => 'react-btn',
        'secondary' => 'react-btn-border',
        'success' => 'react-btn-success',
        'danger' => 'react-btn-danger',
        'warning' => 'react-btn-warning',
        'info' => 'react-btn-info',
    ];
    $btnClass = $btnClassMap[$linkStyle] ?? 'react-btn';

    // Content width class
    $widthClass = '';
    if ($contentWidth === 'container') $widthClass = 'container';
    elseif ($contentWidth === 'narrow') $widthClass = 'narrow-content';
    elseif ($contentWidth === 'wide') $widthClass = 'wide-content';

?>

<section class="page-content-section <?php echo e($cssClass); ?>" 
         style="<?php echo e($bgStyle); ?><?php echo e($sectionPadding); ?>"
         data-layout="<?php echo e($layoutStyle); ?>"
         data-columns="<?php echo e($columnCount); ?>">

    <div class="<?php echo e($widthClass ?: 'container'); ?>">
        
        
        <?php if(in_array($layoutStyle, ['default', 'centered', 'boxed', 'card']) || $columnCount == '1'): ?>
            <div class="content-wrapper <?php echo e($textAlignClass); ?> <?php echo e($layoutStyle === 'card' ? 'card-style' : ''); ?>">
                
                
                <?php if($title || $subtitle): ?>
                <div class="content-header mb-4">
                    <?php if($subtitle): ?>
                        <span class="content-subtitle"><?php echo e($subtitle); ?></span>
                    <?php endif; ?>
                    <?php if($title): ?>
                        <h2 class="content-title"><?php echo e($title); ?></h2>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                
                <?php if($bodyContent): ?>
                <div class="content-body">
                    <div class="content-text">
                        <?php echo $bodyContent; ?>

                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($image): ?>
                <div class="content-image mt-4">
                    <?php if($imageMobile): ?>
                        <img src="<?php echo e(asset($imageMobile)); ?>" class="img-fluid d-md-none" alt="<?php echo e($title); ?>">
                    <?php endif; ?>
                    <img src="<?php echo e(asset($image)); ?>" class="img-fluid <?php echo e($imageMobile ? 'd-none d-md-block' : ''); ?>" alt="<?php echo e($title); ?>">
                </div>
                <?php endif; ?>

                
                <?php if($videoEmbed): ?>
                <div class="content-video mt-4">
                    <div class="video-wrapper">
                        <?php echo $videoEmbed; ?>

                    </div>
                </div>
                <?php elseif($videoUrl): ?>
                <div class="content-video-link mt-4">
                    <a href="<?php echo e($videoUrl); ?>" class="video-link" target="_blank">
                        <i class="fas fa-play-circle"></i> Watch Video
                    </a>
                </div>
                <?php endif; ?>

                
                <?php if($linkText && $linkUrl): ?>
                <div class="content-action mt-4">
                    <a href="<?php echo e($linkUrl); ?>" class="<?php echo e($btnClass); ?>">
                        <?php echo e($linkText); ?>

                    </a>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        
        <?php if(in_array($layoutStyle, ['image-left', 'image-right']) && $columnCount == '2'): ?>
        <div class="row align-items-center">
            
            
            <div class="col-lg-6 col-md-6">
                <div class="content-image-wrapper">
                    <?php if($image): ?>
                        <img src="<?php echo e(asset($image)); ?>" class="img-fluid rounded shadow-lg" alt="<?php echo e($title); ?>">
                    <?php elseif($videoEmbed): ?>
                        <div class="video-wrapper">
                            <?php echo $videoEmbed; ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="col-lg-6 col-md-6">
                <div class="content-text-wrapper <?php echo e($textAlignClass); ?>">
                    <?php if($subtitle): ?>
                        <span class="content-subtitle"><?php echo e($subtitle); ?></span>
                    <?php endif; ?>
                    <?php if($title): ?>
                        <h2 class="content-title"><?php echo e($title); ?></h2>
                    <?php endif; ?>
                    <?php if($bodyContent): ?>
                        <div class="content-text">
                            <?php echo $bodyContent; ?>

                        </div>
                    <?php endif; ?>
                    <?php if($linkText && $linkUrl): ?>
                        <div class="content-action mt-4">
                            <a href="<?php echo e($linkUrl); ?>" class="<?php echo e($btnClass); ?>"><?php echo e($linkText); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if(in_array($layoutStyle, ['image-top', 'image-bottom']) && $columnCount == '1'): ?>
        <div class="stacked-layout <?php echo e($layoutStyle === 'image-bottom' ? 'reverse' : ''); ?>">
            
            
            <?php if(in_array($layoutStyle, ['image-top'])): ?>
            <div class="media-wrapper mb-4">
                <?php if($image): ?>
                    <img src="<?php echo e(asset($image)); ?>" class="img-fluid rounded" alt="<?php echo e($title); ?>">
                <?php elseif($videoEmbed): ?>
                    <div class="video-wrapper">
                        <?php echo $videoEmbed; ?>

                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <div class="content-wrapper <?php echo e($textAlignClass); ?>">
                <?php if($subtitle): ?>
                    <span class="content-subtitle"><?php echo e($subtitle); ?></span>
                <?php endif; ?>
                <?php if($title): ?>
                    <h2 class="content-title"><?php echo e($title); ?></h2>
                <?php endif; ?>
                <?php if($bodyContent): ?>
                    <div class="content-text">
                        <?php echo $bodyContent; ?>

                    </div>
                <?php endif; ?>
                <?php if($linkText && $linkUrl): ?>
                    <div class="content-action mt-4">
                        <a href="<?php echo e($linkUrl); ?>" class="<?php echo e($btnClass); ?>"><?php echo e($linkText); ?></a>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php if(in_array($layoutStyle, ['image-bottom'])): ?>
            <div class="media-wrapper mt-4">
                <?php if($image): ?>
                    <img src="<?php echo e(asset($image)); ?>" class="img-fluid rounded" alt="<?php echo e($title); ?>">
                <?php elseif($videoEmbed): ?>
                    <div class="video-wrapper">
                        <?php echo $videoEmbed; ?>

                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        
        <?php if($layoutStyle === 'full-width' && $image): ?>
        <div class="full-width-layout">
            <div class="full-width-image" style="background-image: url('<?php echo e(asset($image)); ?>'); min-height: 400px; background-size: cover; background-position: center;">
                <?php if($title || $bodyContent): ?>
                <div class="overlay-content" style="background: rgba(0,0,0,0.5); padding: 60px 0; color: white;">
                    <div class="container">
                        <div class="<?php echo e($textAlignClass); ?>">
                            <?php if($title): ?>
                                <h2 class="content-title" style="color: white;"><?php echo e($title); ?></h2>
                            <?php endif; ?>
                            <?php if($bodyContent): ?>
                                <div class="content-text" style="color: rgba(255,255,255,0.9);">
                                    <?php echo $bodyContent; ?>

                                </div>
                            <?php endif; ?>
                            <?php if($linkText && $linkUrl): ?>
                                <div class="content-action mt-4">
                                    <a href="<?php echo e($linkUrl); ?>" class="react-btn"><?php echo e($linkText); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        
        <?php if(in_array($columnCount, ['2', '3', '4']) && in_array($layoutStyle, ['default', 'card'])): ?>
        <div class="row">
            
            <div class="<?php echo e($colClass); ?> mb-4">
                <div class="column-item <?php echo e($layoutStyle === 'card' ? 'card-style' : ''); ?>" 
                     style="<?php echo e($layoutStyle === 'card' ? 'background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);' : ''); ?>">
                    
                    <?php if($image): ?>
                        <div class="item-image mb-3">
                            <img src="<?php echo e(asset($image)); ?>" class="img-fluid rounded" alt="<?php echo e($title); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <?php if($videoEmbed && !$image): ?>
                        <div class="item-video mb-3">
                            <?php echo $videoEmbed; ?>

                        </div>
                    <?php endif; ?>

                    <?php if($subtitle): ?>
                        <span class="item-subtitle" style="color: #667eea; font-size: 0.9rem;"><?php echo e($subtitle); ?></span>
                    <?php endif; ?>

                    <?php if($title): ?>
                        <h4 class="item-title" style="margin: 10px 0;"><?php echo e($title); ?></h4>
                    <?php endif; ?>

                    <?php if($bodyContent): ?>
                        <div class="item-content" style="color: #6c757d; line-height: 1.6;">
                            <?php echo Str::limit(strip_tags($bodyContent), 150); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($linkText && $linkUrl): ?>
                        <div class="item-action mt-3">
                            <a href="<?php echo e($linkUrl); ?>" class="<?php echo e($btnClass); ?>" style="font-size: 0.9rem;"><?php echo e($linkText); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<style>
/* Page Content Section Styles */
.page-content-section {
    position: relative;
    width: 100%;
}

.page-content-section .content-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.page-content-section .content-subtitle {
    display: block;
    font-size: 1rem;
    color: #667eea;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.page-content-section .content-text {
    color: #6c757d;
    font-size: 1.1rem;
    line-height: 1.8;
}

.page-content-section .content-text p {
    margin-bottom: 1rem;
}

/* Card Style */
.card-style {
    border: 1px solid #e0e0e0;
}

/* Video Wrapper */
.video-wrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
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

/* Stacked Layout */
.stacked-layout.reverse {
    display: flex;
    flex-direction: column-reverse;
}

/* Text alignment utilities */
.text-left {
    text-align: left;
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .page-content-section .content-title {
        font-size: 1.8rem;
    }
    
    .page-content-section .content-text {
        font-size: 1rem;
    }
    
    .full-width-image .overlay-content {
        padding: 40px 0 !important;
    }
}
</style>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/partials/page-content-section.blade.php ENDPATH**/ ?>