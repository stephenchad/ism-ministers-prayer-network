<?php $__env->startSection('main'); ?>
<style>
    /* RTL Support for home page */
    html[dir="rtl"] .slider-btn {
        text-align: start;
    }
    
    /* Fix slider content alignment in RTL */
    html[dir="rtl"] .slider-content .content-part {
        text-align: start;
    }
    
    /* RTL fixes for icons that point right */
    html[dir="rtl"] .fa-arrow-right,
    html[dir="rtl"] .fa-long-arrow-alt-right {
        transform: scaleX(-1);
    }
    
    /* RTL text alignment for section headings */
    html[dir="rtl"] .text-center {
        text-align: center !important;
    }
    
    /* RTL for CTA buttons - add margin top */
    html[dir="rtl"] .slider-btn,
    html[dir="rtl"] a[style*="display: inline-block"] {
        margin-top: 15px;
    }
    
    /* RTL slider fixes - prevent image disappearance */
    html[dir="rtl"] .react-slider-part .single-slide {
        direction: ltr;
    }
    
    html[dir="rtl"] .react-slider-part .slider-img {
        width: 100%;
        overflow: hidden;
    }
    
    html[dir="rtl"] .react-slider-part .slider-img img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    
    html[dir="rtl"] .react-slider-part .slider-content {
        direction: rtl;
        text-align: right;
    }
    
    /* Ensure slider container has proper height in RTL */
    html[dir="rtl"] .home-sliders {
        min-height: 400px;
    }
    
    html[dir="rtl"] .single-slide .slider-img img.desktop {
        display: block !important;
    }
</style>
<!--================= Wrapper Start Here =================-->
<div class="react-wrapper">
    <div class="react-wrapper-inner">
        
        <!--================= Slider Section Start Here =================-->
        <div class="react-slider-part">
            <div class="home-sliders home2 owl-carousel">
                <?php $__empty_1 = true; $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="single-slide">
                    <div class="slider-img">
                        <?php if($slider->desktop_image): ?>
                            <img class="desktop" src="<?php echo e(asset($slider->desktop_image)); ?>" alt="<?php echo e($slider->title); ?>">
                        <?php else: ?>
                            <img class="desktop" src="<?php echo e(asset('assets/images/slider/30-DAYS-PRAYER-FEST-WEBSITE-BANNER.jpeg')); ?>" alt="<?php echo e($slider->title); ?>">
                        <?php endif; ?>
                        <?php if($slider->mobile_image): ?>
                            <img class="mobile" src="<?php echo e(asset($slider->mobile_image)); ?>" alt="<?php echo e($slider->title); ?>">
                        <?php else: ?>
                            <img class="mobile" src="<?php echo e(asset('assets/images/slider/11.jpg')); ?>" alt="<?php echo e($slider->title); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="container">
                        <div class="slider-content">
                            <div class="content-part">
                                <span class="slider-pretitle"><?php echo e($slider->subtitle); ?></span>
                                <h2 class="slider-title">
                                    <?php echo e($slider->title); ?>

                                </h2>
                                <?php if($slider->button_text && $slider->button_url): ?>
                                <div class="slider-btn">
                                    <a href="<?php echo e($slider->button_url); ?>" class="react-btn-border"><?php echo e($slider->button_text); ?></a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Fallback to static sliders if no dynamic content exists -->
                <div class="single-slide">
                    <div class="slider-img">
                        <img class="desktop" src="<?php echo e(asset('assets/images/slider/30-DAYS-PRAYER-FEST-WEBSITE-BANNER.jpeg')); ?>" alt="30 Days Prayer Festival">
                        <img class="mobile" src="<?php echo e(asset('assets/images/slider/11.jpg')); ?>" alt="30 Days Prayer Festival Mobile">
                    </div>
                    <div class="container">
                        <div class="slider-content">
                            <div class="content-part">
                                <span class="slider-pretitle">United in Prayer</span>
                                <h2 class="slider-title">
                                    Join a global community of ministers in prayer
                                </h2>
                                <div class="slider-btn">
                                    <a href="<?php echo e(route('account.registration')); ?>" class="react-btn-border">Join Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!--================= Slider Section End Here =================-->

        <!--================= Live Prayer Sessions Section Start Here =================-->
        <?php echo $__env->make('front.partials.live_prayer_session', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--================= Live Prayer Sessions Section End Here =================-->

        <!--================= Prayer Services Section Start Here =================-->
        <?php if($howWeServeSection && $howWeServeSection->meta_data): ?>
        <div style="padding: 100px 0; background: #f8f9fa;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;"><?php echo e($howWeServeSection->title); ?></h2>
                    <p style="color: #6c757d; font-size: 1.1rem;"><?php echo e($howWeServeSection->subtitle); ?></p>
                </div>
                <div class="row">
                    <?php $__currentLoopData = is_string($howWeServeSection->meta_data) ? json_decode($howWeServeSection->meta_data, true) ?? [] : ($howWeServeSection->meta_data ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="background: white; border-radius: 15px; padding: 40px 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                                <i class="fas <?php echo e($item['icon'] ?? 'fa-praying-hands'); ?>" style="font-size: 2rem; color: white;"></i>
                            </div>
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;"><?php echo e($item['title']); ?></h4>
                            <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6;"><?php echo e($item['description']); ?></p>
                            <a href="<?php echo e($item['url']); ?>" style="color: #667eea; font-weight: 600; text-decoration: none;"><?php echo e($item['button_text'] ?? 'Learn More →'); ?></a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Fallback static section if no dynamic content -->
        <div style="padding: 100px 0; background: #f8f9fa;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;">How We Serve</h2>
                    <p style="color: #6c757d; font-size: 1.1rem;">Tools and ministries to help you pray and grow</p>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="background: white; border-radius: 15px; padding: 40px 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                                <i class="fas fa-praying-hands" style="font-size: 2rem; color: white;"></i>
                            </div>
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Prayer Requests</h4>
                            <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6;">Share your requests and let ministers stand in faith with you.</p>
                            <a href="<?php echo e(route('prayers')); ?>" style="color: #667eea; font-weight: 600; text-decoration: none;">Submit a Request →</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="background: white; border-radius: 15px; padding: 40px 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                                <i class="fas fa-users" style="font-size: 2rem; color: white;"></i>
                            </div>
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Prayer Groups</h4>
                            <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6;">Connect with local or online groups to pray together.</p>
                            <a href="<?php echo e(route('groups.index')); ?>" style="color: #667eea; font-weight: 600; text-decoration: none;">Join Groups →</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="background: white; border-radius: 15px; padding: 40px 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                                <i class="fas fa-heart" style="font-size: 2rem; color: white;"></i>
                            </div>
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Testimonies</h4>
                            <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6;">Read inspiring stories of answered prayers.</p>
                            <a href="<?php echo e(route('testimonies')); ?>" style="color: #667eea; font-weight: 600; text-decoration: none;">Read Stories →</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="background: white; border-radius: 15px; padding: 40px 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                                <i class="fas fa-book-open" style="font-size: 2rem; color: white;"></i>
                            </div>
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Prayer Points</h4>
                            <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6;">Follow powerful, Spirit-led prayer points daily.</p>
                            <a href="<?php echo e(route('prayer-points.index')); ?>" style="color: #667eea; font-weight: 600; text-decoration: none;">Read Points →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!--================= Prayer Services Section End Here =================-->

        <!--================= Featured Prayer Points Section Start Here =================-->
        <?php if($prayerPoints->isNotEmpty()): ?>
        <div style="padding: 100px 0; background: white;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Featured Prayer Points</h2>
                    <p style="color: #6c757d; font-size: 1.1rem;">Pray with these timely points</p>
                </div>
                <div class="row">
                    <?php $__currentLoopData = $prayerPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 mb-4">
                        <div style="background: white; border-radius: 20px; padding: 40px 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); height: 100%; text-align: center; cursor: pointer;" onclick="window.location.href='<?php echo e(route('prayer-points.show', $point->id)); ?>'">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; color: white; font-size: 1.5rem; font-weight: 700;">
                                <i class="fas fa-praying-hands"></i>
                            </div>
                            <h5 style="color: #333; margin-bottom: 15px; font-weight: 600;"><?php echo e($point->title); ?></h5>
                            <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6; font-style: italic;">"<?php echo e(Str::limit($point->content, 120)); ?>"</p>
                            <p style="color: #667eea; font-weight: 600; margin: 0;">Read more →</p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo e(route('prayer-points.index')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        View all →
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!--================= Featured Prayer Points Section End Here =================-->

        <!--================= About Section Start Here =================-->
        <div style="padding: 100px 0; background: white;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div style="position: relative;">
                            <img src="<?php echo e(asset('assets/images/about/about2.png')); ?>" alt="Prayer Community" style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);" onerror="this.onerror=null;this.src='<?php echo e(asset('assets/images/about/about22.png')); ?>'">
                            <div style="position: absolute; top: -30px; inset-inline-end: -30px; width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; font-weight: 700; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.2);">
                                24/7<br>Prayer
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div style="padding-inline-start: 40px;">
                            <h2 style="font-size: 2.8rem; font-weight: 700; color: #333; margin-bottom: 25px; line-height: 1.2;">About the Prayer Network</h2>
                            <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 25px; line-height: 1.7;">We connect and equip ministers to pray effectively, uniting faith and purpose in every nation.</p>
                            <p style="color: #6c757d; margin-bottom: 30px; line-height: 1.7;">Through resources, fellowship, and programs, we inspire a lifestyle of prayer and impact.</p>
                            
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 15px;">
                                        <h3 style="color: #667eea; font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">50K+</h3>
                                        <p style="color: #6c757d; margin: 0; font-weight: 600;">Prayer Partners</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 15px;">
                                        <h3 style="color: #667eea; font-size: 2.5rem; font-weight: 700; margin-bottom: 5px;">150+</h3>
                                        <p style="color: #6c757d; margin: 0; font-weight: 600;">Countries</p>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="<?php echo e(route('about')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                Learn More →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--================= About Section End Here =================-->

        <!--================= Prayer Impact Section Start Here =================-->
        <?php if($homeStats->isNotEmpty()): ?>
        <div style="padding: 100px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Our Impact</h2>
                    <p style="font-size: 1.1rem; opacity: 0.9;">Together, we are making a difference through prayer</p>
                </div>
                <div class="row">
                    <?php $__currentLoopData = $homeStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="text-align: center; padding: 30px; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                            <h3 style="font-size: 3rem; font-weight: 700; margin-bottom: 10px;"><?php echo e($stat->value); ?></h3>
                            <h5 style="margin-bottom: 10px; font-weight: 600;"><?php echo e($stat->label); ?></h5>
                            <p style="opacity: 0.8; margin: 0;"><?php echo e($stat->description); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Fallback static section if no dynamic stats -->
        <div style="padding: 100px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Our Impact</h2>
                    <p style="font-size: 1.1rem; opacity: 0.9;">Together, we are making a difference through prayer</p>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="text-align: center; padding: 30px; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                            <h3 style="font-size: 3rem; font-weight: 700; margin-bottom: 10px;">24/7</h3>
                            <h5 style="margin-bottom: 10px; font-weight: 600;">Hours of Prayer</h5>
                            <p style="opacity: 0.8; margin: 0;">Continuous intercession around the world</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="text-align: center; padding: 30px; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                            <h3 style="font-size: 3rem; font-weight: 700; margin-bottom: 10px;">10K+</h3>
                            <h5 style="margin-bottom: 10px; font-weight: 600;">Prayer Requests</h5>
                            <p style="opacity: 0.8; margin: 0;">Answered and counting</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="text-align: center; padding: 30px; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                            <h3 style="font-size: 3rem; font-weight: 700; margin-bottom: 10px;">500+</h3>
                            <h5 style="margin-bottom: 10px; font-weight: 600;">Prayer Groups</h5>
                            <p style="opacity: 0.8; margin: 0;">Active communities worldwide</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div style="text-align: center; padding: 30px; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                            <h3 style="font-size: 3rem; font-weight: 700; margin-bottom: 10px;">365</h3>
                            <h5 style="margin-bottom: 10px; font-weight: 600;">Days a Year</h5>
                            <p style="opacity: 0.8; margin: 0;">Never-ending commitment to prayer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!--================= Prayer Impact Section End Here =================-->

        <!--================= Programs Section Start Here =================-->
        <div style="padding: 100px 0; background: white;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Programs</h2>
                    <p style="color: #6c757d; font-size: 1.1rem;">Discover ongoing programs and initiatives</p>
                </div>
                <div class="row">
                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; cursor: pointer; transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='<?php echo e(route('programs.show', $program->slug)); ?>'">
                                <?php if($program->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $program->image)); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo e($program->title); ?>">
                                <?php else: ?>
                                    <div style="height: 200px; background: <?php echo e($program->color); ?>; display: flex; align-items: center; justify-content: center;">
                                        <i class="<?php echo e($program->icon); ?>" style="font-size: 4rem; color: white;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body" style="background: <?php echo e($program->color); ?>; color: white; text-align: center; padding: 30px; display: flex; flex-direction: column; justify-content: space-between; flex: 1;">
                                    <div>
                                        <h4 style="margin-bottom: 20px; font-weight: 600;"><?php echo e($program->title); ?></h4>
                                        <p style="opacity: 0.9; line-height: 1.6; margin-bottom: 25px;"><?php echo e($program->description); ?></p>
                                    </div>
                                    <div style="background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 25px; display: inline-block; font-weight: 600;">Learn More →</div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <!--================= Programs Section End Here =================-->

        <!--================= News & Events Section Start Here =================-->
        <div style="padding: 100px 0; background: #f8f9fa;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;">News & Events</h2>
                    <p style="color: #6c757d; font-size: 1.1rem;">Latest updates and upcoming events</p>
                </div>
                <div class="row">
                    <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden; cursor: pointer; transition: transform 0.3s ease; height: 100%;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'" onclick="window.location.href='<?php echo e(route('news.show', $article->slug)); ?>'">
                                <?php if($article->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $article->image)); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo e($article->title); ?>">
                                <?php else: ?>
                                    <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas <?php echo e($article->type == 'event' ? 'fa-calendar-alt' : 'fa-newspaper'); ?>" style="font-size: 4rem; color: white;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body" style="padding: 30px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                        <span style="background: <?php echo e($article->type == 'event' ? '#28a745' : '#667eea'); ?>; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;"><?php echo e($article->type); ?></span>
                                        <small style="color: #6c757d;"><?php echo e($article->created_at->format('M d, Y')); ?></small>
                                    </div>
                                    <h5 style="color: #333; margin-bottom: 15px; font-weight: 600; line-height: 1.4;"><?php echo e($article->title); ?></h5>
                                    <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6;"><?php echo e(Str::limit($article->excerpt, 100)); ?></p>
                                    <?php if($article->type == 'event' && $article->event_date): ?>
                                        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                                <i class="fas fa-calendar" style="color: #667eea; margin-right: 10px;"></i>
                                                <small style="color: #333; font-weight: 600;"><?php echo e($article->event_date->format('F d, Y - g:i A')); ?></small>
                                            </div>
                                            <?php if($article->event_location): ?>
                                                <div style="display: flex; align-items: center;">
                                                    <i class="fas fa-map-marker-alt" style="color: #667eea; margin-right: 10px;"></i>
                                                    <small style="color: #6c757d;"><?php echo e($article->event_location); ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div style="color: #667eea; font-weight: 600;">Read more →</div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo e(route('news.index')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        View all →
                    </a>
                </div>
            </div>
        </div>
        <!--================= News & Events Section End Here =================-->

        <!--================= Featured Books Section Start Here =================-->
        <div style="padding: 100px 0; background: white;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Featured Books</h2>
                    <p style="color: #6c757d; font-size: 1.1rem;">Discover inspiring books for your spiritual journey</p>
                </div>
                <?php if(!empty($books) && count($books) > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); height: 100%; cursor: pointer; transition: transform 0.3s ease;" onclick="window.location.href='<?php echo e(route('books.view', $book['id'])); ?>'" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                            <?php if(isset($book['cover_image'])): ?>
                                <img src="<?php echo e($book['cover_image']); ?>" alt="<?php echo e($book['title']); ?>" style="width: 100%; height: 250px; object-fit: cover; border-radius: 10px; margin-bottom: 20px;">
                            <?php else: ?>
                                <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-book" style="font-size: 4rem; color: white;"></i>
                                </div>
                            <?php endif; ?>
                            <h5 style="color: #333; margin-bottom: 10px; font-weight: 600;"><?php echo e($book['title']); ?></h5>
                            <?php if(isset($book['author'])): ?>
                                <p style="color: #6c757d; margin-bottom: 10px; font-size: 0.9rem;">by <?php echo e($book['author']); ?></p>
                            <?php endif; ?>
                            <p style="color: #6c757d; margin-bottom: 15px; line-height: 1.6;"><?php echo e(Str::limit($book['description'] ?? '', 80)); ?></p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: #667eea; font-weight: 700; font-size: 1.2rem;">$<?php echo e(number_format($book['price'] ?? 0, 2)); ?></span>
                                <span style="color: #667eea; font-weight: 600;">View Details →</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center py-5">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                        <i class="fas fa-book" style="font-size: 3rem; color: white;"></i>
                    </div>
                    <h4 style="color: #333; margin-bottom: 15px;">No books available</h4>
                    <p style="color: #6c757d; margin-bottom: 20px;">Check back soon for new books!</p>
                    <a href="<?php echo e(route('books.browse')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block;">Browse Books →</a>
                </div>
                <?php endif; ?>
                <?php if(!empty($books) && count($books) > 0): ?>
                <div class="text-center mt-4">
                    <a href="<?php echo e(route('books.browse')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        Browse All Books →
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!--================= Featured Books Section End Here =================-->

        <!--================= Testimonies Section Start Here =================-->
        <?php if($testimonies->isNotEmpty()): ?>
        <div style="padding: 100px 0; background: #f8f9fa;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 style="font-size: 2.5rem; font-weight: 700; color: #333; margin-bottom: 1rem;">Testimonies</h2>
                    <p style="color: #6c757d; font-size: 1.1rem;">Stories of God’s power at work</p>
                </div>
                <div class="row">
                    <?php $__currentLoopData = $testimonies->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimony): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 mb-4">
                        <div style="background: white; border-radius: 20px; padding: 40px 30px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); height: 100%; text-align: center;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; color: white; font-size: 1.5rem; font-weight: 700;">
                                <?php echo e(strtoupper(substr($testimony->name, 0, 2))); ?>

                            </div>
                            <h5 style="color: #333; margin-bottom: 15px; font-weight: 600;"><?php echo e($testimony->title); ?></h5>
                            <p style="color: #6c757d; margin-bottom: 20px; line-height: 1.6; font-style: italic;">"<?php echo e(Str::limit($testimony->testimony, 120)); ?>"</p>
                            <p style="color: #667eea; font-weight: 600; margin: 0;">- <?php echo e($testimony->name); ?><?php if($testimony->location): ?>, <?php echo e($testimony->location); ?><?php endif; ?></p>
                            <?php if($testimony->category): ?>
                            <span style="background: rgba(102, 126, 234, 0.1); color: #667eea; padding: 4px 12px; border-radius: 15px; font-size: 0.8rem; margin-top: 10px; display: inline-block;"><?php echo e(ucfirst($testimony->category)); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo e(route('testimonies')); ?>" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        Read more →
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!--================= Testimonies Section End Here =================-->

        <!--================= Call to Action Section Start Here =================-->
        <div style="padding: 100px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center;">
            <div class="container">
                <h2 style="font-size: 2.8rem; font-weight: 700; margin-bottom: 20px;">Take the Next Step</h2>
                <p style="font-size: 1.2rem; margin-bottom: 40px; opacity: 0.9;">Join us in prayer and connect with fellow ministers</p>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="<?php echo e(route('prayers')); ?>" style="background: rgba(255,255,255,0.2); color: white; padding: 20px 30px; border-radius: 15px; text-decoration: none; font-weight: 600; display: block; transition: all 0.3s ease; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                                    <i class="fas fa-praying-hands" style="font-size: 2rem; margin-bottom: 15px; display: block;"></i>
                                    Submit a Prayer Request
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="<?php echo e(route('groups.index')); ?>" style="background: rgba(255,255,255,0.2); color: white; padding: 20px 30px; border-radius: 15px; text-decoration: none; font-weight: 600; display: block; transition: all 0.3s ease; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                                    <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 15px; display: block;"></i>
                                    Join Prayer Groups
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--================= Call to Action Section End Here =================-->
    </div>
</div>
<!--================= Wrapper End Here =================-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/home.blade.php ENDPATH**/ ?>