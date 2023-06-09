#!/bin/sh
RESULT_FILE="check_code.result.cache"
rm -f -- $RESULT_FILE
touch $RESULT_FILE

echo "Running php-cs-fixer..."
./vendor/bin/php-cs-fixer fix src/ -vvv --dry-run --rules=@Symfony,@PSR1,@PSR2,@PSR12 >> $RESULT_FILE
rm -f -- .php-cs-fixer.dist.php
rm -f -- .php-cs-fixer.cache

echo "Running phpcs..."
./vendor/bin/phpcs --standard=Symfony src/ --ignore=Kernel.php >> $RESULT_FILE




