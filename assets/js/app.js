require('../scss/app.scss');

let jQuery    = require('jquery');
let bootstrap = require('bootstrap');
require('@tabler/core');
let ClipboardJS = require('clipboard');

window.bootstrap = document.bootstrap = bootstrap;

jQuery(function () {
    Toast.configure(5, TOAST_PLACEMENT.TOP_RIGHT, TOAST_THEME.LIGHT, true);

    let clipboard = new ClipboardJS('.copy-to-clipboard');
    clipboard.on('success', function (e) {
        Toast.create('Copied', 'Text copied to clipboard', 1, 1500);
    });
});

