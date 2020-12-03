const mix = require('laravel-mix');


mix.styles(
    [
        "resources/assets/css/bootstrap.min.css",              
        "resources/assets/css/bootstrap-select.min.css",              
        "resources/assets/css/animate.css",
        "resources/assets/css/style.css",
        "resources/assets/css/datepicker3.css",
        "resources/assets/css/sweetalert.css",
    ],
    "public/css/app.css"
);

mix.scripts(
    [
        "resources/assets/js/jquery-3.1.1.min.js",
        "resources/assets/js/popper.min.js",
        "resources/assets/js/bootstrap.js",
        "resources/assets/js/bootstrap-select.min.js",
        "resources/assets/js/sweetalert.min.js",
        "resources/assets/js/plugins/metisMenu/jquery.metisMenu.js",
        "resources/assets/js/plugins/slimscroll/jquery.slimscroll.min.js",
        "resources/assets/js/inspinia.js",
        "resources/assets/js/plugins/datapicker/bootstrap-datepicker.js",
        "resources/assets/js/custom.js",
    ],
    "public/js/app.js"
);