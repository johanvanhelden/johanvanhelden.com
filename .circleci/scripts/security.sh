#!/usr/bin/env bash

echo '============================='
echo '== Security                =='
echo '============================='

echo
echo '==============================='
echo '| Check composer security      '
echo '==============================='
if [ -f "composer.lock" ]; then
    security-checker --no-ansi -vvv security:check
    if [ $? != 0 ]; then
        exit 1
    fi
else
    echo "Skipped"
fi
