const mix = require('laravel-mix');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default;
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminMozjpeg = require('imagemin-mozjpeg');
const devMode = !mix.inProduction();

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/nova.scss', 'public/css/nova.css')
    .sass('resources/sass/app.scss', 'public/css', {
        implementation: require('node-sass')
    })
    .options({ extractVueStyles: true })
    .webpackConfig({
        devtool: devMode ? 'source-map' : '',
        plugins: [
            new CopyWebpackPlugin([{
                from: 'resources/img',
                to: 'images'
            }]),
            new ImageminPlugin({
                test: /\.(jpe?g|png|gif|svg)$/i,
                plugins: [
                    ImageminMozjpeg({
                        quality: 80
                    })
                ]
            }),
            new BrowserSyncPlugin(
                {
                    host: 'localhost',
                    port: 3000,
                    proxy: 'http://project.flagstudio.loc',
                    files: [
                        './resource/views/**/*.php'
                    ]
                },
                {
                    reload: true
                }
            )
        ]
    })
    .version();

if (devMode) {
    mix.sourceMaps();
}
