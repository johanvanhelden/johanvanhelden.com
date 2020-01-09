const mix = require('laravel-mix');
const assetRoot = 'public_html';
const cssImport = require('postcss-import')
const cssNested = require('postcss-nested')
const tailwind = require('tailwindcss')
const autoprefixer = require('tailwindcss')
require('laravel-mix-purgecss');

mix
    .copyDirectory('./node_modules/@fortawesome/fontawesome-free/webfonts', assetRoot + '/fonts/vendor/font-awesome')
    .copyDirectory('./resources/img', assetRoot + '/images');

mix
    .js('resources/js/app.js', 'js')
    .postCss('resources/css/app.css', 'css', [
        cssImport(),
        tailwind(),
        cssNested(),
        autoprefixer(),
    ])
    .purgeCss({
        whitelistPatternsChildren: [/^nprogress$/]
    })
    .options({
        processCssUrls: false,
    })
    .setPublicPath('public_html');

if (process.env.npm_lifecycle_event !== 'hot') {
    mix.extract()
}

if (mix.config.production) {
    mix.version();
} else {
    mix
        .sourceMaps(false, 'source-map')
        .disableSuccessNotifications()
        .browserSync({
            proxy: 'johanvanhelden.localtest.me',
            notify: false,
        });
}
