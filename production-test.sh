#!/bin/bash

# Production Readiness Test Script
# Run this before deploying to production

echo "=========================================="
echo "PRODUCTION READINESS TEST"
echo "=========================================="
echo ""

ERRORS=0
WARNINGS=0

# Color codes
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
NC='\033[0m' # No Color

# Test 1: Check if .env exists
echo "1. Checking environment file..."
if [ -f .env ]; then
    echo -e "${GREEN}✓${NC} .env file exists"
else
    echo -e "${RED}✗${NC} .env file missing"
    ((ERRORS++))
fi

# Test 2: Check APP_ENV
echo "2. Checking APP_ENV..."
APP_ENV=$(grep "^APP_ENV=" .env | cut -d '=' -f2)
if [ "$APP_ENV" = "production" ]; then
    echo -e "${GREEN}✓${NC} APP_ENV is set to production"
else
    echo -e "${YELLOW}⚠${NC} APP_ENV is not set to production (current: $APP_ENV)"
    ((WARNINGS++))
fi

# Test 3: Check APP_DEBUG
echo "3. Checking APP_DEBUG..."
APP_DEBUG=$(grep "^APP_DEBUG=" .env | cut -d '=' -f2)
if [ "$APP_DEBUG" = "false" ]; then
    echo -e "${GREEN}✓${NC} APP_DEBUG is disabled"
else
    echo -e "${RED}✗${NC} APP_DEBUG should be false in production"
    ((ERRORS++))
fi

# Test 4: Check APP_KEY
echo "4. Checking APP_KEY..."
APP_KEY=$(grep "^APP_KEY=" .env | cut -d '=' -f2)
if [ -n "$APP_KEY" ] && [ "$APP_KEY" != "base64:GENERATE_NEW_KEY_WITH_php_artisan_key:generate" ]; then
    echo -e "${GREEN}✓${NC} APP_KEY is set"
else
    echo -e "${RED}✗${NC} APP_KEY is not set or invalid"
    ((ERRORS++))
fi

# Test 5: Check storage permissions
echo "5. Checking storage permissions..."
if [ -w storage ] && [ -w bootstrap/cache ]; then
    echo -e "${GREEN}✓${NC} Storage directories are writable"
else
    echo -e "${RED}✗${NC} Storage directories are not writable"
    ((ERRORS++))
fi

# Test 6: Check if composer dependencies are installed
echo "6. Checking composer dependencies..."
if [ -d vendor ]; then
    echo -e "${GREEN}✓${NC} Vendor directory exists"
else
    echo -e "${RED}✗${NC} Run 'composer install --optimize-autoloader --no-dev'"
    ((ERRORS++))
fi

# Test 7: Check database connection
echo "7. Testing database connection..."
php artisan migrate:status > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓${NC} Database connection successful"
else
    echo -e "${RED}✗${NC} Database connection failed"
    ((ERRORS++))
fi

# Test 8: Check for debug statements
echo "8. Checking for debug statements..."
DEBUG_COUNT=$(grep -r "dd(" app/ resources/views/ --include="*.php" --include="*.blade.php" 2>/dev/null | grep -v "classList.add" | wc -l)
if [ $DEBUG_COUNT -eq 0 ]; then
    echo -e "${GREEN}✓${NC} No debug statements found"
else
    echo -e "${YELLOW}⚠${NC} Found $DEBUG_COUNT potential debug statements"
    ((WARNINGS++))
fi

# Test 9: Check LOG_LEVEL
echo "9. Checking LOG_LEVEL..."
LOG_LEVEL=$(grep "^LOG_LEVEL=" .env | cut -d '=' -f2)
if [ "$LOG_LEVEL" = "error" ] || [ "$LOG_LEVEL" = "warning" ]; then
    echo -e "${GREEN}✓${NC} LOG_LEVEL is appropriate for production"
else
    echo -e "${YELLOW}⚠${NC} LOG_LEVEL should be 'error' or 'warning' in production"
    ((WARNINGS++))
fi

# Test 10: Check SESSION_SECURE_COOKIE
echo "10. Checking SESSION_SECURE_COOKIE..."
SESSION_SECURE=$(grep "^SESSION_SECURE_COOKIE=" .env | cut -d '=' -f2)
if [ "$SESSION_SECURE" = "true" ]; then
    echo -e "${GREEN}✓${NC} Secure cookies enabled"
else
    echo -e "${YELLOW}⚠${NC} SESSION_SECURE_COOKIE should be true for HTTPS"
    ((WARNINGS++))
fi

# Test 11: Check if routes are cached
echo "11. Checking route cache..."
if [ -f bootstrap/cache/routes-v7.php ]; then
    echo -e "${GREEN}✓${NC} Routes are cached"
else
    echo -e "${YELLOW}⚠${NC} Routes not cached. Run 'php artisan route:cache'"
    ((WARNINGS++))
fi

# Test 12: Check if config is cached
echo "12. Checking config cache..."
if [ -f bootstrap/cache/config.php ]; then
    echo -e "${GREEN}✓${NC} Config is cached"
else
    echo -e "${YELLOW}⚠${NC} Config not cached. Run 'php artisan config:cache'"
    ((WARNINGS++))
fi

# Test 13: Check mail configuration
echo "13. Checking mail configuration..."
MAIL_HOST=$(grep "^MAIL_HOST=" .env | cut -d '=' -f2)
if [ "$MAIL_HOST" != "mailpit" ] && [ -n "$MAIL_HOST" ]; then
    echo -e "${GREEN}✓${NC} Mail host configured"
else
    echo -e "${YELLOW}⚠${NC} Mail host not configured for production"
    ((WARNINGS++))
fi

# Test 14: Check for .git directory in public
echo "14. Checking for .git in public directory..."
if [ ! -d public/.git ]; then
    echo -e "${GREEN}✓${NC} No .git directory in public"
else
    echo -e "${RED}✗${NC} Remove .git directory from public"
    ((ERRORS++))
fi

# Test 15: Check PHP version
echo "15. Checking PHP version..."
PHP_VERSION=$(php -r "echo PHP_VERSION;" | cut -d '.' -f1,2)
if (( $(echo "$PHP_VERSION >= 8.1" | bc -l) )); then
    echo -e "${GREEN}✓${NC} PHP version is $PHP_VERSION"
else
    echo -e "${RED}✗${NC} PHP version must be 8.1 or higher"
    ((ERRORS++))
fi

echo ""
echo "=========================================="
echo "TEST SUMMARY"
echo "=========================================="
echo -e "Errors: ${RED}$ERRORS${NC}"
echo -e "Warnings: ${YELLOW}$WARNINGS${NC}"
echo ""

if [ $ERRORS -eq 0 ] && [ $WARNINGS -eq 0 ]; then
    echo -e "${GREEN}✓ All tests passed! Ready for production.${NC}"
    exit 0
elif [ $ERRORS -eq 0 ]; then
    echo -e "${YELLOW}⚠ Tests passed with warnings. Review warnings before deployment.${NC}"
    exit 0
else
    echo -e "${RED}✗ Tests failed. Fix errors before deploying to production.${NC}"
    exit 1
fi
