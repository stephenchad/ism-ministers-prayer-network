# Multilingual System Implementation Guide

## Overview

This document describes the comprehensive multilingual system implemented for the ISM Ministers Prayer Network application. The system supports content translation across multiple languages including English, Spanish, French, Portuguese, and Arabic.

## Supported Languages

| Code | Name | Native Name | RTL |
|------|------|-------------|-----|
| en | English | English | No |
| es | Spanish | Español | No |
| fr | French | Français | No |
| pt | Portuguese | Português | No |
| ar | Arabic | العربية | Yes |

## Architecture

### 1. Database Schema

The `page_contents` table has been extended with multilingual columns:

```sql
-- Spanish
title_es, subtitle_es, content_es

-- French
title_fr, subtitle_fr, content_fr

-- Portuguese
title_pt, subtitle_pt, content_pt

-- Arabic
title_ar, subtitle_ar, content_ar
```

### 2. Middleware

The `SetLocale` middleware (`app/Http/Middleware/SetLocale.php`) handles:
- Locale detection from session
- Language parameter from URL (`?lang=es`)
- Automatic RTL detection for Arabic

### 3. PageContent Model

Key methods in `app/Models/PageContent.php`:

```php
// Get translated title
$content->translated_title

// Get translated subtitle
$content->translated_subtitle

// Get translated content
$content->translated_content

// Check if translation exists
$content->hasTranslation('es')

// Get available translations
$content->getAvailableTranslations()

// Get content by key with locale support
PageContent::getByKey('home', 'hero_title')
```

### 4. TranslationService

The `TranslationService` class (`app/Services/TranslationService.php`) provides:

```php
// Get current locale
TranslationService::getCurrentLocale()

// Check if RTL
TranslationService::isCurrentLocaleRTL()

// Set locale
TranslationService::setLocale('es')

// Get UI translation
TranslationService::get('group', 'key')

// Get page content
TranslationService::getPageContent('home', 'hero_title')
```

## Usage Examples

### Blade Templates

```blade
{{-- Using translated content --}}
<h1>{{ $pageContent->translated_title }}</h1>
<p>{{ $pageContent->translated_subtitle }}</p>
<div>{{ $pageContent->translated_content }}</div>

{{-- Using blade directives --}}
@lang('nav.home')
@translate('common.submit')

{{-- Page content directive --}}
@pagecontent('home', 'hero_title')

{{-- RTL detection --}}
@isrtl
    <div dir="rtl">Arabic content</div>
@endisrtl
```

### API Endpoints

```javascript
// Get current locale info
GET /api/locale/

// Get available locales
GET /api/locale/locales

// Switch locale
POST /api/locale/switch
Body: { "locale": "es" }

// Get translation
GET /api/locale/translate?group=nav&key=home

// Get page content
GET /api/locale/content?page=home&key=hero_title&locale=es
```

### Controllers

```php
use App\Models\PageContent;

public function show($page)
{
    $contents = PageContent::getForPage($page);
    $hero = PageContent::getHero($page);

    return view('pages.' . $page, compact('contents', 'hero'));
}
```

## Admin Interface

### Page Content Management

1. Navigate to Admin > Page Content
2. Click "Edit" on any content item
3. Use language tabs to edit content in each language
4. Arabic fields automatically have `dir="rtl"` attribute
5. Translation status is shown in the Settings tab

### Translation Management

1. Navigate to Admin > Translations
2. Create/edit translation keys for UI elements
3. Translations are stored in the `language_lines` table
4. Supports all configured languages

## Database Seeders

### Running Seeders

```bash
# Run PageContent translations seeder
php artisan db:seed --class=MultilingualPageContentSeeder

# Run LanguageLines seeder for UI translations
php artisan db:seed --class=LanguageLinesSeeder
```

### Creating Custom Seeders

```php
use App\Models\PageContent;

PageContent::create([
    'page' => 'home',
    'section' => 'hero',
    'key' => 'welcome_title',
    'title' => 'Welcome to ISM',
    'title_es' => 'Bienvenido a ISM',
    'title_fr' => 'Bienvenue à ISM',
    'title_pt' => 'Bem-vindo ao ISM',
    'title_ar' => 'مرحباً بكم في ISM',
]);
```

## RTL Support

Arabic is a right-to-left (RTL) language. The system automatically:

1. Sets `dir="rtl"` on the HTML element when locale is 'ar'
2. Applies RTL-specific CSS styles
3. Handles text alignment and layout

### Custom RTL CSS

```css
[dir="rtl"] {
    text-align: right;
    direction: rtl;
}

[dir="rtl"] .dropdown-menu {
    right: 0;
    left: auto;
}
```

## API Response Examples

### Locale Switch Response

```json
{
    "success": true,
    "message": "Locale changed successfully",
    "locale": "es",
    "locale_name": "Español",
    "is_rtl": false
}
```

### Page Content Response

```json
{
    "page": "home",
    "key": "hero_title",
    "locale": "es",
    "content": {
        "title": "Bienvenido a ISM",
        "subtitle": "Orando juntos",
        "body": "Únete a nuestra comunidad...",
        "image": "/images/hero.jpg"
    }
}
```

## Extending the System

### Adding a New Language

1. Add migration columns for the new language
2. Update `PageContent::LANGUAGES` constant
3. Update `SetLocale` middleware
4. Add locale to `TranslationService::LOCALES`
5. Add flag and name to language switcher component
6. Update seeders with translations

### Example: Adding German

```php
// PageContent.php
public const LANGUAGES = [
    'en' => 'English',
    'es' => 'Español',
    'fr' => 'Français',
    'pt' => 'Português',
    'ar' => 'العربية',
    'de' => 'Deutsch',  // Add German
];
```

## Best Practices

1. **Content Organization**: Group content by page and section
2. **Translation Keys**: Use descriptive keys (e.g., `hero_title`, `welcome_text`)
3. **Fallback**: Always provide English content as fallback
4. **RTL Testing**: Test Arabic content in RTL mode
5. **SEO**: Use `lang` attribute on HTML element

## Troubleshooting

### Content Not Showing

1. Check if content is active (`is_active = true`)
2. Verify page and key match exactly
3. Check if translation exists for current locale
4. Clear cache: `php artisan cache:clear`

### Language Not Switching

1. Verify session is working
2. Check middleware is applied
3. Clear config: `php artisan config:clear`
4. Check route parameters

### RTL Layout Issues

1. Verify `dir="rtl"` is set on HTML
2. Check CSS for RTL-specific styles
3. Test dropdown menus and navigation
