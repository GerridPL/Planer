const mix = require('laravel-mix');

/**
 * Biblioteki zewnętrzne
 */
 mix.copy('resources/css', 'public/css');
 mix.copy('resources/js', 'public/js');


mix.sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
