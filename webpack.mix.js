const mix = require('laravel-mix');

const devMode = !mix.inProduction();
require('laravel-mix-bundle-analyzer');

mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/check-support.js', 'public/js')
    .vue({
        extractStyles: true,
    })
    .extract()
    .sass('resources/sass/nova.scss', 'public/css/nova.css')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/components.scss', 'public/css')
    .version()
    .copyDirectory('resources/img', 'public/images')
    .browserSync({
        proxy: '0.0.0.0:8080',
        open: false,
    });

if (devMode) {
    mix.sourceMaps(false, 'source-map');
}

if (process.env.SHOW_STAT === 'true') {
    mix.bundleAnalyzer(
        {
            analyzerHost: '0.0.0.0',
            analyzerPort: '3000',
        },
    );
}
