{{--
    Language Switcher Component

    Usage:
    @include('components.language-switcher')
    or
    <x-language-switcher />
--}}

@php
    $locales = [
        'en' => ['flag' => '🇺🇸', 'name' => 'English'],
        'es' => ['flag' => '🇪🇸', 'name' => 'Español'],
        'fr' => ['flag' => '🇫🇷', 'name' => 'Français'],
        'pt' => ['flag' => '🇧🇷', 'name' => 'Português'],
        'ar' => ['flag' => '🇸🇦', 'name' => 'العربية'],
    ];

    $currentLocale = app()->getLocale();
    $currentLocaleData = $locales[$currentLocale] ?? $locales['en'];
@endphp

<!-- DEBUG: Current Locale: {{ $currentLocale }} -->

<style>
/* Language Switcher - Always Visible Version */
.language-switcher-container {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-left: 10px;
}

.language-switcher-list {
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.language-switcher-list li {
    display: inline-block;
}

.language-switcher-list .lang-btn {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid transparent;
    background: transparent;
    color: inherit;
    cursor: pointer;
    text-decoration: none;
    font-size: 13px;
    transition: all 0.2s ease;
}

.language-switcher-list .lang-btn:hover {
    background: rgba(0, 0, 0, 0.08);
    border-color: rgba(0, 0, 0, 0.1);
}

.language-switcher-list .lang-btn.active {
    background: var(--bs-primary, #0d6efd);
    color: #fff;
    border-color: var(--bs-primary, #0d6efd);
}

.language-switcher-list .lang-flag {
    font-size: 16px;
}

.language-switcher-list .lang-name {
    font-weight: 500;
}

/* Hide the dropdown version */
.language-switcher.dropdown {
    display: none !important;
}

/* RTL Support */
[dir="rtl"] .language-switcher-container {
    margin-left: 0;
    margin-right: 10px;
}

[dir="rtl"] .language-switcher-list .lang-btn {
    flex-direction: row-reverse;
}

/* Dark mode support */
[data-theme="dark"] .language-switcher-list .lang-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
}

/* Responsive - hide on small screens */
@media (max-width: 1200px) {
    .language-switcher-list .lang-name {
        display: none;
    }
    
    .language-switcher-list .lang-btn {
        padding: 6px 8px;
    }
}

@media (max-width: 991px) {
    .language-switcher-container {
        margin: 10px 0;
    }
    
    .language-switcher-list {
        flex-wrap: wrap;
        gap: 8px;
    }
}
</style>

<div class="language-switcher-container">
    <ul class="language-switcher-list">
        @foreach($locales as $locale => $data)
            <li>
                <a href="?lang={{ $locale }}" 
                   class="lang-btn {{ $locale === $currentLocale ? 'active' : '' }}"
                   data-locale="{{ $locale }}"
                   title="{{ $data['name'] }}">
                    <span class="lang-flag">{{ $data['flag'] }}</span>
                    <span class="lang-name">{{ $data['name'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
