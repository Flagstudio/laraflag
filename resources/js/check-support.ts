// Проверяем поддержку браузера
import './modules/vendor/modernizr-custom.js';

declare global {
    interface Window {
        Modernizr:any;
    }
}

const warning = document.querySelector<HTMLElement>('#update-warning');
const closeBtn = document.querySelector<HTMLElement>('.js--close-update-warning');
if (warning) {
    if (window.Modernizr.flexbox && window.Modernizr.flexwrap && window.Modernizr.cssgrid) {
        warning.style.display = 'none';
    } else {
        warning.style.display = 'block';

        if (closeBtn) {
            // eslint-disable-next-line prefer-arrow-callback
            closeBtn.addEventListener('click', function () {
                warning.style.display = 'none';
            });
        }
    }
}
