/**
 * Theme Switcher JavaScript
 * Handles light/dark/system theme switching with localStorage and database sync
 */

(function() {
    'use strict';

    // Theme constants
    const THEME_STORAGE_KEY = 'ism_theme_preference';
    const THEME_DATA_ATTRIBUTE = 'theme';
    const DEFAULT_THEME = 'system';
    const AUTH_CHECK_INTERVAL = 1000; // Check auth status every second

    // Theme configuration
    const THEMES = {
        light: {
            icon: 'sun',
            label: 'Light Mode'
        },
        dark: {
            icon: 'moon',
            label: 'Dark Mode'
        },
        system: {
            icon: 'desktop',
            label: 'System Default'
        }
    };

    // Get current system theme preference
    function getSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // Apply theme to document
    function applyTheme(theme) {
        const root = document.documentElement;
        const actualTheme = theme === 'system' ? getSystemTheme() : theme;

        root.setAttribute(THEME_DATA_ATTRIBUTE, actualTheme);

        // Update data-theme attribute on body
        document.body.setAttribute(THEME_DATA_ATTRIBUTE, actualTheme);

        // Update theme indicator icon
        updateThemeIndicator(actualTheme);
        
        // Apply dark mode to inline styles
        applyDarkModeToInlineStyles(actualTheme);
    }
    
    // Apply dark mode to inline styles (for pages with hardcoded colors)
    function applyDarkModeToInlineStyles(theme) {
        if (theme !== 'dark') {
            // Remove any inline style overrides when switching to light mode
            document.querySelectorAll('[data-theme-override]').forEach(el => {
                el.removeAttribute('data-theme-override');
            });
            return;
        }
        
        // Define color mappings for inline styles
        const colorMappings = {
            // Background colors
            '#f8f9fa': 'var(--bg-secondary)',
            '#ffffff': 'var(--bg-card)',
            '#fff': 'var(--bg-card)',
            'white': 'var(--bg-card)',
            '#f5f5f5': 'var(--bg-secondary)',
            
            // Text colors
            '#6c757d': 'var(--text-secondary)',
            '#333': 'var(--text-primary)',
            '#333333': 'var(--text-primary)',
            '#adb5bd': 'var(--text-muted)',
            '#495057': 'var(--text-secondary)',
            
            // Border colors
            '#e9ecef': 'var(--border-color)',
            '#dee2e6': 'var(--border-color)',
        };
        
        // Apply to all elements with inline styles
        document.querySelectorAll('[style*="background"]').forEach(el => {
            const style = el.getAttribute('style');
            let needsOverride = false;
            
            // Check if element has hardcoded light background
            for (const [lightColor, darkColor] of Object.entries(colorMappings)) {
                if (style.includes('background: ' + lightColor) || 
                    style.includes('background-color: ' + lightColor) ||
                    style.includes('background:' + lightColor) ||
                    style.includes('background-color:' + lightColor)) {
                    needsOverride = true;
                    break;
                }
            }
            
            if (needsOverride) {
                el.setAttribute('data-theme-override', 'true');
            }
        });
        
        // Apply dark mode to all main content areas
        const contentAreas = document.querySelectorAll('main, section, .content, .about-content, .page-content');
        contentAreas.forEach(area => {
            // Check if area needs background override
            const bgColor = window.getComputedStyle(area).backgroundColor;
            
            // Override backgrounds for specific patterns
            if (area.style.background.includes('rgb(248, 249, 250)') || // #f8f9fa
                area.style.background.includes('rgb(255, 255, 255)') || // #ffffff
                area.style.backgroundColor === 'rgb(248, 249, 250)' ||
                area.style.backgroundColor === 'rgb(255, 255, 255)') {
                area.style.backgroundColor = ''; // Reset to CSS variable
                area.style.background = ''; // Reset to CSS variable
            }
        });
        
        // Apply to elements with specific classes from the template
        const themedElements = document.querySelectorAll(
            '.modern-hero, .hero-section, .page-banner, ' +
            '[style*="background: #f8f9fa"], [style*="background:#f8f9fa"], ' +
            '[style*="background: white"], [style*="background: #fff"], ' +
            '.feature-card, .stats-card, .team-card, .modern-card'
        );
        
        themedElements.forEach(el => {
            el.setAttribute('data-theme-override', 'true');
        });
    }

    // Get stored theme preference
    function getStoredTheme() {
        return localStorage.getItem(THEME_STORAGE_KEY) || DEFAULT_THEME;
    }

    // Store theme preference
    function storeTheme(theme) {
        localStorage.setItem(THEME_STORAGE_KEY, theme);
    }

    // Update theme indicator icon
    function updateThemeIndicator(theme) {
        const indicator = document.querySelector('.theme-indicator');
        if (indicator) {
            const iconMap = {
                light: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>',
                dark: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>',
                system: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>'
            };
            indicator.innerHTML = iconMap[theme] || iconMap.system;
        }
    }

    // Save theme to server (for authenticated users)
    function saveThemeToServer(theme) {
        // Always store in localStorage first (works for both guest and authenticated)
        storeTheme(theme);
        
        // Check if user is authenticated using the body data attribute
        const isAuthenticated = document.body.getAttribute('data-user-authenticated') === 'true';
        
        // For guests, localStorage is sufficient
        if (!isAuthenticated) {
            return Promise.resolve();
        }

        // For authenticated users, also save to database (but don't block on failure)
        // If API fails, localStorage already has the theme
        fetch('/api/theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ theme: theme })
        })
        .catch(error => {
            console.warn('Theme save to server failed (using localStorage backup):', error.message);
        });
        
        return Promise.resolve();
    }

    // Initialize theme on page load
    function initTheme() {
        const storedTheme = getStoredTheme();
        applyTheme(storedTheme);

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
            const currentTheme = getStoredTheme();
            if (currentTheme === 'system') {
                applyTheme('system');
            }
        });
    }

    // Toggle theme dropdown
    function toggleThemeDropdown() {
        const dropdown = document.querySelector('.theme-dropdown');
        if (dropdown) {
            dropdown.classList.toggle('show');
        }
    }

    // Close theme dropdown
    function closeThemeDropdown() {
        const dropdown = document.querySelector('.theme-dropdown');
        if (dropdown) {
            dropdown.classList.remove('show');
        }
    }

    // Handle theme selection
    function selectTheme(theme) {
        // Update UI
        const options = document.querySelectorAll('.theme-option');
        options.forEach(option => {
            option.classList.remove('active');
            if (option.dataset.theme === theme) {
                option.classList.add('active');
            }
        });

        // Apply and save theme
        applyTheme(theme);
        saveThemeToServer(theme);
        
        // Also set cookie directly for immediate persistence
        const cookieExpiry = new Date();
        cookieExpiry.setTime(cookieExpiry.getTime() + (365 * 24 * 60 * 60 * 1000)); // 365 days
        document.cookie = THEME_STORAGE_KEY + '=' + theme + ';expires=' + cookieExpiry.toUTCString() + ';path=/;SameSite=Lax';
        console.log('Theme Debug - Cookie set:', theme);

        // Close dropdown
        closeThemeDropdown();

        // Dispatch custom event
        window.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: theme } }));
    }

    // Create theme switcher component HTML
    function createThemeSwitcher() {
        const currentTheme = getStoredTheme();
        // Note: This is just for UI purposes, actual auth check is in saveThemeToServer()
        const isAuthenticated = document.body.getAttribute('data-user-authenticated') === 'true';

        return `
            <div class="theme-switcher">
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme" aria-expanded="false">
                    <span class="theme-indicator">
                        ${currentTheme === 'light' ? '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>' : currentTheme === 'dark' ? '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>'}
                    </span>
                </button>
                <div class="theme-dropdown">
                    <div class="theme-dropdown-header">Theme</div>
                    <button class="theme-option ${currentTheme === 'light' ? 'active' : ''}" data-theme="light">
                        <span class="theme-option-icon theme-icon sun">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                        </span>
                        <span class="theme-option-text">Light</span>
                    </button>
                    <button class="theme-option ${currentTheme === 'dark' ? 'active' : ''}" data-theme="dark">
                        <span class="theme-option-icon theme-icon moon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                        </span>
                        <span class="theme-option-text">Dark</span>
                    </button>
                    <button class="theme-option ${currentTheme === 'system' ? 'active' : ''}" data-theme="system">
                        <span class="theme-option-icon theme-icon system">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        </span>
                        <span class="theme-option-text">System</span>
                    </button>
                </div>
            </div>
        `;
    }

    // Mount theme switcher to a container
    function mountThemeSwitcher(containerSelector) {
        const container = document.querySelector(containerSelector);
        if (container) {
            // Get elements - they may already exist from server-side rendering
            const toggle = document.getElementById('themeToggle');
            const dropdown = document.querySelector('.theme-dropdown');
            const options = document.querySelectorAll('.theme-option');

            if (toggle) {
                // Remove any existing click listeners to avoid duplicates
                const newToggle = toggle.cloneNode(true);
                toggle.parentNode.replaceChild(newToggle, toggle);
                
                newToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleThemeDropdown();
                });
            }

            if (dropdown) {
                const newDropdown = dropdown.cloneNode(true);
                dropdown.parentNode.replaceChild(newDropdown, dropdown);
                
                newDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Re-query options after cloning
            const newOptions = document.querySelectorAll('.theme-option');
            newOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const theme = this.dataset.theme;
                    selectTheme(theme);
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.theme-switcher')) {
                    closeThemeDropdown();
                }
            });

            // Close dropdown on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeThemeDropdown();
                }
            });
            
            console.log('Theme switcher initialized successfully');
        } else {
            console.error('Theme switcher container not found:', containerSelector);
        }
    }

    // Expose API
    window.ThemeSwitcher = {
        init: initTheme,
        switch: selectTheme,
        getCurrent: getStoredTheme,
        mount: mountThemeSwitcher,
        apply: applyTheme
    };

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTheme);
    } else {
        initTheme();
    }

    // Apply theme immediately to prevent flash
    (function applyThemeImmediately() {
        try {
            // First try localStorage
            let storedTheme = localStorage.getItem(THEME_STORAGE_KEY);
            
            // If localStorage fails or returns null, try cookie
            if (!storedTheme) {
                // Try to get from cookie
                const cookies = document.cookie.split(';');
                for (let cookie of cookies) {
                    const [name, value] = cookie.trim().split('=');
                    if (name === THEME_STORAGE_KEY) {
                        storedTheme = value;
                        break;
                    }
                }
            }
            
            // Default to system if still not found
            if (!storedTheme) {
                storedTheme = 'system';
            }
            
            const actualTheme = storedTheme === 'system' ? getSystemTheme() : storedTheme;
            
            console.log('Theme Debug - Stored theme:', storedTheme);
            console.log('Theme Debug - Actual theme:', actualTheme);
            
            document.documentElement.setAttribute(THEME_DATA_ATTRIBUTE, actualTheme);
            document.body.setAttribute(THEME_DATA_ATTRIBUTE, actualTheme);
            
            // Also apply dark mode to inline styles if needed
            if (actualTheme === 'dark') {
                applyDarkModeToInlineStyles(actualTheme);
            }
        } catch (e) {
            console.error('Theme Debug - Error applying theme:', e);
            // Default to system theme on error
            const actualTheme = getSystemTheme();
            document.documentElement.setAttribute(THEME_DATA_ATTRIBUTE, actualTheme);
            document.body.setAttribute(THEME_DATA_ATTRIBUTE, actualTheme);
        }
    })();
    
    // Add debug logging to storeTheme
    const originalStoreTheme = storeTheme;
    storeTheme = function(theme) {
        console.log('Theme Debug - Saving theme:', theme);
        try {
            localStorage.setItem(THEME_STORAGE_KEY, theme);
            const saved = localStorage.getItem(THEME_STORAGE_KEY);
            console.log('Theme Debug - Saved successfully:', saved);
        } catch (e) {
            console.error('Theme Debug - Failed to save:', e);
        }
    };

})();
