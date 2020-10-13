// Проверяем поддержку браузера
import './modules/vendor/modernizr-custom.js';

const warning = document.querySelector('#update-warning');
const closeBtn = document.querySelector('.js--close-update-warning');
if (window.Modernizr.flexbox && window.Modernizr.flexwrap && window.Modernizr.cssgrid) {
    warning.style.display = 'none';
} else {
    warning.style.display = 'block';

    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            warning.style.display = 'none';
        });
    }
}
