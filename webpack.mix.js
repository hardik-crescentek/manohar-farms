const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/advanced-form-elements.js', 'public/assets/js')

    .js('resources/assets/js/apexcharts.js', 'public/assets/js')

    .js('resources/assets/js/bootstrap_calendar.min.js', 'public/assets/js')

    .js('resources/assets/js/calendar.js', 'public/assets/js')

    .js('resources/assets/js/calendar-events.js', 'public/assets/js')

    .js('resources/assets/js/carousel.js', 'public/assets/js')

    .js('resources/assets/js/chart.chartjs.js', 'public/assets/js')

    .js('resources/assets/js/chart.echarts.js', 'public/assets/js')

    .js('resources/assets/js/chart.flot.js', 'public/assets/js')

    .js('resources/assets/js/chart.flot.sampledata.js', 'public/assets/js')

    .js('resources/assets/js/chart.morris.js', 'public/assets/js')

    .js('resources/assets/js/chart.peity.js', 'public/assets/js')

    .js('resources/assets/js/chart.sparkline.js', 'public/assets/js')

    .js('resources/assets/js/chart-circle.js', 'public/assets/js')

    .js('resources/assets/js/chat.js', 'public/assets/js')

    .js('resources/assets/js/check-all-mail.js', 'public/assets/js')

    .js('resources/assets/js/checkout-jquery-steps.js', 'public/assets/js')

    .js('resources/assets/js/circle-progress.min.js', 'public/assets/js')

    .js('resources/assets/js/contacts.js', 'public/assets/js')

    .js('resources/assets/js/crypto-buysell.js', 'public/assets/js')

    .js('resources/assets/js/crypto-dashboard.js', 'public/assets/js')

    .js('resources/assets/js/crypto-exchange.js', 'public/assets/js')

    .js('resources/assets/js/crypto-market.js', 'public/assets/js')

    .js('resources/assets/js/custom.js', 'public/assets/js')

    .js('resources/assets/js/dashboard.sampledata.js', 'public/assets/js')

    .js('resources/assets/js/ecommerce-dashboard.js', 'public/assets/js')

    .js('resources/assets/js/form-editor.js', 'public/assets/js')

    .js('resources/assets/js/form-elements.js', 'public/assets/js')

    .js('resources/assets/js/form-layouts.js', 'public/assets/js')

    .js('resources/assets/js/form-validation.js', 'public/assets/js')

    .js('resources/assets/js/form-wizard.js', 'public/assets/js')

    .js('resources/assets/js/handleCounter.js', 'public/assets/js')

    .js('resources/assets/js/index.js', 'public/assets/js')

    .js('resources/assets/js/jquery.vmap.sampledata.js', 'public/assets/js')

    .js('resources/assets/js/left-menu.js', 'public/assets/js')

    .js('resources/assets/js/mail.js', 'public/assets/js')

    .js('resources/assets/js/mapelmaps.js', 'public/assets/js')

    .js('resources/assets/js/modal.js', 'public/assets/js')

    .js('resources/assets/js/navigation.js', 'public/assets/js')

    .js('resources/assets/js/popover.js', 'public/assets/js')

    .js('resources/assets/js/select2.js', 'public/assets/js')

    .js('resources/assets/js/snap.svg-min.js', 'public/assets/js')

    .js('resources/assets/js/sticky.js', 'public/assets/js')

    .js('resources/assets/js/table-data.js', 'public/assets/js')

    .js('resources/assets/js/timline.js', 'public/assets/js')

    .js('resources/assets/js/tooltip.js', 'public/assets/js')

    .js('resources/assets/js/vector-map.js', 'public/assets/js')

    .js('resources/assets/js/widgets.js', 'public/assets/js')

    .js('resources/assets/plugins/counters/counter.js', 'public/assets/plugins/counters')

    .js('resources/assets/plugins/darggable/darggable.js', 'public/assets/plugins/darggable')

    .js('resources/assets/plugins/clipboard/clipboard.js', 'public/assets/plugins/clipboard')

    .js('resources/assets/plugins/fileuploads/js/file-upload.js', 'public/assets/plugins/fileuploads/js')

    .js('resources/assets/plugins/jquery-countdown/countdown.js', 'public/assets/plugins/jquery-countdown')

    .js('resources/assets/plugins/model-datepicker/js/main.js', 'public/assets/plugins/model-datepicker/js')

    .js('resources/assets/plugins/multipleselect/multi-select.js', 'public/assets/plugins/multipleselect')

    .js('resources/assets/plugins/rating/ratings.js', 'public/assets/plugins/rating')

    .js('resources/assets/plugins/sidemenu/sidemenu.js', 'public/assets/plugins/sidemenu')

    .js('resources/assets/plugins/sweet-alert/jquery.sweet-alert.js', 'public/assets/plugins/sweet-alert')

    .js('resources/assets/plugins/telephoneinput/inttelephoneinput.js', 'public/assets/plugins/telephoneinput')

    .sass('resources/assets/scss/style.scss', 'public/assets/css/style')

    .sass('resources/assets/scss1/dark-style.scss', 'public/assets/css')

    .sass('resources/assets/scss1/skins.scss', 'public/assets/css')

    .sass('resources/assets/scss1/sidemenu/sidemenu.scss', 'public/assets/css/sidemenu')

    .sass('resources/assets/scss1/colors/color.scss', 'public/assets/css/colors')

    .sass('resources/assets/scss1/colors/color1.scss', 'public/assets/css/colors')

    .sass('resources/assets/scss1/colors/color2.scss', 'public/assets/css/colors')

    .sass('resources/assets/scss1/colors/color3.scss', 'public/assets/css/colors')

    .sass('resources/assets/scss1/colors/color4.scss', 'public/assets/css/colors')

    .sass('resources/assets/scss1/colors/color5.scss', 'public/assets/css/colors')

    .sass('resources/assets/scss1/colors/default.scss', 'public/assets/css/colors')

    .copyDirectory('resources/assets/img', 'public/assets/img')

    .copyDirectory('resources/assets/plugins', 'public/assets/plugins')
mix.options({
        processCssUrls: false
    });
