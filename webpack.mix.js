require('laravel-mix-eslint');

const mix = require('laravel-mix');
const config = require('./webpack.config');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig(config)
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .browserSync({
    open: 'external',
    host: '127.0.0.1',
    proxy: '127.0.0.1',
    notify: false,
    files: [
      'public/js/*.js',
      'routes/**/*.php',
      'public/css/*.css',
      'resources/lang/**/*.php'
    ]
  });

if (mix.inProduction()) {
  mix.version();
} else {
  mix.sourceMaps()
    .webpackConfig({
      devtool: 'eval-cheap-source-map',
    });
}
