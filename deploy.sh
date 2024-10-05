# Change to project directory
cd /home/coduzudy/public_html/craftcms

# Fetch new code:
git pull

# Install dependencies:
php82 composer.phar install --no-interaction

# Run migrations and apply project config:
php82 craft up --interactive=0

# create new asset version
TIMESTAMP=$(date +%s)
echo "<?php define('PFF25_ASSET_VERSION', '$TIMESTAMP');" > ./config/asset_version.php
