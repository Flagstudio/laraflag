/* eslint-disable import/no-extraneous-dependencies, @typescript-eslint/no-var-requires */
const mix = require('laravel-mix');

const devMode = !mix.inProduction();
const webpack = require('webpack');
require('laravel-mix-bundle-analyzer');

mix
    .ts('resources/js/main.ts', 'public/js')
    .ts('resources/js/check-support.ts', 'public/js')
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

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false,
        }),
    ],
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
