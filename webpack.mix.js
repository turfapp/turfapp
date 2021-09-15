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
mix.ts('resources/js/main.ts', 'public/static/js');

// Styling assets
mix.sass('resources/sass/main.scss', 'public/static/css');
