<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Message Details - ISM Prayer Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }
        .main-content {
            margin-left: 280px;
            padding: 30px;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 18px 25px;
            border-radius: 12px;
            margin: 5px 15px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        .content-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
            backdrop-filter: blur(10px);
        }
        .topbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            backdrop-filter: blur(20px);
            box-shadow: 0 15px 50px rgba(102, 126, 234, 0.3);
            padding: 30px;
            margin-bottom: 40px;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
        }
        .topbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        .topbar-content {
            position: relative;
            z-index: 1;
        }
        .detail-label {
            font-weight: 600;
            color: #333;
        }
        .detail-value {
            font-size: 1rem;
            color: #555;
        }
        .badge {
            border-radius: 20px;
            font-weight: 500;
        }
        .failed-recipient {
            background: #f8d7da;
            color: #842029;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4 text-center" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="mb-3">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fas fa-praying-hands text-primary" style="font-size: 24px;"></i>
                </div>
            </div>
            <h5 class="text-white mb-1 fw-bold">ISM Admin</h5>
            <small class="text-light opacity-75">Prayer Network</small>
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a class="nav-link" href="{{ route('admin.users') }}">
                <i class="fas fa-users me-2"></i> Users
            </a>
            <a class="nav-link" href="{{ route('admin.referrals') }}">
                <i class="fas fa-share-alt me-2"></i> Referrals
            </a>
            <a class="nav-link active" href="{{ route('admin.bulk-messages.index') }}">
                <i class="fas fa-envelope me-2"></i> Bulk Messages
            </a>
            <a class="nav-link" href="{{ route('admin.groups') }}">
                <i class="fas fa-users-cog me-2"></i> Groups
            </a>
            <a class="nav-link" href="{{ route('admin.programs') }}">
                <i class="fas fa-calendar-alt me-2"></i> Programs
            </a>
            <a class="nav-link" href="{{ route('admin.news.index') }}">
                <i class="fas fa-newspaper me-2"></i> News & Events
            </a>
            <hr class="border-secondary mx-3">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-globe me-2"></i> View Website
            </a>
            <a class="nav-link" href="{{ route('admin.logout') }}">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-content">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="topbar-icon me-4">
                            <i class="fas fa-envelope-open-text text-white" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 text-white fw-bold">Bulk Message Details</h3>
                            <p class="mb-0 text-white opacity-75">Details of the bulk message sent</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.bulk-messages.index') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3); border-radius: 25px; padding: 12px 25px; font-weight: 600; backdrop-filter: blur(10px); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-arrow-left me-2"></i>Back to Messages
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Details -->
        <div class="content-card p-4">
            <div class="mb-4">
                <span class="detail-label">ID:</span>
                <span class="detail-value">{{ $bulkMessage->id }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">Type:</span>
                <span class="detail-value">
                    <span class="badge bg-{{ $bulkMessage->type === 'email' ? 'primary' : 'success' }}">
                        {{ ucfirst($bulkMessage->type) }}
                    </span>
                </span>
            </div>
            <div class="mb-4">
                <span class="detail-label">Subject:</span>
                <span class="detail-value">{{ $bulkMessage->subject ?? 'N/A' }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">Message:</span>
                <p class="detail-value">{{ $bulkMessage->message }}</p>
            </div>
            <div class="mb-4">
                <span class="detail-label">Total Recipients:</span>
                <span class="detail-value">{{ $bulkMessage->total_recipients }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">Sent Count:</span>
                <span class="detail-value">{{ $bulkMessage->sent_count }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">Failed Count:</span>
                <span class="detail-value">{{ $bulkMessage->failed_count }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">Sent At:</span>
                <span class="detail-value">{{ $bulkMessage->sent_at ? $bulkMessage->sent_at->format('M d, Y H:i') : 'Pending' }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">Sender:</span>
                <span class="detail-value">{{ $bulkMessage->sender->name ?? 'Unknown' }}</span>
            </div>

            @if($bulkMessage->failed_count > 0 && !empty($bulkMessage->failed_recipients))
                <div class="mb-4">
                    <span class="detail-label">Failed Recipients:</span>
                    @foreach($bulkMessage->failed_recipients as $failed)
                        <div class="failed-recipient">
                            <strong>User ID:</strong> {{ $failed['user_id'] ?? 'N/A' }}<br>
                            <strong>Email:</strong> {{ $failed['email'] ?? 'N/A' }}<br>
                            <strong>Mobile:</strong> {{ $failed['mobile'] ?? 'N/A' }}<br>
                            <strong>Error:</strong> {{ $failed['error'] ?? 'N/A' }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>
