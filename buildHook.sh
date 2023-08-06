#!/bin/bash
path=$1

if [ -z "$path" ] || [ ! -d "$path" ]; then
    path=$PWD
fi

echo "====== Running $project build hook ======="

echo "====== Set the proper node version ======="
if [ -f ~/.nvm/nvm.sh ]; then
    . ~/.nvm/nvm.sh
fi

nvm use 18

paths=(
    $path
)

for path in "${paths[@]}"
do
    cd $path

    if [ -f package.json ]; then
        find . -maxdepth 1 -name package.json | grep package > /dev/null 2>&1
        if [ $? == 0 ]; then
            echo "Running npm install (ci)"
            npm ci

            if [ $? != 0 ]; then
                exit 1;
            fi
        fi

        if [ -f vite.config.js ]; then
            npm run prod

            if [ $? != 0 ]; then
                exit 1;
            fi
        else
            echo "No vite.config.js found"
        fi
    else
        echo "Package.json doesn't exist"
    fi
done

echo "========================================="
