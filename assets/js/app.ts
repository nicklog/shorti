import '../scss/app.scss';

import ClipboardJS from "clipboard";
import {Tooltip} from 'bootstrap';
import Iconify from '@iconify/iconify';

Iconify.loadIcons([]);

document.addEventListener("DOMContentLoaded", async () => {
    new ClipboardJS('.copy-to-clipboard');

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl);
    });
});
