//Проверяем поддержку браузера
import './vendor/modernizr-custom.js';

function checkSupport() {
    var warning = document.querySelector('#update-warning');
    var closeBtn = document.querySelector('.js--close-update-warning');
    if (Modernizr.flexbox && Modernizr.flexwrap) {
        warning.style.display = 'none';
    } else {
        warning.style.display = 'block';

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                warning.style.display = 'none';
            })
        }
    }
}

export default checkSupport;