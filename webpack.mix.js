const mix = require('laravel-mix');

mix.setPublicPath('public')
   .js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .version();

// Configuración adicional
mix.options({
    processCssUrls: false,
    postCss: [
        require('autoprefixer')
    ]
});

// Configuración para desarrollo
if (!mix.inProduction()) {
    mix.sourceMaps();
} 