# OAuth Setup Guide - Google & Facebook Login

## 🔐 GOOGLE OAUTH SETUP

### Step 1: Create Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable **Google+ API**
4. Go to **Credentials** → **Create Credentials** → **OAuth 2.0 Client ID**
5. Configure OAuth consent screen:
   - App name: ISM Ministers Prayer Network
   - User support email: your-email@domain.com
   - Developer contact: your-email@domain.com
6. Create OAuth Client ID:
   - Application type: **Web application**
   - Name: ISM Prayer Network
   - Authorized redirect URIs:
     - `http://localhost/account/login/google/callback` (for local)
     - `https://yourdomain.com/account/login/google/callback` (for production)

### Step 2: Add Credentials to .env

```env
GOOGLE_CLIENT_ID=your-client-id-here.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://localhost/account/login/google/callback
```

---

## 📘 FACEBOOK OAUTH SETUP

### Step 1: Create Facebook App

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Click **My Apps** → **Create App**
3. Select **Consumer** as app type
4. Fill in app details:
   - App name: ISM Ministers Prayer Network
   - Contact email: your-email@domain.com
5. In dashboard, go to **Settings** → **Basic**
6. Add **Facebook Login** product
7. Go to **Facebook Login** → **Settings**
8. Add Valid OAuth Redirect URIs:
   - `http://localhost/account/login/facebook/callback` (for local)
   - `https://yourdomain.com/account/login/facebook/callback` (for production)

### Step 2: Add Credentials to .env

```env
FACEBOOK_CLIENT_ID=your-app-id-here
FACEBOOK_CLIENT_SECRET=your-app-secret-here
FACEBOOK_REDIRECT_URI=http://localhost/account/login/facebook/callback
```

---

## ✅ TESTING LOCALLY

### For Local Testing (localhost):

1. Update your `.env`:
```env
APP_URL=http://localhost
GOOGLE_REDIRECT_URI=http://localhost/account/login/google/callback
FACEBOOK_REDIRECT_URI=http://localhost/account/login/facebook/callback
```

2. Clear config cache:
```bash
php artisan config:clear
```

3. Test the login buttons on: `http://localhost/account/login`

---

## 🚀 PRODUCTION SETUP

### For Production:

1. Update redirect URIs in Google Cloud Console and Facebook App Settings
2. Update your production `.env`:
```env
APP_URL=https://yourdomain.com
GOOGLE_REDIRECT_URI=https://yourdomain.com/account/login/google/callback
FACEBOOK_REDIRECT_URI=https://yourdomain.com/account/login/facebook/callback
```

3. Clear config cache:
```bash
php artisan config:clear
```

---

## 🔧 CURRENT CONFIGURATION

Your application is already configured to handle OAuth. The routes are:

- **Google Login**: `/account/login/google`
- **Google Callback**: `/account/login/google/callback`
- **Facebook Login**: `/account/login/facebook`
- **Facebook Callback**: `/account/login/facebook/callback`

---

## 📝 WHAT HAPPENS DURING OAUTH LOGIN

1. User clicks "Continue with Google/Facebook"
2. User is redirected to Google/Facebook for authentication
3. User authorizes the app
4. Google/Facebook redirects back to your callback URL
5. Your app receives user data (name, email, profile picture)
6. App checks if user exists:
   - If exists: Links social account to existing user
   - If new: Creates new user account
7. User is logged in automatically

---

## ⚠️ IMPORTANT NOTES

### For Local Development:
- Use `http://localhost` (not `http://127.0.0.1`)
- Facebook requires HTTPS for production
- Google allows HTTP for localhost only

### For Production:
- **MUST use HTTPS**
- Update redirect URIs in both Google and Facebook
- Verify domain ownership in Google Console
- Add privacy policy URL in Facebook App

---

## 🐛 TROUBLESHOOTING

### Error: "redirect_uri_mismatch"
- Check that redirect URI in .env matches exactly what's in Google/Facebook console
- Include protocol (http:// or https://)
- No trailing slashes

### Error: "App Not Setup"
- Facebook app must be in "Live" mode for production
- Add test users in Facebook App dashboard for development

### Error: "Invalid Client"
- Check CLIENT_ID and CLIENT_SECRET are correct
- Clear config cache: `php artisan config:clear`

---

## 📧 REQUIRED SCOPES

### Google:
- email
- profile
- openid

### Facebook:
- email
- public_profile

These are already configured in your application.

---

## ✨ FEATURES INCLUDED

✅ Auto-create user account on first login  
✅ Link social account to existing email  
✅ Store provider info (google/facebook)  
✅ Generate referral code for new users  
✅ Notify admins of social logins  
✅ Secure password generation for social users  
✅ Profile picture from social account (optional)

---

## 🎯 NEXT STEPS

1. Create Google OAuth credentials
2. Create Facebook App
3. Add credentials to `.env`
4. Run `php artisan config:clear`
5. Test login on `/account/login`

Your OAuth integration is ready to use once you add the credentials!
