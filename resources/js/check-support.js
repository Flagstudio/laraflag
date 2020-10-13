// Проверяем поддержку браузера
import './modules/vendor/modernizr-custom.js';

const warning = document.querySelector('#update-warning');
const closeBtn = document.querySelector('.js--close-update-warning');
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
