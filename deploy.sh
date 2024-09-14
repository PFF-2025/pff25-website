# Change to project directory
SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
cd "$SCRIPT_DIR" || exit

# Fetch new code:
git pull

# Install dependencies:
php82 composer.phar install --no-interaction

# Run migrations and apply project config:
php82 craft up --interactive=0
