const mix = require('laravel-mix');

const publicFolder = 'public_html';
const project = 'johanvanhelden';
const isHot = process.env.npm_lifecycle_event === 'hot';

mix
    .copyDirectory('./node_modules/@fortawesome/fontawesome-free/webfonts', publicFolder + '/webfonts')
    .copyDirectory('./resources/img', publicFolder + '/images');

mix
    .js('resources/src/main.js', 'js')
    .webpackConfig(() => {
        return {
            stats: {
                children: true,
            },
        };
    })

    .postCss('resources/css/main.css', 'css')

    .options({
        processCssUrls: false,
        terser: {
            extractComments: false,
        },
    })

    .setPublicPath(publicFolder);

    if (!isHot && !mix.inProduction()) {
        mix.sourceMaps()
    }

    if (!isHot) {
        mix.extract();
    }

    if (!mix.inProduction()) {
        mix.disableSuccessNotifications()

        mix.browserSync({
            proxy: `http://${project}.localtest.me`,
            open: false,
            notify: false,
        });
    }

    if (mix.inProduction()) {
        mix.version();
    }
