# TODO: Add Language Selection for User Submissions of Prayer Requests and Prayer Points

## Steps to Complete

1. **Create Migration for Prayer Requests**: Add 'language' string field (nullable, default 'en') to prayer_requests table.
2. **Create Migration for Prayer Points**: Add 'language' string field (nullable, default 'en') to prayer_points table.
3. **Update PrayerRequest Model**: Add 'language' to $fillable.
4. **Update PrayerPoint Model**: Add 'language' to $fillable.
5. **Update PrayersController**: Add validation for 'language' in store method, store it.
6. **Update PrayerPointsController**: Add validation for 'language' in store method, store it, and map content to appropriate multilingual fields (e.g., for 'es', use title_es/content_es).
7. **Update prayers.blade.php**: Add language select dropdown to the submission form.
8. **Update prayer-points.blade.php**: Add language select dropdown to the submission form, update display logic to show content in the submission language.
9. **Run Migrations**: Execute php artisan migrate.
10. **Test Submissions**: Submit prayer requests and points in different languages, verify storage and display.

## Progress

- [x] Step 1: Create Migration for Prayer Requests
- [x] Step 2: Create Migration for Prayer Points
- [x] Step 3: Update PrayerRequest Model
- [x] Step 4: Update PrayerPoint Model
- [x] Step 5: Update PrayersController
- [x] Step 6: Update PrayerPointsController
- [x] Step 7: Update prayers.blade.php
- [x] Step 8: Update prayer-points.blade.php
- [x] Step 9: Run Migrations
- [ ] Step 10: Test Submissions
