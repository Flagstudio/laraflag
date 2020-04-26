import checkSupport from './modules/support-check';

checkSupport();

window.Vue = require('vue');
window.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const componentsHeader = {};

const componentsMain = {};

const componentsFooter = {
    'personal-warning': require('./components/personal-warning.vue').default,
};

const header = new Vue({
    components: componentsHeader,
    el: '#header'
});

const main = new Vue({
    components: componentsMain,
    el: '#main'
});

const footer = new Vue({
    components: componentsFooter,
    el: '#footer'
});
