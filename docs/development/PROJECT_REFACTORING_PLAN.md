# Project Refactoring Plan

## Overview
This document outlines the necessary refactoring steps to improve the Laravel project structure, fix misplaced files, and enhance maintainability.

## Priority 1: Critical File Organization Issues

### 1.1 Create Missing Directories
```bash
mkdir -p app/Policies
mkdir -p app/Http/Requests/Group
mkdir -p docs/fixes
mkdir -p docs/commerce
mkdir -p docs/reports
```

### 1.2 Move Misplaced Controllers
**Current Location → Target Location**
- `routes/AccountController.php` → DELETE (duplicate exists in `app/Http/Controllers/AccountController.php`)

### 1.3 Move Policies to Correct Location
**Actions:**
1. Keep `app/Http/Controllers/GroupPolicy.php` → Move to `app/Policies/GroupPolicy.php`
2. Delete `routes/GroupPolicy.php` (duplicate)
3. Register policy in `app/Providers/AuthServiceProvider.php`:
```php
protected $policies = [
    \App\Models\Group::class => \App\Policies\GroupPolicy::class,
];
```

### 1.4 Move Request Classes
**Current Location → Target Location**
- `routes/DestroyGroupResourceRequest.php` → `app/Http/Requests/Group/DestroyGroupResourceRequest.php`
- `routes/StoreGroupResourceRequest.php` → `app/Http/Requests/Group/StoreGroupResourceRequest.php`
- `routes/UpdateGroupResourceRequest.php` → `app/Http/Requests/Group/UpdateGroupResourceRequest.php`
- `app/Http/Controllers/DestroyGroupEventRequest.php` → `app/Http/Requests/Group/DestroyGroupEventRequest.php`
- `app/Http/Controllers/StoreGroupEventRequest.php` → `app/Http/Requests/Group/StoreGroupEventRequest.php`
- `app/Http/Controllers/UpdateGroupEventRequest.php` → `app/Http/Requests/Group/UpdateGroupEventRequest.php`
- `app/Http/Controllers/DestroyGroupRuleRequest.php` → `app/Http/Requests/Group/DestroyGroupRuleRequest.php`
- `app/Http/Controllers/UpdateGroupRuleRequest.php` → `app/Http/Requests/Group/UpdateGroupRuleRequest.php`

### 1.5 Move Misplaced Models
**Actions:**
- `app/Http/Controllers/admin/GroupRule.php` → Already exists in `app/Models/GroupRule.php` (DELETE duplicate)

### 1.6 Move Misplaced Migrations
**Actions:**
- `app/Http/Controllers/admin/2025_09_15_100000_create_group_rules_table.php` → DELETE (already exists in `database/migrations/`)

### 1.7 Move Misplaced Views
**Actions:**
- `routes/edit.blade.php` → Determine context and move to appropriate `resources/views/` subdirectory
- `app/Http/Controllers/admin/notifications-dropdown.blade.php` → Already exists in `resources/views/components/notifications-dropdown.blade.php` (DELETE duplicate)
- `app/Notifications/app.blade.php` → Move to `resources/views/layouts/app.blade.php` or DELETE if duplicate

### 1.8 Move Misplaced Assets
**Actions:**
- `app/Http/Controllers/magnific-popup.css` → Already exists in `public/assets/css/magnific-popup.css` (DELETE duplicate)

### 1.9 Move Misplaced Notification Classes
**Actions:**
- `app/Http/Controllers/admin/NewGroupCreated.php` → Already in `app/Notifications/NewGroupCreated.php` (DELETE duplicate)
- `app/Http/Controllers/admin/NewPrayerResourceAdded.php` → Already in `app/Notifications/NewPrayerResourceAdded.php` (DELETE duplicate)
- `app/Http/Controllers/admin/NewRadioAdded.php` → Already in `app/Notifications/NewRadioAdded.php` (DELETE duplicate)
- `app/Http/Controllers/admin/NewStreamAdded.php` → Already in `app/Notifications/NewStreamAdded.php` (DELETE duplicate)

### 1.10 Move View Composers
**Actions:**
- `app/Http/Controllers/admin/NotificationComposer.php` → Already in `app/Http/View/Composers/NotificationComposer.php` (DELETE duplicate)

## Priority 2: Documentation Organization

### 2.1 Organize Documentation Files
**Move to docs/ directory:**
```
docs/
├── fixes/
│   ├── ADMIN_EDIT_FUNCTIONALITY.md
│   ├── CITIES_DROPDOWN_FIX.md
│   ├── CITIES_FIX_COMPLETE.md
│   ├── CITIES_LOADING_DEBUG.md
│   ├── COMPLETE_FIX_SUMMARY.md
│   ├── DISPLAY_FIX_COMPLETE.md
│   ├── GROUP_CREATION_FIX.md
│   ├── PRAYER_REQUEST_EDIT_FIX.md
│   └── SECURITY_FIXES.md
├── commerce/
│   ├── COMMERCE_IMPLEMENTATION_SUMMARY.md
│   ├── COMMERCE_INDEX.md
│   ├── COMMERCE_INTEGRATION_GUIDE.md
│   ├── COMMERCE_README.md
│   └── IMPLEMENTATION_COMPLETE.md
├── reports/
│   ├── layman_report.md
│   ├── linkedin_post.md
│   ├── technical_report.md
│   └── user_guide.md
└── deployment/
    ├── DEPLOYMENT_INSTRUCTIONS.md
    └── QUICK_START.md
```

**Keep in root:**
- README.md
- TODO.md

## Priority 3: Code Quality Improvements

### 3.1 Remove Duplicate View/Composers Directory
**Issue:** `app/Http/View/Composers` appears twice in file tree
**Action:** Verify and remove duplicate if exists

### 3.2 Clean Up Unused Files
**Review and remove if not needed:**
- `cookies.txt` (root directory)
- `test_notifications.php` (root directory)
- `test_users.csv` (root directory)
- `.DS_Store` files (macOS system files)

### 3.3 Add Missing .gitignore Entries
```gitignore
# macOS
.DS_Store

# Test files
test_*.php
test_*.csv
cookies.txt

# Documentation (if you want to keep them local)
docs/fixes/
```

## Priority 4: Testing Infrastructure

### 4.1 Add Test Structure
```bash
mkdir -p tests/Unit/Models
mkdir -p tests/Unit/Services
mkdir -p tests/Feature/Admin
mkdir -p tests/Feature/Groups
mkdir -p tests/Feature/Prayer
```

### 4.2 Create Basic Test Files
**Recommended tests:**
- `tests/Unit/Models/GroupTest.php`
- `tests/Unit/Models/UserTest.php`
- `tests/Unit/Services/CommerceApiClientTest.php`
- `tests/Feature/Groups/GroupCreationTest.php`
- `tests/Feature/Groups/GroupMembershipTest.php`
- `tests/Feature/Admin/UserManagementTest.php`

## Priority 5: Configuration & Environment

### 5.1 Review Environment Variables
**Add to .env.example if missing:**
```env
# Application
APP_TIMEZONE=UTC

# Queue Configuration
QUEUE_CONNECTION=database

# File Upload Limits
MAX_UPLOAD_SIZE=10240

# Pagination
ITEMS_PER_PAGE=15
```

### 5.2 Create Config Files for Custom Settings
**Create `config/app_settings.php`:**
```php
<?php

return [
    'max_group_members' => env('MAX_GROUP_MEMBERS', 100),
    'max_upload_size' => env('MAX_UPLOAD_SIZE', 10240),
    'items_per_page' => env('ITEMS_PER_PAGE', 15),
    'supported_languages' => ['en', 'es', 'fr', 'pt'],
];
```

## Priority 6: Service Layer Organization

### 6.1 Expand Services Directory
**Current:** Only `CommerceApiClient.php`
**Recommended structure:**
```
app/Services/
├── Commerce/
│   ├── CommerceApiClient.php
│   └── OrderService.php
├── Group/
│   ├── GroupService.php
│   └── MembershipService.php
├── Prayer/
│   ├── PrayerRequestService.php
│   └── PrayerPointService.php
└── Notification/
    └── NotificationService.php
```

## Priority 7: Route Organization

### 7.1 Split Routes into Separate Files
**Current:** All routes in `web.php` (very long file)
**Recommended:**
```
routes/
├── web.php (main public routes)
├── admin.php (admin routes)
├── account.php (user account routes)
├── groups.php (group-related routes)
├── commerce.php (commerce routes)
└── api.php (API routes)
```

**Update `RouteServiceProvider.php` to load these files**

## Implementation Order

### Phase 1: Critical Fixes (Do First)
1. Move/delete misplaced files (Priority 1)
2. Register GroupPolicy properly
3. Update namespaces in affected files

### Phase 2: Organization (Do Second)
1. Organize documentation (Priority 2)
2. Clean up unused files (Priority 3.2)
3. Update .gitignore (Priority 3.3)

### Phase 3: Enhancements (Do Third)
1. Split routes (Priority 7)
2. Create service layer (Priority 6)
3. Add configuration files (Priority 5)

### Phase 4: Testing (Do Last)
1. Set up test structure (Priority 4)
2. Write critical tests
3. Set up CI/CD pipeline

## Automated Refactoring Script

I can create a bash script to automate Phase 1 and Phase 2 if you'd like. This would:
- Create necessary directories
- Move files to correct locations
- Delete duplicates
- Update namespaces
- Organize documentation

Would you like me to create this script?

## Notes

- **Backup First:** Create a git commit or backup before running any refactoring
- **Test After Each Phase:** Run `php artisan test` and manually test critical features
- **Update Imports:** After moving files, search for old namespaces and update them
- **Clear Cache:** Run `php artisan optimize:clear` after moving files

## Estimated Time

- Phase 1: 2-3 hours
- Phase 2: 1 hour
- Phase 3: 4-6 hours
- Phase 4: 8-12 hours (depending on test coverage goals)

**Total: 15-22 hours**
