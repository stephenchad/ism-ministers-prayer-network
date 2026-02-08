<!DOCTYPE html>
{{-- Use the application's locale for the lang attribute --}}
@php
$locale = app()->getLocale();
$isRTL = in_array($locale, ['ar']);

// Get theme preference - check session first, then cookie set by PHP API, then cookie set by JavaScript, default to 'system'
$theme = session('theme', null);
if (empty($theme)) {
    // First check cookie set by PHP API
    $theme = \Illuminate\Support\Facades\Cookie::get('ism_theme_preference', null);
    // If not found, check cookie set by JavaScript (localStorage fallback)
    if (empty($theme) && isset($_COOKIE['ism_theme_preference'])) {
        $theme = $_COOKIE['ism_theme_preference'];
    }
}
// If still empty or not valid, default to system
if (!in_array($theme, ['light', 'dark', 'system'])) {
    $theme = 'system';
}
@endphp
<html lang="{{ str_replace('_', '-', $locale) }}" @if($isRTL) dir="rtl" @endif data-theme="{{ $theme }}">


    <head>
        <!--================= Meta tag =================-->
        <meta charset="utf-8">
        {{-- Use a dynamic title, yielding from child pages --}}
        <title>@yield('title', 'Home') | ISM MINISTERS PRAYER NETWORK</title>
      
        {{-- The meta description should be dynamic per page for better SEO --}}
        <meta name="description" content="@yield('description', 'Default description of the website.')">
        
        {{-- CRITICAL FIX: The csrf_token() function does not take arguments. --}}
        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        <!--================= Responsive Tag =================-->
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--================= Favicon =================-->
        <link rel="apple-touch-icon" href="{{ asset('assets/images/fav.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/fav.png') }}">        
          
        {{-- RECOMMENDATION: Consolidate assets using Vite or Mix for production --}}
        <!--================= Bootstrap V5 css =================-->
        @if(app()->getLocale() === 'ar')
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
        @else
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
        @endif
        <!--================= Menus css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/menus.css') }}">               
        <!--================= Animate css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">
        <!--================= Owl Carousel css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.css') }}">
        <!--================= Elegant icon css  =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/elegant-icon.css') }}">
        <!--================= Magnific Popup css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/magnific-popup.css') }}">
        <!--================= Animations css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animations.css') }}">  
        <!--================= Main stylesheet (must load before theme.css) =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">
        <!--================= Custom Spacing css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-spacing.css') }}">
        <!--================= Responsive css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
        <!--================= Enhanced Responsive css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/enhanced-responsive.css') }}">
        <!--================= Custom css =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
        <!--================= Theme CSS =================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.css') }}?v={{ time() }}">
        
        <!-- Force dark mode styles - loads last for highest specificity -->
        <style id="dark-mode-override">
            html[data-theme="dark"] html,
            html[data-theme="dark"] body,
            html[data-theme="dark"] #react-header,
            html[data-theme="dark"] main,
            html[data-theme="dark"] footer,
            html[data-theme="dark"] .react-inner-menus,
            html[data-theme="dark"] .topbar-area {
                background-color: #0f172a !important;
                color: #f1f5f9 !important;
            }
            
            html[data-theme="dark"] .topbar-area {
                background-color: #1e293b !important;
                border-bottom: 1px solid #334155 !important;
            }
            
            html[data-theme="dark"] .react-header {
                background-color: #1e293b !important;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
            }
            
            html[data-theme="dark"] .react-menus > li > a {
                color: #f1f5f9 !important;
            }
            
            html[data-theme="dark"] .bg-white,
            html[data-theme="dark"] .bg-light,
            html[data-theme="dark"] .card {
                background-color: #1e293b !important;
                color: #f1f5f9 !important;
            }
            
            html[data-theme="dark"] .section-bg,
            html[data-theme="dark"] .bg-secondary {
                background-color: #0f172a !important;
            }
            
            html[data-theme="dark"] .text-dark {
                color: #f1f5f9 !important;
            }
            
            html[data-theme="dark"] .border {
                border-color: #334155 !important;
            }
            
            html[data-theme="dark"] .react-menus ul {
                background-color: #1e293b !important;
                border: 1px solid #334155 !important;
            }
            
            html[data-theme="dark"] .react-menus ul li a {
                color: #f1f5f9 !important;
            }
        </style>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        @if(app()->getLocale() === 'ar')
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" dir="rtl">
            <style>
                /* RTL-specific font settings */
                html[dir="rtl"] body {
                    font-family: 'Tahoma', 'Arial', sans-serif;
                }
                /* Fix RTL alignment issues */
                html[dir="rtl"] .container {
                    text-align: right;
                }
                html[dir="rtl"] .row {
                    direction: rtl;
                }
                html[dir="rtl"] .row > * {
                    direction: ltr;
                }
                /* RTL menu fixes */
                html[dir="rtl"] .react-menus {
                    text-align: right;
                }
                html[dir="rtl"] .react-menus ul ul {
                    right: 100%;
                    left: auto;
                }
                /* Slider direction fix for RTL */
                html[dir="rtl"] .owl-carousel,
                html[dir="rtl"] .owl-carousel .owl-stage-outer,
                html[dir="rtl"] .owl-carousel .owl-stage,
                html[dir="rtl"] .owl-carousel .owl-item {
                    direction: ltr !important;
                }
                html[dir="rtl"] .owl-carousel .slider-content {
                    direction: rtl !important;
                    text-align: right !important;
                }
            </style>
        @endif
        <script src="https://cdnjs.cloudflare.com/ajax/libs/hls.js/1.4.10/hls.min.js"></script>

        {{-- Critical CSS to prevent navbar flickering and theme flash --}}
        <style>
            /* Preloader should not block clicks */
            #react__preloader {
                pointer-events: none !important;
                z-index: 9999;
            }
            #react__preloader > * {
                pointer-events: none !important;
            }
            
            /* Ensure all links and buttons are clickable */
            a, .react-btn-border, .btn, button {
                pointer-events: auto !important;
                cursor: pointer !important;
            }
            
            /* Prevent navbar items from scattering before CSS loads */
            .react-inner-menus {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
            }
            .react-menus {
                display: flex !important;
                align-items: center !important;
                margin: 0 !important;
                padding: 0 !important;
                list-style: none !important;
                flex-wrap: nowrap !important;
            }
            @media (max-width: 991px) {
                .react-inner-menus {
                    flex-wrap: wrap !important;
                }
                .react-menus {
                    display: none !important;
                    flex-direction: column !important;
                    align-items: flex-start !important;
                    width: 100% !important;
                    inset-inline-start: 0 !important;
                    background: #fff !important;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
                    z-index: 9999 !important;
                }
                .react-menus.menu-active {
                    display: flex !important;
                }
                .react-menus > li {
                    margin-inline-end: 0 !important;
                    width: 100% !important;
                    border-bottom: 1px solid #f5f3f3 !important;
                }
                .react-menus > li > a {
                    padding: 14px 24px !important;
                    color: #0a0a0a !important;
                }
            }
            .react-menus > li {
                margin-inline-end: 30px !important;
                position: relative !important;
                white-space: nowrap !important;
            }
            .react-menus > li:last-child {
                margin-inline-end: 0 !important;
            }
            .react-menus > li:first-child {
                margin-inline-start: 0 !important;
            }
            
            /* RTL menu dropdown adjustments */
            html[dir="rtl"] .react-menus ul {
                inset-inline-end: 0 !important;
                inset-inline-start: auto !important;
            }
            
            /* RTL search bar and login adjustments */
            html[dir="rtl"] .searchbar-part {
                flex-direction: row-reverse;
            }
            
            html[dir="rtl"] .language-switcher {
                margin-inline-start: 10px;
            }
            
            html[dir="rtl"] .react-login {
                margin-inline-start: 15px;
            }
            
            html[dir="rtl"] .logo {
                margin-inline-end: 30px !important;
            }
            
            /* RTL fixes for searchbar and language switcher */
            html[dir="rtl"] .searchbar-part {
                flex-direction: row-reverse;
            }
            
            html[dir="rtl"] .language-switcher {
                margin-left: 0;
                margin-inline-start: 10px;
            }
            
            html[dir="rtl"] .react-login {
                margin-inline-start: 15px;
                margin-inline-end: 0;
            }
            .react-menus ul {
                position: absolute !important;
                top: 100% !important;
                inset-inline-start: 0 !important;
                z-index: 1000 !important;
                background: var(--bg-card) !important;
                min-width: 250px !important;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
                border-radius: 8px !important;
                padding: 10px 0 !important;
                display: none !important;
            }
            @media (max-width: 991px) {
                .react-menus ul {
                    position: static !important;
                    width: 100% !important;
                    box-shadow: none !important;
                    padding: 0 !important;
                }
            }
            .react-menus li:hover > ul {
                display: block !important;
            }
            .searchbar-part {
                display: flex !important;
                align-items: center !important;
                gap: 20px !important;
            }
            @media (max-width: 991px) {
                .searchbar-part {
                    display: none !important;
                }
            }
            /* Hide preloader after page loads */
            body.loaded #react__preloader {
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }
            /* Prevent theme flash on page load */
            [data-theme="dark"] .react-menus ul {
                background: var(--bg-card) !important;
            }
            /* Language Switcher Styles */
            .language-switcher {
                margin-left: 10px;
            }
            .language-switcher .dropdown-toggle {
                padding: 6px 12px;
                border-radius: 20px;
                border: 1px solid var(--border-color);
                background: var(--bg-secondary);
                color: var(--text-primary);
                font-size: 14px;
            }
            .language-switcher .dropdown-toggle:hover {
                background: var(--bg-primary);
                border-color: var(--bg-primary);
                color: white;
            }
            .language-switcher .dropdown-menu {
                min-width: 160px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
            .language-switcher .dropdown-item {
                padding: 8px 16px;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .language-switcher .dropdown-item:hover {
                background: var(--bg-secondary);
            }
            .language-switcher .dropdown-item.active {
                background: var(--bg-primary);
                color: white;
            }
            .language-switcher .language-flag {
                font-size: 1.2em;
            }
        </style>

        @yield('customCSS')
    </head>


    <body data-user-authenticated="{{ Auth::check() ? 'true' : 'false' }}">
        <!--================= Preloader Section Start Here =================-->        
        <div id="react__preloader">
            <div id="react__circle_loader"></div>
            <div class="react__loader_logo"><img src="{{ asset('assets/images/preload.png') }}" alt="Preload"></div>
        </div>        
        <!--================= Preloader Section End Here =================-->

        {{-- RECOMMENDATION: Extract header to a partial like @include('front.layouts.partials.header') --}}
        <!--================= Header Section Start Here =================-->
        <header id="react-header" class="react-header">
            <div class="topbar-area style1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="topbar-contact">
                               <ul>       
                                    {{-- RECOMMENDATION: Make contact details configurable --}}
                                   <li>
                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                       <a href="tel:(+1)3344999999"> (+1) 3344 999 999</a>
                                   </li>
                                   <li>
                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                       <a href="mailto:info.prayernetwork@christembassy-ism.org">info.prayernetwork@christembassy-ism.org</a>
                                   </li>
                               </ul>
                            </div>
                        </div>
                        <div class="col-lg-5 text-right">
                            <div class="toolbar-sl-share">
                                <ul class="social-links">
                                    {{-- ACCESSIBILITY FIX: Added aria-label for screen readers --}}
                                    <li><a href="https://facebook.com/ismministers" target="_blank" rel="noopener" aria-label="Follow us on Facebook"><span aria-hidden="true" class="social_facebook"></span></a></li>
                                    <li><a href="https://twitter.com/ismministers" target="_blank" rel="noopener" aria-label="Follow us on Twitter"><span aria-hidden="true" class="social_twitter"></span></a></li>
                                    <li><a href="https://linkedin.com/company/ismministers" target="_blank" rel="noopener" aria-label="Connect on LinkedIn"><span aria-hidden="true" class="social_linkedin"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-part">
                <div class="container">
                    <!--================= Menu Start Here =================-->
                    <div class="react-main-menu">
                        <nav>
                            <!--================= Menu Toggle btn =================-->
                            <div class="menu-toggle" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <div class="logo"><a href="{{ route('home') }}" class="logo-text"> <img src="{{ asset('assets/images/ism-logo-light.png') }}" alt="ISM Ministers Prayer Network Logo" style="max-height: 50px;"> </a></div>
                                <button type="button" id="menu-btn" aria-label="Toggle navigation menu" aria-expanded="false" style="display: flex !important;">
                                    <span class="icon-bar" aria-hidden="true"></span>
                                    <span class="icon-bar" aria-hidden="true"></span>
                                    <span class="icon-bar" aria-hidden="true"></span>
                                </button>
                            </div>
                            <!--================= Menu Structure =================-->
                            <div class="react-inner-menus" style="justify-content: space-between;">
                                <div style="display: flex; align-items: center;">
                                    <div class="logo" style="margin-inline-end: 30px;"><a href="{{ route('home') }}" class="logo-text"> <img src="{{ asset('assets/images/ism-logo-light.png') }}" alt="logo" style="max-height: 50px;"> </a></div>
                                    <ul id="backmenu" class="react-menus home react-sub-shadow">
                                    <li> <a href="{{ route('home') }}">Home</a></li>
                                    <li> <a href="{{ route('about') }}">About</a>
                                        <ul>
                                            <li><a href="{{ route('about') }}">About</a></li>
                                            <li><a href="#">About ISM</a></li>
                                        </ul>
                                    </li>
                                    <li> <a href="{{ route('prayers') }}">Prayers</a>
                                        <ul>
                                            <li><a href="{{ route('prayers') }}">Prayers</a></li>
                                            <li><a href="{{ route('prayer-points.index') }}">Prayer Points</a></li>
                                            <li><a href="{{ route('prayer-room') }}">Prayer Room</a></li>
                                        </ul>
                                    </li>
                                    <li> <a href="{{ route('groups.index') }}">Groups</a></li>
                                    <li> <a href="{{ route('testimonies') }}">Testimonies</a></li>
                                    @auth
                                    <li> <a href="{{ route('stream') }}">Stream</a></li>
                                    <li> <a href="{{ route('radio') }}">Radio</a></li>
                                    @endauth
                                    <li> <a href="{{ route('contact') }}">Contact</a></li>
                                    </ul>
                                </div>
                                
                                <div class="searchbar-part">
                                    <form class="search-form" method="GET" action="{{ route('search') }}">
                                        <div style="position: relative; display: flex; align-items: center; background: var(--bg-secondary); border-radius: 25px; padding: 8px 15px; backdrop-filter: blur(10px); border: 1px solid var(--border-color);">
                                            <input type="text" name="q" id="keyword" placeholder="Search..." value="{{ is_string(request('q')) ? request('q') : '' }}" style="background: transparent; border: none; outline: none; color: var(--text-primary); padding: 5px 10px; width: 200px; font-size: 14px;" required aria-label="Search site">
                                            <button type="submit" style="background: none; border: none; padding: 0; margin-left: 5px; cursor: pointer; display: flex; align-items: center;" aria-label="Submit search">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--text-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                            </button>
                                        </div>
                                    </form>

                                    {{-- Theme Switcher Container --}}
                                    <div id="theme-switcher-container">
                                        <div class="theme-switcher">
                                            <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme" aria-expanded="false" type="button">
                                                <span class="theme-indicator">
                                                    @if($theme === 'light')
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                                                    @elseif($theme === 'dark')
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                                    @endif
                                                </span>
                                            </button>
                                            <div class="theme-dropdown">
                                                <div class="theme-dropdown-header">Theme</div>
                                                <button class="theme-option {{ $theme === 'light' ? 'active' : '' }}" data-theme="light" type="button">
                                                    <span class="theme-option-icon theme-icon sun">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                                                    </span>
                                                    <span class="theme-option-text">Light</span>
                                                </button>
                                                <button class="theme-option {{ $theme === 'dark' ? 'active' : '' }}" data-theme="dark" type="button">
                                                    <span class="theme-option-icon theme-icon moon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                                                    </span>
                                                    <span class="theme-option-text">Dark</span>
                                                </button>
                                                <button class="theme-option {{ $theme === 'system' ? 'active' : '' }}" data-theme="system" type="button">
                                                    <span class="theme-option-icon theme-icon system">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                                    </span>
                                                    <span class="theme-option-text">System</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Simple fallback theme links (always visible) --}}
                                    <noscript>
                                        <style>
                                            .theme-dropdown { display: block !important; opacity: 1 !important; visibility: visible !important; position: static !important; }
                                            .theme-toggle { display: none !important; }
                                        </style>
                                        <div style="display: flex; gap: 10px; margin-inline-start: 10px;">
                                            <a href="?theme=light" style="padding: 5px 10px; border: 1px solid var(--border-color); border-radius: 5px; {{ $theme === 'light' ? 'background: var(--primary-color); color: white;' : '' }}">Light</a>
                                            <a href="?theme=dark" style="padding: 5px 10px; border: 1px solid var(--border-color); border-radius: 5px; {{ $theme === 'dark' ? 'background: var(--primary-color); color: white;' : '' }}">Dark</a>
                                            <a href="?theme=system" style="padding: 5px 10px; border: 1px solid var(--border-color); border-radius: 5px; {{ $theme === 'system' ? 'background: var(--primary-color); color: white;' : '' }}">System</a>
                                        </div>
                                    </noscript>

                                    {{-- Language Switcher --}}
                                    @include('components.language-switcher')

                                    <div class="react-login" style="white-space: nowrap;">
                                        @if(!Auth::check())
                                            <a href="{{ route('account.login') }}" aria-label="Log in to your account">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in" aria-hidden="true"><path d="M15 3h4a2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><path d="M10 17l5-5 5 5"></path><path d="M15 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path></svg>Login</a>
                                        @else
                                            <a href="{{ route('account.logout') }}" aria-label="Log out of your account">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>Logout</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <!--=================  Menu End Here  =================-->
                </div>
            </div>
        </header>
        <!--================= Header Section End Here =================-->

        <main style="min-height: calc(100vh - 200px);">
            @yield('main')
        </main>

        {{-- RECOMMENDATION: Extract footer to a partial like @include('front.layouts.partials.footer') --}}
        <style>
        .modern-footer {
            background: var(--footer-bg);
            color: var(--footer-text);
            padding: 60px 0 20px;
        }
        .footer-card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }
        .footer-title {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .footer-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            padding: 8px 0;
            transition: all 0.3s ease;
        }
        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }
        html[dir="rtl"] .footer-link:hover {
            transform: translateX(-5px);
        }
        html[dir="rtl"] .footer-link:hover {
            transform: translateX(-5px);
        }
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: rgba(255,255,255,0.9);
        }
        .contact-item i {
            margin-inline-end: 15px;
            width: 20px;
        }
        .newsletter-form {
            display: flex;
            margin-top: 15px;
        }
        .newsletter-form input {
            flex: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 25px 0 0 25px;
            outline: none;
            background: rgba(255,255,255,0.1);
            color: #ffffff;
        }
        .newsletter-form input::placeholder {
            color: rgba(255,255,255,0.6);
        }
        .newsletter-form button {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 20px;
            border-radius: 0 25px 25px 0;
            cursor: pointer;
        }
        html[dir="rtl"] .newsletter-form input {
            border-radius: 0 25px 25px 0;
        }
        html[dir="rtl"] .newsletter-form button {
            border-radius: 25px 0 0 25px;
        }
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .social-icon:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }
        .copyright {
            background: rgba(0,0,0,0.2);
            padding: 20px 0;
            text-align: center;
            color: rgba(255,255,255,0.8);
        }
        </style>
        
        <footer class="modern-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="footer-card">
                            <img src="{{ asset('assets/images/ism-logo-light.png') }}" alt="ISM Prayer Network" style="max-width: 200px; margin-bottom: 20px;">
                            <p style="color: rgba(255,255,255,0.9); line-height: 1.6; margin-bottom: 20px;">We connect ministers worldwide in united prayer, building faith and transforming lives through the power of the Holy Spirit.</p>
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <a href="tel:+(402)76244183" style="color: rgba(255,255,255,0.9); text-decoration: none;">+(402) 762 441 83</a>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:info.prayernetwork@christembassy-ism.org" style="color: rgba(255,255,255,0.9); text-decoration: none;">info.prayernetwork@christembassy-ism.org</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="footer-card">
                            <h4 class="footer-title">Quick Links</h4>
                            <a href="{{ route('about') }}" class="footer-link">About</a>
                            <a href="{{ route('prayer-points.index') }}" class="footer-link">Prayer Points</a>
                            <a href="{{ route('testimonies') }}" class="footer-link">Testimonies</a>
                            <a href="{{ route('contact') }}" class="footer-link">Contact</a>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="footer-card">
                            <h4 class="footer-title">Ministry</h4>
                            <a href="{{ route('groups.index') }}" class="footer-link">Groups</a>
                            <a href="{{ route('prayer.resources') }}" class="footer-link">Prayer Resources</a>
                            <a href="{{ route('programs.index') }}" class="footer-link">Programs</a>
                            <a href="{{ route('news.index') }}" class="footer-link">News</a>
                            @auth
                            <a href="{{ route('stream') }}" class="footer-link">Stream</a>
                            <a href="{{ route('radio') }}" class="footer-link">Radio</a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer-card">
                            <h4 class="footer-title">Stay Connected</h4>
                            <p style="color: rgba(255,255,255,0.9); margin-bottom: 15px;">Subscribe to our newsletter to receive updates, resources, and upcoming events.</p>
                            <form class="newsletter-form" id="newsletter-form">
                                <input type="email" name="email" placeholder="Enter your email" required>
                                <button type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                            <div id="newsletter-message" style="margin-top: 10px; display: none;"></div>
                            <div class="social-icons">
                                <a href="#" class="social-icon" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="social-icon" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="social-icon" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="social-icon" aria-label="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <div class="container">
                    <p style="margin: 0;">© <script>document.write(new Date().getFullYear())</script> ISM Ministers Prayer Network. All rights reserved.</p>
                </div>
            </div>
        </footer>
        <!--================= Footer Section End Here =================-->
        
        <!--================= Scroll to Top Start =================-->
        <div id="backscrollUp" class="home">
            <span aria-hidden="true" class="arrow_carrot-up"></span>
        </div> 
        <!--================= Scroll to Top End =================-->

        <!--================= Jquery latest version =================-->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
        <!--================= Modernizr js =================-->
        <script src="{{ asset('assets/js/modernizr-2.8.3.min.js') }}"></script>
        <!--================= Popper.js (required for Bootstrap dropdowns) =================-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <!--================= Bootstrap js =================-->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!--================= Owl Carousel js =================-->
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <!--================= Magnific Popup =================-->
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <!--================= Counter up js =================-->
        <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
        <!--================= Wow js =================-->
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>                
        <!--================= menus js =================-->
        <script src="{{ asset('assets/js/menus.js') }}"></script>
        <!--================= Plugins js =================-->
        <script src="{{ asset('assets/js/plugins.js') }}"></script>       
        <!--================= Main js =================-->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <!--================= Loading States js =================-->
        <script src="{{ asset('assets/js/loading-states.js') }}"></script>
        <!--================= Theme Switcher js =================-->
        <script src="{{ asset('assets/js/theme-switcher.js') }}"></script>
        
        <script>
            // Hide preloader and prevent navbar flickering
            window.addEventListener('load', function() {
                document.body.classList.add('loaded');
                setTimeout(function() {
                    const preloader = document.getElementById('react__preloader');
                    if (preloader) {
                        preloader.style.display = 'none';
                    }
                }, 300);
            });

            // Mobile Menu Toggle Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const menuBtn = document.getElementById('menu-btn');
                const backmenu = document.getElementById('backmenu');
                
                if (menuBtn && backmenu) {
                    menuBtn.addEventListener('click', function() {
                        backmenu.classList.toggle('menu-active');
                        const expanded = backmenu.classList.contains('menu-active');
                        menuBtn.setAttribute('aria-expanded', expanded);
                        
                        // Toggle icon bars for visual feedback
                        const iconBars = menuBtn.querySelectorAll('.icon-bar');
                        if (expanded) {
                            iconBars[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                            iconBars[1].style.opacity = '0';
                            iconBars[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
                        } else {
                            iconBars[0].style.transform = '';
                            iconBars[1].style.opacity = '1';
                            iconBars[2].style.transform = '';
                        }
                    });
                    
                    // Handle submenu toggles on mobile
                    const hasSubMenus = backmenu.querySelectorAll('.has-sub');
                    hasSubMenus.forEach(function(item) {
                        const arrow = document.createElement('div');
                        arrow.className = 'arrow';
                        arrow.setAttribute('aria-label', 'Toggle submenu');
                        
                        arrow.addEventListener('click', function(e) {
                            e.preventDefault();
                            item.classList.toggle('menu-active');
                        });
                        
                        item.appendChild(arrow);
                    });
                }
                
                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (backmenu && menuBtn && !backmenu.contains(e.target) && !menuBtn.contains(e.target)) {
                        backmenu.classList.remove('menu-active');
                        menuBtn.setAttribute('aria-expanded', 'false');
                        
                        const iconBars = menuBtn.querySelectorAll('.icon-bar');
                        iconBars[0].style.transform = '';
                        iconBars[1].style.opacity = '1';
                        iconBars[2].style.transform = '';
                    }
                });
            });

            // Setup CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Newsletter subscription
            $('#newsletter-form').on('submit', function(e) {
                e.preventDefault();
                const email = $(this).find('input[name="email"]').val();
                const messageDiv = $('#newsletter-message');
                
                $.ajax({
                    url: '{{ route("newsletter.subscribe") }}',
                    method: 'POST',
                    data: { email: email },
                    success: function(response) {
                        messageDiv.html('<p style="color: var(--success-color); font-size: 14px;">' + response.message + '</p>').show();
                        $('#newsletter-form')[0].reset();
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON?.errors?.email?.[0] || 'An error occurred. Please try again.';
                        messageDiv.html('<p style="color: var(--danger-color); font-size: 14px;">' + error + '</p>').show();
                    }
                });
            });

            // Mount theme switcher when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof ThemeSwitcher !== 'undefined') {
                    ThemeSwitcher.mount('#theme-switcher-container');
                } else {
                    console.error('ThemeSwitcher not loaded');
                }
            });
            
            // Debug: Log theme changes
            window.addEventListener('themeChanged', function(e) {
                console.log('Theme changed to:', e.detail.theme);
                document.documentElement.setAttribute('data-theme', e.detail.theme);
            });
            
            // Debug: Check theme status
            window.addEventListener('load', function() {
                setTimeout(function() {
                    var currentTheme = document.documentElement.getAttribute('data-theme');
                    console.log('Current theme on load:', currentTheme);
                    console.log('Theme switcher mounted:', typeof ThemeSwitcher !== 'undefined');
                }, 100);
            });
        </script>
        {{-- Yield for page-specific JavaScript --}}
        @yield('customJS')
    </body>
</html>
