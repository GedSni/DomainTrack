const mix = require('laravel-mix');

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

//mix.less('resources/assets/less/app.less', 'public/stylesheets/styles.css')

mix.sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .sass('resources/assets/sass/style.scss', 'public/css/style.css')
    .js('resources/assets/js/methods.js', 'public/js/methods.js')
    .js('resources/assets/js/app.js', 'public/js/app.js')
    .version();
mix.browserSync('localhost:8000');
mix.disableNotifications();