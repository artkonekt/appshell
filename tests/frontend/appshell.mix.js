const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Sample Laravel Mix File To Be Used Within The CI for Testing
 |--------------------------------------------------------------------------
 */

mix.js('src/resources/assets/js/appshell.standalone.commonjs.js', 'public/js/appshell.js')
    .sass('src/resources/assets/sass/appshell.sass', 'public/css');
