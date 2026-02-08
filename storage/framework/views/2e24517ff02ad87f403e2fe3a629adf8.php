<?php $__env->startSection('title', 'Reports'); ?>

<?php $__env->startSection('main'); ?>
    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="fas fa-home me-1"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-chart-bar me-1"></i>
                    Reports
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Admin Reports</h1>
            <p class="page-subtitle">View analytics and reports for your prayer network.</p>
        </div>
        <div class="page-actions">
            <div class="export-buttons">
                <button class="btn btn-primary" type="button" onclick="toggleExportDropdown()" id="exportBtn">
                    <i class="fas fa-download me-1"></i>
                    Export Report
                </button>
                <div class="export-links" id="exportLinks" style="display: none;">
                    <a class="export-link" href="<?php echo e(route('admin.reports.export', ['type' => 'all', 'format' => 'csv'])); ?>">
                        <i class="fas fa-file-csv me-1"></i> All Data (CSV)
                    </a>
                    <a class="export-link" href="<?php echo e(route('admin.reports.export', ['type' => 'users', 'format' => 'csv'])); ?>">
                        <i class="fas fa-users me-1"></i> Users (CSV)
                    </a>
                    <a class="export-link" href="<?php echo e(route('admin.reports.export', ['type' => 'groups', 'format' => 'csv'])); ?>">
                        <i class="fas fa-users-cog me-1"></i> Groups (CSV)
                    </a>
                    <a class="export-link" href="<?php echo e(route('admin.reports.export', ['type' => 'prayers', 'format' => 'csv'])); ?>">
                        <i class="fas fa-praying-hands me-1"></i> Prayers (CSV)
                    </a>
                    <a class="export-link" href="<?php echo e(route('admin.reports.export', ['type' => 'testimonies', 'format' => 'csv'])); ?>">
                        <i class="fas fa-heart me-1"></i> Testimonies (CSV)
                    </a>
                    <a class="export-link" href="<?php echo e(route('admin.reports.export', ['type' => 'all', 'format' => 'json'])); ?>">
                        <i class="fas fa-code me-1"></i> JSON Format
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($stats['users'] ?? 0); ?></h3>
                <p class="stat-label">Total Users</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+<?php echo e($stats['userGrowth'] ?? 12); ?>% this month</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($stats['groups'] ?? 0); ?></h3>
                <p class="stat-label">Prayer Groups</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+<?php echo e($stats['groupGrowth'] ?? 8); ?>% this month</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-praying-hands"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($stats['prayers'] ?? 0); ?></h3>
                <p class="stat-label">Prayer Requests</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+<?php echo e($stats['prayerGrowth'] ?? 15); ?>% this month</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($stats['testimonies'] ?? 0); ?></h3>
                <p class="stat-label">Testimonies</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+<?php echo e($stats['testimonyGrowth'] ?? 5); ?>% this month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mt-2 fade-in" style="animation-delay: 0.1s;">
        
        <!-- User Growth Chart -->
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">User Growth Over Time</h5>
                    <div class="card-actions">
                        <select class="chart-filter" id="userGrowthPeriod" onchange="updateUserGrowthChart()">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                            <option value="365">Last Year</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="userGrowthChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- User Distribution Chart -->
        <div class="col-lg-4">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">Users by Role</h5>
                </div>
                <div class="card-body">
                    <canvas id="userRoleChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Charts -->
    <div class="row g-4 mt-2 fade-in" style="animation-delay: 0.2s;">
        
        <!-- Prayer Activity Chart -->
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">Prayer Requests Over Time</h5>
                    <div class="card-actions">
                        <select class="chart-filter" id="prayerPeriod" onchange="updatePrayerChart()">
                            <option value="7">Last 7 Days</option>
                            <option value="30" selected>Last 30 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="prayerChart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Groups Distribution -->
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">Groups by Category</h5>
                </div>
                <div class="card-body">
                    <canvas id="groupsChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Row Charts -->
    <div class="row g-4 mt-2 fade-in" style="animation-delay: 0.3s;">
        
        <!-- Activity Heatmap -->
        <div class="col-lg-12">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">Weekly Activity Heatmap</h5>
                </div>
                <div class="card-body">
                    <canvas id="activityHeatmap" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="row g-4 mt-2 fade-in" style="animation-delay: 0.4s;">
        <div class="col-lg-12">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">Recent Activity</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($recentActivities) && count($recentActivities) > 0): ?>
                                    <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($activity['description']); ?></td>
                                        <td><?php echo e($activity['user']); ?></td>
                                        <td><span class="badge bg-<?php echo e($activity['type_color']); ?>"><?php echo e($activity['type']); ?></span></td>
                                        <td><?php echo e($activity['date']); ?></td>
                                        <td><span class="badge bg-<?php echo e($activity['status_color']); ?>"><?php echo e($activity['status']); ?></span></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No recent activity</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Color palette
        const colors = {
            primary: '#667eea',
            secondary: '#764ba2',
            success: '#10b981',
            warning: '#f59e0b',
            danger: '#ef4444',
            info: '#3b82f6',
            gray: '#6b7280'
        };

        const chartColors = [
            colors.primary,
            colors.success,
            colors.warning,
            colors.danger,
            colors.info,
            colors.secondary
        ];

        // User Growth Chart
        let userGrowthChart;
        function initUserGrowthChart() {
            const ctx = document.getElementById('userGrowthChart').getContext('2d');
            userGrowthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($userGrowthLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']); ?>,
                    datasets: [{
                        label: 'New Users',
                        data: <?php echo json_encode($userGrowthData ?? [10, 25, 32, 45, 67, 89]); ?>,
                        borderColor: colors.primary,
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        fill: true,
                        tension: 0.4
                    }, {
                        label: 'Active Users',
                        data: <?php echo json_encode($activeUserData ?? [8, 20, 28, 40, 58, 78]); ?>,
                        borderColor: colors.success,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function updateUserGrowthChart() {
            // In a real implementation, this would fetch new data via AJAX
            // For now, we'll simulate the update
            const period = document.getElementById('userGrowthPeriod').value;
            userGrowthChart.options.plugins.title = {
                display: true,
                text: 'User Growth - Last ' + period + ' Days'
            };
            userGrowthChart.update();
        }

        // User Role Chart
        let userRoleChart;
        function initUserRoleChart() {
            const ctx = document.getElementById('userRoleChart').getContext('2d');
            userRoleChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode($userRoleLabels ?? ['Members', 'Leaders', 'Coordinators', 'Admins']); ?>,
                    datasets: [{
                        data: <?php echo json_encode($userRoleData ?? [65, 25, 8, 2]); ?>,
                        backgroundColor: chartColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        // Prayer Activity Chart
        let prayerChart;
        function initPrayerChart() {
            const ctx = document.getElementById('prayerChart').getContext('2d');
            prayerChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($prayerLabels ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']); ?>,
                    datasets: [{
                        label: 'Prayer Requests',
                        data: <?php echo json_encode($prayerData ?? [12, 19, 15, 25, 22, 8, 5]); ?>,
                        backgroundColor: colors.primary,
                        borderRadius: 8
                    }, {
                        label: 'Prayers Answered',
                        data: <?php echo json_encode($prayerAnsweredData ?? [8, 12, 10, 18, 15, 4, 3]); ?>,
                        backgroundColor: colors.success,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function updatePrayerChart() {
            const period = document.getElementById('prayerPeriod').value;
            prayerChart.options.plugins.title = {
                display: true,
                text: 'Prayer Activity - Last ' + period + ' Days'
            };
            prayerChart.update();
        }

        // Groups Category Chart
        let groupsChart;
        function initGroupsChart() {
            const ctx = document.getElementById('groupsChart').getContext('2d');
            groupsChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($groupCategoryLabels ?? ['Prayer', 'Worship', 'Study', 'Fellowship', 'Outreach']); ?>,
                    datasets: [{
                        data: <?php echo json_encode($groupCategoryData ?? [35, 25, 20, 12, 8]); ?>,
                        backgroundColor: chartColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Activity Heatmap Chart
        let activityHeatmap;
        function initActivityHeatmap() {
            const ctx = document.getElementById('activityHeatmap').getContext('2d');
            
            // Generate sample data for heatmap
            const hours = ['12am', '3am', '6am', '9am', '12pm', '3pm', '6pm', '9pm'];
            const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            
            const heatmapData = [];
            days.forEach((day, dayIndex) => {
                hours.forEach((hour, hourIndex) => {
                    heatmapData.push({
                        x: hour,
                        y: day,
                        v: Math.floor(Math.random() * 100)
                    });
                });
            });

            activityHeatmap = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: days,
                    datasets: [{
                        label: 'Activity Level',
                        data: <?php echo json_encode($weeklyActivityData ?? [85, 92, 78, 95, 88, 45, 52]); ?>,
                        borderColor: colors.primary,
                        backgroundColor: 'rgba(102, 126, 234, 0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Daily Activity Pattern'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Activity Level'
                            }
                        }
                    }
                }
            });
        }


        // Initialize all charts on page load
        document.addEventListener('DOMContentLoaded', function() {
            initUserGrowthChart();
            initUserRoleChart();
            initPrayerChart();
            initActivityHeatmap();
        });
        
        // Custom dropdown toggle function
        function toggleExportDropdown() {
            const links = document.getElementById('exportLinks');
            if (links) {
                if (links.style.display === 'none') {
                    links.style.display = 'block';
                } else {
                    links.style.display = 'none';
                }
            }
        }
    </script>
    <style>
        .chart-filter {
            padding: 6px 12px;
            border: 1px solid var(--admin-border-color);
            border-radius: var(--admin-border-radius-sm);
            background: var(--admin-bg-light);
            font-size: 13px;
        }
        
        .card-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        /* Export buttons styles */
        .export-buttons {
            position: relative;
            z-index: 1000;
        }
        
        .export-links {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            min-width: 200px;
            background: var(--admin-bg-card);
            border: 1px solid var(--admin-border-color);
            border-radius: var(--admin-border-radius);
            box-shadow: var(--admin-shadow-lg);
            z-index: 1001;
            padding: 8px 0;
        }
        
        .export-links.show {
            display: block;
        }
        
        .export-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            color: var(--admin-text-primary);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.15s ease;
        }
        
        .export-link:hover {
            background: var(--admin-bg-light);
            color: var(--admin-primary);
        }
        
        .export-link i {
            width: 16px;
            text-align: center;
            color: var(--admin-text-secondary);
        }
        
        .export-link:hover i {
            color: var(--admin-primary);
        }
    </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/reports.blade.php ENDPATH**/ ?>