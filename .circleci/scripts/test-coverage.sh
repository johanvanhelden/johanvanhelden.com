#!/usr/bin/env bash

echo '============================='
echo '== Test coverage           =='
echo '============================='

echo
echo '==============================='
echo '| PHPUnit test coverage        '
echo '==============================='

php -d pcov.enabled=1 ./vendor/bin/phpunit --coverage-clover ./coverage.xml

minPercentage=95

php ./.circleci/scripts/code-coverage-checker.php ./coverage.xml $minPercentage
if [ $? != 0 ]; then
    rm -f ./coverage.xml

    exit 1;
fi

rm -f ./coverage.xml
