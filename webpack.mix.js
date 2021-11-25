const mix = require('laravel-mix');

mix.options({
    fileLoaderDirs:  {
        fonts: 'static/fonts'
    }
});

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

// JavaScript assets
mix.ts('resources/assets/js/main.ts', 'public/static/js/');
mix.ts('resources/assets/js/worker.ts', 'public/');

// Styling assets
mix.sass('resources/assets/sass/main.scss', 'public/static/css/');

// Image and manifest assets
mix.copyDirectory('resources/assets/manifest/', 'public/static/manifest/');
mix.copyDirectory('resources/assets/images/', 'public/static/images/');

// Include a special case for the favicon.ico, which must also be in root
mix.copy('resources/assets/manifest/favicon.ico', 'public/');
