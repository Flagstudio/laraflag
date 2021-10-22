<script lang="ts">
import { defineComponent } from 'vue';
import axios from 'axios';
import PersonalWarning from './components/personal-warning.vue';
import 'focus-visible/dist/focus-visible.min.js';

const csrfNode = document.querySelector('meta[name="csrf-token"]');
if (csrfNode) {
    axios.defaults.headers.post['X-CSRF-Token'] = csrfNode.getAttribute('content') || '';
}

export default defineComponent({
    name: 'App',
    components: {
        PersonalWarning,
    },
});
</script>
