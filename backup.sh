#!/bin/bash

# Production Backup Script
# Schedule this with cron: 0 2 * * * /path/to/backup.sh

# Configuration
BACKUP_DIR="/path/to/backups"
APP_DIR="/path/to/application"
DATE=$(date +%Y%m%d_%H%M%S)
RETENTION_DAYS=30

# Database credentials from .env
DB_HOST=$(grep "^DB_HOST=" $APP_DIR/.env | cut -d '=' -f2)
DB_DATABASE=$(grep "^DB_DATABASE=" $APP_DIR/.env | cut -d '=' -f2)
DB_USERNAME=$(grep "^DB_USERNAME=" $APP_DIR/.env | cut -d '=' -f2)
DB_PASSWORD=$(grep "^DB_PASSWORD=" $APP_DIR/.env | cut -d '=' -f2)

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

echo "Starting backup at $(date)"

# Backup database
echo "Backing up database..."
mysqldump -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

if [ $? -eq 0 ]; then
    echo "Database backup completed successfully"
else
    echo "Database backup failed!"
    exit 1
fi

# Backup uploaded files
echo "Backing up uploaded files..."
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz -C $APP_DIR storage/app/public public/uploads public/profile_pic

if [ $? -eq 0 ]; then
    echo "Files backup completed successfully"
else
    echo "Files backup failed!"
    exit 1
fi

# Backup .env file
echo "Backing up .env file..."
cp $APP_DIR/.env $BACKUP_DIR/env_backup_$DATE

# Remove old backups
echo "Removing backups older than $RETENTION_DAYS days..."
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +$RETENTION_DAYS -delete
find $BACKUP_DIR -name "files_backup_*.tar.gz" -mtime +$RETENTION_DAYS -delete
find $BACKUP_DIR -name "env_backup_*" -mtime +$RETENTION_DAYS -delete

echo "Backup completed at $(date)"
echo "Backup location: $BACKUP_DIR"
echo ""
echo "Files created:"
ls -lh $BACKUP_DIR/*_$DATE*
