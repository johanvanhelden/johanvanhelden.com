#!/bin/bash
path=$1

if [ -z "$path" ] || [ ! -d "$path" ]; then
    echo "usage: ./buildHook.sh pathProjectRoot"
    echo "for example: ./buildHook.sh \$PWD"
    exit
fi

echo "====== Running $project build hook ======="

echo "====== Set the proper node version ======="
if [ -f ~/.nvm/nvm.sh ]; then
    . ~/.nvm/nvm.sh
fi

paths=(
    $path
)

for path in "${paths[@]}"
do
    cd $path

    if [ -f package.json ]; then
        find . -maxdepth 1 -name package.json | grep package > /dev/null 2>&1
        if [ $? == 0 ]; then
            echo "Running yarn install"
            yarn install --frozen-lockfile

            if [ $? != 0 ]; then
                exit 1;
            fi
        fi

        if [ -f webpack.mix.js ]; then
            yarn run prod

            if [ $? != 0 ]; then
                exit 1;
            fi
        else
            echo "No webpack.mix.js found"
        fi
    else
        echo "Package.json doesn't exist"
    fi
done

echo "========================================="
