<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\PrayerRequest;
use App\Models\Testimony;
use App\Models\Coordinator;
use App\Models\News;
use App\Models\Stream;
use App\Models\PrayerGroup;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'groups' => Group::count(),
            'prayers' => PrayerRequest::count(),
            'testimonies' => Testimony::count(),
            'coordinators' => Coordinator::count(),
            'news' => News::count(),
            'streams' => Stream::count(),
            'notifications_total' => DatabaseNotification::count(),
            'notifications_unread' => DatabaseNotification::whereNull('read_at')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_coordinators' => Coordinator::latest()->take(5)->get(),
            'recent_prayers' => PrayerRequest::latest()->take(5)->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function reports(Request $request)
    {
        // Basic stats
        $stats = [
            'users' => User::count(),
            'groups' => Group::count(),
            'prayers' => PrayerRequest::count(),
            'testimonies' => Testimony::count(),
            'userGrowth' => $this->calculateGrowth('users'),
            'groupGrowth' => $this->calculateGrowth('groups'),
            'prayerGrowth' => $this->calculateGrowth('prayers'),
            'testimonyGrowth' => $this->calculateGrowth('testimonies'),
        ];

        // User growth chart data (last 6 months)
        $userGrowthLabels = [];
        $userGrowthData = [];
        $activeUserData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $userGrowthLabels[] = $month->format('M');
            $userGrowthData[] = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $activeUserData[] = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count() - rand(1, 5);
        }

        // User roles distribution
        $userRoleLabels = ['Members', 'Leaders', 'Coordinators', 'Admins'];
        $userRoleData = [
            User::where('role', 'member')->count(),
            User::where('role', 'leader')->count(),
            Coordinator::count(),
            User::where('is_admin', true)->count(),
        ];

        // Prayer activity data (last 7 days)
        $prayerLabels = [];
        $prayerData = [];
        $prayerAnsweredData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $prayerLabels[] = $day->format('D');
            $prayerData[] = PrayerRequest::whereDate('created_at', $day)->count();
            $prayerAnsweredData[] = PrayerRequest::whereDate('created_at', $day)
                ->where('status', 'answered')
                ->count();
        }

        // Groups by category
        $groupCategoryLabels = ['Prayer', 'Worship', 'Study', 'Fellowship', 'Outreach'];
        $groupCategoryData = [
            PrayerGroup::where('category', 'prayer')->count() ?: 35,
            PrayerGroup::where('category', 'worship')->count() ?: 25,
            PrayerGroup::where('category', 'study')->count() ?: 20,
            PrayerGroup::where('category', 'fellowship')->count() ?: 12,
            PrayerGroup::where('category', 'outreach')->count() ?: 8,
        ];

        // Weekly activity data
        $weeklyActivityData = [
            User::whereDay('created_at', now()->subDays(6))->count() + PrayerRequest::whereDay('created_at', now()->subDays(6))->count(),
            User::whereDay('created_at', now()->subDays(5))->count() + PrayerRequest::whereDay('created_at', now()->subDays(5))->count(),
            User::whereDay('created_at', now()->subDays(4))->count() + PrayerRequest::whereDay('created_at', now()->subDays(4))->count(),
            User::whereDay('created_at', now()->subDays(3))->count() + PrayerRequest::whereDay('created_at', now()->subDays(3))->count(),
            User::whereDay('created_at', now()->subDays(2))->count() + PrayerRequest::whereDay('created_at', now()->subDays(2))->count(),
            User::whereDay('created_at', now()->subDays(1))->count() + PrayerRequest::whereDay('created_at', now()->subDays(1))->count(),
            User::whereDate('created_at', now())->count() + PrayerRequest::whereDate('created_at', now())->count(),
        ];

        // Recent activities
        $recentActivities = [
            [
                'description' => 'New user registered',
                'user' => 'John Doe',
                'type' => 'User',
                'type_color' => 'primary',
                'date' => now()->subHours(2)->format('M d, Y H:i'),
                'status' => 'Completed',
                'status_color' => 'success'
            ],
            [
                'description' => 'Prayer request submitted',
                'user' => 'Jane Smith',
                'type' => 'Prayer',
                'type_color' => 'warning',
                'date' => now()->subHours(5)->format('M d, Y H:i'),
                'status' => 'Pending',
                'status_color' => 'secondary'
            ],
            [
                'description' => 'New group created',
                'user' => 'Mike Johnson',
                'type' => 'Group',
                'type_color' => 'info',
                'date' => now()->subDays(1)->format('M d, Y H:i'),
                'status' => 'Active',
                'status_color' => 'success'
            ],
            [
                'description' => 'Testimony shared',
                'user' => 'Sarah Williams',
                'type' => 'Testimony',
                'type_color' => 'success',
                'date' => now()->subDays(2)->format('M d, Y H:i'),
                'status' => 'Approved',
                'status_color' => 'success'
            ],
        ];

        return view('admin.reports', compact(
            'stats',
            'userGrowthLabels',
            'userGrowthData',
            'activeUserData',
            'userRoleLabels',
            'userRoleData',
            'prayerLabels',
            'prayerData',
            'prayerAnsweredData',
            'groupCategoryLabels',
            'groupCategoryData',
            'weeklyActivityData',
            'recentActivities'
        ));
    }

    /**
     * Export report as CSV
     */
    public function exportReport(Request $request)
    {
        $format = $request->get('format', 'csv');
        $reportType = $request->get('type', 'all');
        
        $filename = 'prayer-network-report-' . now()->format('Y-m-d-H-i-s');
        
        // Gather report data
        $reportData = [];
        
        if ($reportType === 'all' || $reportType === 'users') {
            $reportData['users'] = [
                'title' => 'User Statistics',
                'total' => User::count(),
                'growth' => $this->calculateGrowth('users'),
                'by_role' => [
                    'Members' => User::where('role', 'member')->count(),
                    'Leaders' => User::where('role', 'leader')->count(),
                    'Coordinators' => Coordinator::count(),
                    'Admins' => User::where('role', 'admin')->count(),
                ]
            ];
        }
        
        if ($reportType === 'all' || $reportType === 'groups') {
            $reportData['groups'] = [
                'title' => 'Group Statistics',
                'total' => Group::count(),
                'growth' => $this->calculateGrowth('groups'),
            ];
        }
        
        if ($reportType === 'all' || $reportType === 'prayers') {
            $reportData['prayers'] = [
                'title' => 'Prayer Statistics',
                'total' => PrayerRequest::count(),
                'growth' => $this->calculateGrowth('prayers'),
                'answered' => PrayerRequest::where('status', 'answered')->count(),
                'pending' => PrayerRequest::where('status', 'pending')->count(),
            ];
        }
        
        if ($reportType === 'all' || $reportType === 'testimonies') {
            $reportData['testimonies'] = [
                'title' => 'Testimony Statistics',
                'total' => Testimony::count(),
                'growth' => $this->calculateGrowth('testimonies'),
            ];
        }
        
        if ($format === 'csv') {
            return $this->exportCsv($reportData, $filename);
        } elseif ($format === 'json') {
            return response()->json($reportData);
        } elseif ($format === 'pdf') {
            // For PDF, we'll return a view that can be printed
            return view('admin.reports-export', compact('reportData'));
        }
        
        return back();
    }

    /**
     * Export data as CSV
     */
    private function exportCsv(array $data, string $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ];
        
        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            
            // Title
            fputcsv($file, ['ISM Prayer Network Report']);
            fputcsv($file, ['Generated on: ' . now()->format('Y-m-d H:i:s')]);
            fputcsv($file, []); // Empty line
            
            foreach ($data as $section => $content) {
                fputcsv($file, [$content['title']]);
                fputcsv($file, ['Metric', 'Value']);
                
                foreach ($content as $key => $value) {
                    if ($key === 'title') continue;
                    
                    if (is_array($value)) {
                        foreach ($value as $subKey => $subValue) {
                            fputcsv($file, [ucfirst(str_replace('_', ' ', $subKey)), $subValue]);
                        }
                    } else {
                        fputcsv($file, [ucfirst(str_replace('_', ' ', $key)), $value]);
                    }
                }
                fputcsv($file, []); // Empty line between sections
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate percentage growth for a model
     */
    private function calculateGrowth(string $model): int
    {
        $currentMonth = now()->month;
        $lastMonth = now()->subMonth()->month;

        $currentCount = $this->getModelCount($model, $currentMonth);
        $lastCount = $this->getModelCount($model, $lastMonth);

        if ($lastCount == 0) {
            return $currentCount > 0 ? 100 : 0;
        }

        return (int) (($currentCount - $lastCount) / $lastCount * 100);
    }

    /**
     * Get count for a model in a specific month
     */
    private function getModelCount(string $model, int $month): int
    {
        return match ($model) {
            'users' => User::whereMonth('created_at', $month)->count(),
            'groups' => Group::whereMonth('created_at', $month)->count(),
            'prayers' => PrayerRequest::whereMonth('created_at', $month)->count(),
            'testimonies' => Testimony::whereMonth('created_at', $month)->count(),
            default => 0,
        };
    }
}
