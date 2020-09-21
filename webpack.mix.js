const mix = require('laravel-mix');
const assetRoot = 'public_html';
const cssImport = require('postcss-import')
const cssNested = require('postcss-nested')
const tailwind = require('tailwindcss')
const autoprefixer = require('tailwindcss')

mix
    .copyDirectory('./node_modules/@fortawesome/fontawesome-free/webfonts', assetRoot + '/webfonts')
    .copyDirectory('./resources/img', assetRoot + '/images');

mix
    .js('resources/js/app.js', 'js')
    .postCss('resources/css/app.css', 'css', [
        cssImport(),
        tailwind(),
        cssNested(),
        autoprefixer(),
    ])
    .options({
        processCssUrls: false,
        terser: {
            extractComments: false,
        },
        cssNano: {
            mergeRules: {
                exclude: true,
            },
        }
    })
    .setPublicPath('public_html');

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
