const mix = require('laravel-mix');
const tailwind = require('tailwindcss');

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
mix.ts('resources/js/main.ts', 'public/js')

// Styling assets
mix.sass('resources/sass/main.scss', 'public/css')
    .options({
        postCss: [ tailwind('./tailwind.config.js') ]
    });
