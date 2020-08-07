//Проверяем поддержку браузера
import './modules/vendor/modernizr-custom.js';

var warning = document.querySelector('#update-warning');
var closeBtn = document.querySelector('.js--close-update-warning');
if (Modernizr.flexbox && Modernizr.flexwrap && Modernizr.cssgrid) {
    warning.style.display = 'none';
} else {
    warning.style.display = 'block';

    if(closeBtn) {
        closeBtn.addEventListener('click', function () {
            warning.style.display = 'none';
        })
    }
}
