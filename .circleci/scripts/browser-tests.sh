#!/bin/bash
echo '========================='
echo '== Running Tests       =='
echo '========================='

echo
echo '==============================='
echo '| 1. Run Xvfb :                '
echo '==============================='
pgrep Xvfb

exitcode=`echo $?`
if [[ $exitcode != 0 ]]; then
    #not running, so run it.
    Xvfb -ac :0 -screen 0 1280x1024x16 &
    if [ $? != 0 ]; then
        exit 1;
    fi
fi

echo
echo '==============================='
echo '| 2. Artisan Serve:            '
echo '==============================='
# check if serve is running
curl 127.0.0.1:8080

exitcode=`echo $?`
if [[ $exitcode != 0 ]]; then
    php artisan serve  --port=8080 &
    if [ $? != 0 ]; then
        exit 1;
    fi

    sleep 4
fi

echo
echo '==============================='
echo '| 3. Run Dusk:                 '
echo '==============================='

# set the environment variable containing the Chrome version
CHROME_VERSION=$(cat /root/chrome_version)

# get the proper chrome driver
echo "Installed Chrome version: ${CHROME_VERSION}"
php artisan dusk:chrome-driver ${CHROME_VERSION}

# ensure the chrome driver is executable
chmod +x ./vendor/laravel/dusk/bin/chromedriver-linux

php artisan dusk

# if the tests fail, zip the artifacts and push them to the repo downloads
if [ $? != 0 ]; then
    exit 1;
fi
