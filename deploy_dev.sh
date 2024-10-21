# Change to project directory
DIR=/home/coduzudy/public_html/dev
cd $DIR
echo -e "* Deploy to directory: $DIR\n"

# Fetch new code:
git pull

# Install dependencies:
echo -e "\n* Install dependencies"
php82 composer.phar install --no-interaction

# Run migrations and apply project config:
echo -e "\n* Migrate Craft CMS Config"
php82 craft up --interactive=0

# create new asset version
TIMESTAMP=$(date +%s)
echo -e "\n* New asset version: $TIMESTAMP"
echo "<?php define('PFF25_ASSET_VERSION', '$TIMESTAMP');" > ./config/asset_version.php

echo -e "\n* Deployment complete."
