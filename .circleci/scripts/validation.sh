#!/usr/bin/env bash

echo '============================='
echo '== Validation              =='
echo '============================='

echo
echo '============================='
echo '| Syntax errors              '
echo '============================='
find app database tests config routes -name "*.php" -print0 | xargs -0 -n1 -P8 php -l
if [ $? != 0 ]; then
    exit 1;
fi

echo
echo '============================='
echo '| Coding standard            '
echo '============================='
phpcs --standard=phpcs.xml -vps
if [ $? != 0 ]; then
    exit 1;
fi

echo
echo '============================='
echo '| Coding standard fixers     '
echo '============================='
php-cs-fixer fix app database config routes tests --dry-run --diff --allow-risky=yes --config=.php_cs
if [ $? != 0 ]; then
    exit 1;
fi

echo
echo '============================='
echo '| Mess detector              '
echo '============================='
phpmd app text phpmd.xml
if [ $? != 0 ]; then
    exit 1;
fi

echo
echo '============================='
echo '| Copy paste detector        '
echo '============================='
phpcpd app database config routes
if [ $? != 0 ]; then
    exit 1;
fi
echo
