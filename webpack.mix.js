const mix = require('laravel-mix');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const devMode = !mix.inProduction();
require('laravel-mix-bundle-analyzer');

mix
    .js('resources/js/app.js', 'public/js').extract()
    .js('resources/js/check-support.js', 'public/js')
    .sass('resources/sass/nova.scss', 'public/css/nova.css')
    .sass('resources/sass/app.scss', 'public/css', {
        implementation: require('node-sass')
    })
    .sass('resources/sass/components.scss', 'public/css')
    .options({extractVueStyles: true})
    .webpackConfig({
        devtool: devMode ? 'source-map' : '',
        plugins: [
            new BrowserSyncPlugin(
                {
                    host: 'localhost',
                    port: 3000,
                    proxy: 'http://project.flagstudio.loc',
                    files: [
                        './resources/views/**/*.php'
                    ]
                },
                {
                    reload: true
                }
            )
        ]
    })
    .version()
    .copyDirectory('resources/img', 'public/images');

if (devMode) {
    mix.sourceMaps();
}

// if (mix.inProduction()) {
//     mix.bundleAnalyzer();
// }
