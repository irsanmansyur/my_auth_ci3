let mix = require('laravel-mix');

mix.setPublicPath('dist')
  .options({
    hmrOptions: {
      port: 3000
    }
  })
  .sass('src/scss/app.scss', 'css/app.css')
  .js('src/js/app.js', 'js/app.js').react();
mix.minify("dist/css/app.css");
