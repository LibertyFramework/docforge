
const pack = require('webpack-mix');

pack.js('assets/js/index.js', 'public/js')
    .options({ processCssUrls: false })
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts/fontawesome')
    .sass('assets/sass/style.scss', 'public/css')
    .sourceMaps()
    .disableNotifications()
