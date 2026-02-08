<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PrayersController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GroupSettingsController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RadioController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PrayerRoomController;
use App\Http\Controllers\PrayerPointsController;
use App\Http\Controllers\PrayerResourceController as FrontendPrayerResourceController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GroupController as AdminGroupController;
use App\Http\Controllers\Admin\CoordinatorController as AdminCoordinatorController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PrayerRequestController;
use App\Http\Controllers\Admin\PrayerResourceController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\RadioController as AdminRadioController;
use App\Http\Controllers\Admin\StreamController as AdminStreamController;
use App\Http\Controllers\Admin\TestimonyController as AdminTestimonyController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\admin\VideoResourceController;
use App\Http\Controllers\admin\WorshipMusicController;
use App\Http\Controllers\admin\BulkMessageController;
use App\Http\Controllers\admin\BulkUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('index');

// Static Pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// News
Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::get('/{id}', [NewsController::class, 'show'])->name('news.show');
});

// Programs
Route::prefix('programs')->group(function () {
    Route::get('/', [ProgramController::class, 'index'])->name('programs.index');
    Route::get('/{id}', [ProgramController::class, 'show'])->name('programs.show');
});

// Radio & Streams
Route::prefix('radio')->group(function () {
    Route::get('/', [RadioController::class, 'index'])->name('radio.index');
    Route::get('/{id}', [RadioController::class, 'show'])->name('radio.show');
});

Route::prefix('streams')->group(function () {
    Route::get('/', [StreamController::class, 'index'])->name('streams.index');
    Route::get('/{id}', [StreamController::class, 'show'])->name('streams.show');
});

// Books
Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
});

// Prayer Room
Route::prefix('prayer-room')->group(function () {
    Route::get('/', [PrayerRoomController::class, 'index'])->name('prayer-room.index');
    Route::post('/join', [PrayerRoomController::class, 'join'])->name('prayer-room.join');
});

// Prayer Points
Route::prefix('prayer-points')->group(function () {
    Route::get('/', [PrayerPointsController::class, 'index'])->name('prayer-points.index');
    Route::get('/{id}', [PrayerPointsController::class, 'show'])->name('prayer-points.show');
});

// Prayer Resources
Route::prefix('prayer-resources')->group(function () {
    Route::get('/', [FrontendPrayerResourceController::class, 'index'])->name('prayer-resources.index');
    Route::get('/{id}', [FrontendPrayerResourceController::class, 'show'])->name('prayer-resources.show');
});

// Testimonies
Route::prefix('testimonies')->group(function () {
    Route::get('/', [TestimonyController::class, 'index'])->name('testimonies.index');
    Route::post('/', [TestimonyController::class, 'store'])->name('testimonies.store');
    Route::get('/{id}', [TestimonyController::class, 'show'])->name('testimonies.show');
});

// Prayers
Route::prefix('prayers')->group(function () {
    Route::get('/', [PrayersController::class, 'index'])->name('prayers.index');
    Route::post('/', [PrayersController::class, 'store'])->name('prayers.store');
    Route::get('/{id}', [PrayersController::class, 'show'])->name('prayers.show');
});

// Events
Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/{id}', [EventController::class, 'show'])->name('events.show');
});

// Newsletter
Route::prefix('newsletter')->group(function () {
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::get('/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
});

// Groups
Route::prefix('groups')->group(function () {
    Route::get('/', [GroupsController::class, 'index'])->name('groups.index');
    Route::get('/{id}', [GroupsController::class, 'show'])->name('groups.show');
});

// Discussions
Route::prefix('discussions')->group(function () {
    Route::get('/', [DiscussionController::class, 'index'])->name('discussions.index');
    Route::post('/', [DiscussionController::class, 'store'])->name('discussions.store');
    Route::get('/{id}', [DiscussionController::class, 'show'])->name('discussions.show');
    Route::post('/{id}/reply', [DiscussionController::class, 'reply'])->name('discussions.reply');
});

// Coordinator
Route::get('/coordinator', [CoordinatorController::class, 'index'])->name('coordinator.index');

// Downloads
Route::prefix('downloads')->group(function () {
    Route::get('/{type}/{id}', [DownloadController::class, 'index'])->name('downloads.index');
});

// Notifications
Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Group Settings
Route::prefix('groups/{group}/settings')->group(function () {
    Route::get('/', [GroupSettingsController::class, 'index'])->name('groups.settings.index');
    Route::put('/update', [GroupSettingsController::class, 'update'])->name('groups.settings.update');
});

// Authentication Routes
require __DIR__.'/auth.php';

// Account Routes (under auth middleware)
Route::middleware(['auth'])->prefix('account')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('account.index');
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::get('/notifications', [AccountController::class, 'notifications'])->name('account.notifications');
    Route::get('/my-groups', [AccountController::class, 'myGroups'])->name('account.myGroups');
    Route::post('/group/join', [AccountController::class, 'joinGroup'])->name('account.joinGroup');
    Route::post('/group/leave', [AccountController::class, 'leaveGroup'])->name('account.leaveGroup');
    Route::post('/group/transfer-coordinator', [AccountController::class, 'transferCoordinator'])->name('account.transferCoordinator');
    Route::get('/prayers', [AccountController::class, 'prayers'])->name('account.prayers');
    Route::get('/prayers/create', [AccountController::class, 'createPrayer'])->name('account.prayers.create');
    Route::post('/prayers', [AccountController::class, 'storePrayer'])->name('account.prayers.store');
    Route::get('/testimonies', [AccountController::class, 'testimonies'])->name('account.testimonies');
    Route::get('/testimonies/create', [AccountController::class, 'createTestimony'])->name('account.testimonies.create');
    Route::post('/testimonies', [AccountController::class, 'storeTestimony'])->name('account.testimonies.store');
    Route::get('/discussions', [AccountController::class, 'discussions'])->name('account.discussions');
    Route::get('/discussion/create', [AccountController::class, 'createDiscussion'])->name('account.discussions.create');
    Route::post('/discussion/store', [AccountController::class, 'storeDiscussion'])->name('account.discussions.store');
    Route::post('/book/order', [AccountController::class, 'orderBook'])->name('account.book.order');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['admin', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/export', [UserController::class, 'export'])->name('users.export');
        Route::post('/import', [UserController::class, 'import'])->name('users.import');
        Route::get('/birthdays', [UserController::class, 'birthdays'])->name('users.birthdays');
    });

    // Groups
    Route::prefix('groups')->group(function () {
        Route::get('/', [AdminGroupController::class, 'index'])->name('groups.index');
        Route::get('/create', [AdminGroupController::class, 'create'])->name('groups.create');
        Route::get('/get-cities', [AdminGroupController::class, 'getCities'])->name('groups.getCities');
        Route::post('/', [AdminGroupController::class, 'store'])->name('groups.store');
        Route::get('/edit/{id}', [AdminGroupController::class, 'edit'])->name('groups.edit');
        Route::put('/{id}', [AdminGroupController::class, 'update'])->name('groups.update');
        Route::get('/{id}', [AdminGroupController::class, 'show'])->name('groups.show');
        Route::post('/promote-leader', [AdminGroupController::class, 'promoteLeader'])->name('groups.promoteLeader');
        Route::post('/demote-leader', [AdminGroupController::class, 'demoteLeader'])->name('groups.demoteLeader');
        Route::post('/remove-member', [AdminGroupController::class, 'removeMember'])->name('groups.removeMember');
        Route::post('/discussion/destroy', [AdminGroupController::class, 'destroyDiscussion'])->name('groups.discussion.destroy');
        Route::post('/event/destroy', [AdminGroupController::class, 'destroyEvent'])->name('groups.event.destroy');
        Route::post('/event/store', [AdminGroupController::class, 'storeEvent'])->name('groups.event.store');
        Route::post('/event/update', [AdminGroupController::class, 'updateEvent'])->name('groups.event.update');
        Route::post('/photo/store', [AdminGroupController::class, 'storePhoto'])->name('groups.photo.store');
        Route::post('/photo/destroy', [AdminGroupController::class, 'destroyPhoto'])->name('groups.photo.destroy');
        Route::post('/resource/store', [AdminGroupController::class, 'storeResource'])->name('groups.resource.store');
        Route::post('/resource/destroy', [AdminGroupController::class, 'destroyResource'])->name('groups.resource.destroy');
        Route::delete('/{group}', [AdminGroupController::class, 'destroy'])->name('groups.destroy');
        Route::post('/rule/store', [AdminGroupController::class, 'storeRule'])->name('groups.rule.store');
        Route::post('/rule/update', [AdminGroupController::class, 'updateRule'])->name('groups.rule.update');
        Route::post('/rule/destroy', [AdminGroupController::class, 'destroyRule'])->name('groups.rule.destroy');
        Route::post('/promote-to-coordinator', [AdminGroupController::class, 'promoteToCoordinator'])->name('groups.promoteToCoordinator');
        Route::post('/transfer-coordinator', [AdminGroupController::class, 'transferCoordinator'])->name('groups.transferCoordinator');
    });

    // Coordinators
    Route::prefix('coordinators')->group(function () {
        Route::get('/', [AdminCoordinatorController::class, 'index'])->name('coordinators.index');
        Route::get('/create', [AdminCoordinatorController::class, 'create'])->name('coordinators.create');
        Route::post('/', [AdminCoordinatorController::class, 'store'])->name('coordinators.store');
        Route::get('/edit/{id}', [AdminCoordinatorController::class, 'edit'])->name('coordinators.edit');
        Route::put('/{id}', [AdminCoordinatorController::class, 'update'])->name('coordinators.update');
        Route::delete('/{id}', [AdminCoordinatorController::class, 'destroy'])->name('coordinators.destroy');
        Route::get('/export', [AdminCoordinatorController::class, 'export'])->name('coordinators.export');
    });

    // News
    Route::prefix('news')->group(function () {
        Route::get('/', [AdminNewsController::class, 'index'])->name('news.index');
        Route::get('/create', [AdminNewsController::class, 'create'])->name('news.create');
        Route::post('/', [AdminNewsController::class, 'store'])->name('news.store');
        Route::get('/edit/{id}', [AdminNewsController::class, 'edit'])->name('news.edit');
        Route::put('/{id}', [AdminNewsController::class, 'update'])->name('news.update');
        Route::delete('/{id}', [AdminNewsController::class, 'destroy'])->name('news.destroy');
    });

    // Programs
    Route::prefix('programs')->group(function () {
        Route::get('/', [AdminProgramController::class, 'index'])->name('programs.index');
        Route::get('/create', [AdminProgramController::class, 'create'])->name('programs.create');
        Route::post('/', [AdminProgramController::class, 'store'])->name('programs.store');
        Route::get('/edit/{id}', [AdminProgramController::class, 'edit'])->name('programs.edit');
        Route::put('/{id}', [AdminProgramController::class, 'update'])->name('programs.update');
        Route::delete('/{id}', [AdminProgramController::class, 'destroy'])->name('programs.destroy');
    });

    // Radio
    Route::prefix('radio')->group(function () {
        Route::get('/', [AdminRadioController::class, 'index'])->name('radio.index');
        Route::get('/create', [AdminRadioController::class, 'create'])->name('radio.create');
        Route::post('/', [AdminRadioController::class, 'store'])->name('radio.store');
        Route::get('/edit/{id}', [AdminRadioController::class, 'edit'])->name('radio.edit');
        Route::put('/{id}', [AdminRadioController::class, 'update'])->name('radio.update');
        Route::delete('/{id}', [AdminRadioController::class, 'destroy'])->name('radio.destroy');
    });

    // Streams
    Route::prefix('streams')->group(function () {
        Route::get('/', [AdminStreamController::class, 'index'])->name('streams.index');
        Route::get('/create', [AdminStreamController::class, 'create'])->name('streams.create');
        Route::post('/', [AdminStreamController::class, 'store'])->name('streams.store');
        Route::get('/edit/{id}', [AdminStreamController::class, 'edit'])->name('streams.edit');
        Route::put('/{id}', [AdminStreamController::class, 'update'])->name('streams.update');
        Route::delete('/{id}', [AdminStreamController::class, 'destroy'])->name('streams.destroy');
    });

    // Testimonies
    Route::prefix('testimonies')->group(function () {
        Route::get('/', [AdminTestimonyController::class, 'index'])->name('testimonies.index');
        Route::get('/pending', [AdminTestimonyController::class, 'pending'])->name('testimonies.pending');
        Route::post('/{id}/approve', [AdminTestimonyController::class, 'approve'])->name('testimonies.approve');
        Route::delete('/{id}', [AdminTestimonyController::class, 'destroy'])->name('testimonies.destroy');
    });

    // Prayer Requests
    Route::prefix('prayer-requests')->group(function () {
        Route::get('/', [PrayerRequestController::class, 'index'])->name('prayer-requests.index');
        Route::get('/pending', [PrayerRequestController::class, 'pending'])->name('prayer-requests.pending');
        Route::post('/{id}/answer', [PrayerRequestController::class, 'answer'])->name('prayer-requests.answer');
        Route::delete('/{id}', [PrayerRequestController::class, 'destroy'])->name('prayer-requests.destroy');
    });

    // Prayer Resources
    Route::prefix('prayer-resources')->group(function () {
        Route::get('/', [PrayerResourceController::class, 'index'])->name('prayer-resources.index');
        Route::get('/create', [PrayerResourceController::class, 'create'])->name('prayer-resources.create');
        Route::post('/', [PrayerResourceController::class, 'store'])->name('prayer-resources.store');
        Route::get('/edit/{id}', [PrayerResourceController::class, 'edit'])->name('prayer-resources.edit');
        Route::put('/{id}', [PrayerResourceController::class, 'update'])->name('prayer-resources.update');
        Route::delete('/{id}', [PrayerResourceController::class, 'destroy'])->name('prayer-resources.destroy');
    });

    // Video Resources
    Route::prefix('video-resources')->group(function () {
        Route::get('/', [VideoResourceController::class, 'index'])->name('video-resources.index');
        Route::get('/create', [VideoResourceController::class, 'create'])->name('video-resources.create');
        Route::post('/', [VideoResourceController::class, 'store'])->name('video-resources.store');
        Route::get('/edit/{id}', [VideoResourceController::class, 'edit'])->name('video-resources.edit');
        Route::put('/{id}', [VideoResourceController::class, 'update'])->name('video-resources.update');
        Route::delete('/{id}', [VideoResourceController::class, 'destroy'])->name('video-resources.destroy');
    });

    // Worship Music
    Route::prefix('worship-music')->group(function () {
        Route::get('/', [WorshipMusicController::class, 'index'])->name('worship-music.index');
        Route::get('/create', [WorshipMusicController::class, 'create'])->name('worship-music.create');
        Route::post('/', [WorshipMusicController::class, 'store'])->name('worship-music.store');
        Route::get('/edit/{id}', [WorshipMusicController::class, 'edit'])->name('worship-music.edit');
        Route::put('/{id}', [WorshipMusicController::class, 'update'])->name('worship-music.update');
        Route::delete('/{id}', [WorshipMusicController::class, 'destroy'])->name('worship-music.destroy');
    });

    // Page Content
    Route::prefix('page-content')->group(function () {
        Route::get('/', [PageContentController::class, 'index'])->name('page-content.index');
        Route::get('/create', [PageContentController::class, 'create'])->name('page-content.create');
        Route::post('/', [PageContentController::class, 'store'])->name('page-content.store');
        Route::get('/edit/{id}', [PageContentController::class, 'edit'])->name('page-content.edit');
        Route::put('/{id}', [PageContentController::class, 'update'])->name('page-content.update');
        Route::delete('/{id}', [PageContentController::class, 'destroy'])->name('page-content.destroy');
    });

    // Translations
    Route::prefix('translations')->group(function () {
        Route::get('/', [TranslationController::class, 'index'])->name('translations.index');
        Route::get('/create', [TranslationController::class, 'create'])->name('translations.create');
        Route::post('/', [TranslationController::class, 'store'])->name('translations.store');
        Route::get('/edit/{id}', [TranslationController::class, 'edit'])->name('translations.edit');
        Route::put('/{id}', [TranslationController::class, 'update'])->name('translations.update');
        Route::delete('/{id}', [TranslationController::class, 'destroy'])->name('translations.destroy');
    });

    // Bulk Messages
    Route::prefix('bulk-messages')->group(function () {
        Route::get('/', [BulkMessageController::class, 'index'])->name('bulk-messages.index');
        Route::get('/create', [BulkMessageController::class, 'create'])->name('bulk-messages.create');
        Route::post('/', [BulkMessageController::class, 'store'])->name('bulk-messages.store');
        Route::get('/{id}', [BulkMessageController::class, 'show'])->name('bulk-messages.show');
        Route::delete('/{id}', [BulkMessageController::class, 'destroy'])->name('bulk-messages.destroy');
    });

    // Bulk Uploads
    Route::prefix('bulk-uploads')->group(function () {
        Route::get('/', [BulkUploadController::class, 'index'])->name('bulk-uploads.index');
        Route::get('/create', [BulkUploadController::class, 'create'])->name('bulk-uploads.create');
        Route::post('/', [BulkUploadController::class, 'store'])->name('bulk-uploads.store');
        Route::delete('/{id}', [BulkUploadController::class, 'destroy'])->name('bulk-uploads.destroy');
    });

    // Admin Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [AdminNotificationController::class, 'index'])->name('notifications.index');
        Route::get('/create', [AdminNotificationController::class, 'create'])->name('notifications.create');
        Route::post('/', [AdminNotificationController::class, 'store'])->name('notifications.store');
        Route::delete('/{id}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    // Profile
    Route::get('/profile', [AdminAuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [AdminAuthController::class, 'changePassword'])->name('change-password');
    Route::put('/change-password', [AdminAuthController::class, 'updatePassword'])->name('change-password.update');
});
