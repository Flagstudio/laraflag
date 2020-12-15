import Vue from 'vue';
import axios from 'axios';
import PersonalWarning from './components/personal-warning.vue';
import 'focus-visible/dist/focus-visible.min.js';

window.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
axios.defaults.headers.post['X-CSRF-Token'] = window.csrf;

new Vue({
    el: '#header',
    components: {

    },
});

new Vue({
    el: '#main',
    components: {

    },
});

new Vue({
    el: '#footer',
    components: {
        PersonalWarning,
    },
});
