<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - ISM Prayer Network</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    <link href="<?php echo e(asset('assets/css/admin.css')); ?>" rel="stylesheet">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-praying-hands"></i>
                </div>
                <div>
                    <h5 class="sidebar-title">ISM Admin</h5>
                    <small class="sidebar-subtitle">Prayer Network</small>
                </div>
            </div>
            
            <!-- Sidebar Navigation -->
            <nav class="sidebar-nav">
                <!-- Main Navigation -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-home"></i>
                        Main
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </div>
                
                <!-- Users & Groups -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-users"></i>
                        Users & Groups
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users')); ?>">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                            <span class="nav-badge">12</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.groups*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.groups')); ?>">
                            <i class="fas fa-users-cog"></i>
                            <span>Groups</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.coordinators*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.coordinators')); ?>">
                            <i class="fas fa-user-tie"></i>
                            <span>Coordinators</span>
                        </a>
                    </div>
                </div>
                
                <!-- Content Management -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-edit"></i>
                        Content
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.news.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.news.index')); ?>">
                            <i class="fas fa-newspaper"></i>
                            <span>News & Events</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.programs*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.programs')); ?>">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Programs</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.testimonies*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.testimonies')); ?>">
                            <i class="fas fa-heart"></i>
                            <span>Testimonies</span>
                        </a>
                    </div>
                </div>
                
                <!-- Media -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-photo-video"></i>
                        Media
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.streams*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.streams')); ?>">
                            <i class="fas fa-video"></i>
                            <span>Streams</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.radios*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.radios')); ?>">
                            <i class="fas fa-broadcast-tower"></i>
                            <span>Radio</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.worship-music*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.worship-music')); ?>">
                            <i class="fas fa-music"></i>
                            <span>Worship Music</span>
                        </a>
                    </div>
                </div>
                
                <!-- Prayer -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-praying-hands"></i>
                        Prayer
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.prayer-requests*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.prayer-requests.index')); ?>">
                            <i class="fas fa-hands-praying"></i>
                            <span>Prayer Requests</span>
                            <span class="nav-badge">5</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.prayer-points*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.prayer-points.index')); ?>">
                            <i class="fas fa-comments"></i>
                            <span>Prayer Points</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.prayer-resources*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.prayer-resources')); ?>">
                            <i class="fas fa-book-open"></i>
                            <span>Prayer Resources</span>
                        </a>
                    </div>
                </div>
                
                <!-- Resources -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-book"></i>
                        Resources
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.books*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.books.index')); ?>">
                            <i class="fas fa-book"></i>
                            <span>Books</span>
                        </a>
                    </div>
                </div>
                
                <!-- Site Management -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-cogs"></i>
                        Site
                    </div>
                    <button class="nav-collapse-btn" type="button" data-bs-toggle="collapse" data-bs-target="#siteManagement" aria-expanded="true">
                        <span><i class="fas fa-cog me-2"></i>Site Management</span>
                        <i class="fas fa-chevron-down collapsed-icon"></i>
                    </button>
                    <div class="nav-collapse-content collapse show" id="siteManagement">
                        <div class="nav-item mt-2">
                            <a class="nav-link ps-4 <?php echo e(request()->routeIs('admin.page-content*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.page-content.sliders')); ?>">
                                <i class="fas fa-sliders-h"></i>
                                <span>Page Content</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link ps-4 <?php echo e(request()->routeIs('admin.general-content*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.page-content.index')); ?>">
                                <i class="fas fa-file-alt"></i>
                                <span>General Content</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link ps-4" href="<?php echo e(route('admin.reports')); ?>">
                                <i class="fas fa-chart-bar"></i>
                                <span>Analytics</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- System -->
                <div class="nav-section">
                    <div class="nav-section-title">
                        <i class="fas fa-tools"></i>
                        System
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.translations*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.translations.index')); ?>">
                            <i class="fas fa-language"></i>
                            <span>Translations</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('admin.notifications.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.notifications.index')); ?>">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                            <span class="nav-badge">3</span>
                        </a>
                    </div>
                </div>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="sidebar-footer">
                <a class="nav-link" href="<?php echo e(route('home')); ?>" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>View Website</span>
                </a>
                <a class="nav-link" href="<?php echo e(route('admin.logout')); ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <div class="admin-main">
            <!-- Admin Header -->
            <header class="admin-header">
                <!-- Hamburger Menu -->
                <button class="hamburger-btn" id="hamburgerBtn" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Search Bar -->
                <div class="header-search">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" class="search-input" placeholder="Search users, groups, content..." id="adminSearch">
                    </div>
                </div>
                
                <!-- Header Actions -->
                <div class="header-actions">
                    <!-- Dark Mode Toggle -->
                    <div class="dark-mode-toggle">
                        <div class="theme-switch" id="themeToggle">
                            <i class="fas fa-sun"></i>
                            <i class="fas fa-moon"></i>
                        </div>
                    </div>
                    
                    <!-- Language Switcher -->
                    <div class="language-switcher">
                        <button class="lang-btn" type="button" id="langBtn">
                            <?php
                            $locale = app()->getLocale();
                            $flagMap = [
                                'en' => 'us',
                                'es' => 'es',
                                'fr' => 'fr',
                                'pt' => 'pt',
                                'de' => 'de',
                                'it' => 'it',
                                'nl' => 'nl',
                                'zh' => 'cn',
                                'ja' => 'jp',
                                'ko' => 'kr',
                                'ar' => 'sa',
                                'hi' => 'in',
                            ];
                            $currentFlag = $flagMap[$locale] ?? $locale;
                            ?>
                            <img src="https://flagcdn.com/w20/<?php echo e($currentFlag); ?>.png" alt="<?php echo e($locale); ?>">
                            <span><?php echo e(strtoupper($locale)); ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="langMenu">
                            <a class="dropdown-item" href="<?php echo e(route('admin.language', 'en')); ?>">
                                <img src="https://flagcdn.com/w20/us.png" alt="EN">
                                <span>English</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo e(route('admin.language', 'es')); ?>">
                                <img src="https://flagcdn.com/w20/es.png" alt="ES">
                                <span>Español</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo e(route('admin.language', 'fr')); ?>">
                                <img src="https://flagcdn.com/w20/fr.png" alt="FR">
                                <span>Français</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo e(route('admin.language', 'pt')); ?>">
                                <img src="https://flagcdn.com/w20/pt.png" alt="PT">
                                <span>Português</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Notifications -->
                    <div class="notifications-dropdown">
                        <button class="header-action-btn" type="button" id="notificationBtn">
                            <i class="far fa-bell"></i>
                            <span class="notification-dot"></span>
                        </button>
                        <div class="notifications-panel" id="notificationsPanel">
                            <div class="notifications-header">
                                <span class="notifications-title">Notifications</span>
                                <span class="notifications-mark-read">Mark all read</span>
                            </div>
                            <div class="notifications-list">
                                <div class="notification-item unread">
                                    <div class="notification-icon" style="background: rgba(102, 126, 234, 0.15); color: #667eea;">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text"><strong>New user registered</strong> - John Doe joined today</p>
                                        <span class="notification-time">2 minutes ago</span>
                                    </div>
                                </div>
                                <div class="notification-item unread">
                                    <div class="notification-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;">
                                        <i class="fas fa-pray"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text"><strong>New prayer request</strong> - Urgent prayer needed</p>
                                        <span class="notification-time">1 hour ago</span>
                                    </div>
                                </div>
                                <div class="notification-item">
                                    <div class="notification-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text"><strong>New testimony</strong> - God is moving!</p>
                                        <span class="notification-time">3 hours ago</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-footer">
                                <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-sm btn-secondary w-100">View All Notifications</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="user-profile" id="userProfile">
                        <button class="profile-btn" type="button">
                            <div class="profile-avatar">
                                <?php echo e(substr(Auth::user()->name ?? 'A', 0, 1)); ?><?php echo e(substr(Auth::user()->last_name ?? 'dmin', 0, 1)); ?>

                            </div>
                            <div class="profile-info">
                                <span class="profile-name"><?php echo e(Auth::user()->name ?? 'Admin'); ?> <?php echo e(Auth::user()->last_name ?? ''); ?></span>
                                <span class="profile-role">Administrator</span>
                            </div>
                            <i class="fas fa-chevron-down profile-dropdown-icon"></i>
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="profile-avatar" style="width: 48px; height: 48px; font-size: 16px;">
                                        <?php echo e(substr(Auth::user()->name ?? 'A', 0, 1)); ?><?php echo e(substr(Auth::user()->last_name ?? 'dmin', 0, 1)); ?>

                                    </div>
                                    <div>
                                        <div class="fw-semibold"><?php echo e(Auth::user()->name ?? 'Admin'); ?> <?php echo e(Auth::user()->last_name ?? ''); ?></div>
                                        <div class="text-muted fs-sm"><?php echo e(Auth::user()->email ?? 'admin@ism.org'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                                <i class="fas fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo e(route('admin.settings')); ?>">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                            <a class="dropdown-item" href="<?php echo e(route('admin.password')); ?>">
                                <i class="fas fa-key"></i>
                                <span>Change Password</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo e(route('admin.logout')); ?>" style="color: var(--admin-danger);">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content -->
            <main class="admin-content">
                <?php echo $__env->yieldContent('main'); ?>
            </main>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        
        // Check for saved theme preference
        const savedTheme = localStorage.getItem('admin-theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        
        if (savedTheme === 'dark') {
            themeToggle.classList.add('active');
        }
        
        themeToggle.addEventListener('click', function() {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('admin-theme', newTheme);
            
            this.classList.toggle('active');
        });
        
        // Mobile sidebar toggle
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const adminSidebar = document.getElementById('adminSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            adminSidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }
        
        hamburgerBtn.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
        
        // User profile dropdown
        const userProfile = document.getElementById('userProfile');
        const profileBtn = userProfile.querySelector('.profile-btn');
        
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userProfile.classList.toggle('open');
        });
        
        // Language dropdown
        const langBtn = document.getElementById('langBtn');
        const langMenu = document.getElementById('langMenu');
        
        langBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            langMenu.classList.toggle('show');
        });
        
        // Notifications dropdown
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationsPanel = document.getElementById('notificationsPanel');
        
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationsPanel.classList.toggle('open');
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!userProfile.contains(e.target)) {
                userProfile.classList.remove('open');
            }
            if (!langMenu.contains(e.target) && !langBtn.contains(e.target)) {
                langMenu.classList.remove('show');
            }
            if (!notificationsPanel.contains(e.target) && !notificationBtn.contains(e.target)) {
                notificationsPanel.classList.remove('open');
            }
        });
        
        // Search functionality
        const adminSearch = document.getElementById('adminSearch');
        adminSearch.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    window.location.href = '<?php echo e(route('admin.search')); ?>?q=' + encodeURIComponent(query);
                }
            }
        });
        
        // Mark notifications as read
        const markReadBtn = document.querySelector('.notifications-mark-read');
        if (markReadBtn) {
            markReadBtn.addEventListener('click', function() {
                // Make AJAX call to mark notifications as read
                fetch('<?php echo e(route('admin.notifications.mark-all-read')); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        document.querySelectorAll('.notification-item.unread').forEach(item => {
                            item.classList.remove('unread');
                        });
                        document.querySelector('.notification-dot').style.display = 'none';
                    }
                });
            });
        }
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>