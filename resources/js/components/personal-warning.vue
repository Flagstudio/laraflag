<template>
    <section :class="['personal-warning', {'personal-warning--show' : !agree}]">
        <div class="personal-warning__inner">
            <div class="personal-warning__text">
                <slot />
            </div>
            <button
                class="personal-warning__btn btn"
                @click="closeMessage"
            >
                Принять
            </button>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

interface State {
    agree: boolean;
}

export default defineComponent({
    name: 'PersonalWarning',
    data: (): State => ({
        agree: true,
    }),
    mounted() {
        this.agree = localStorage.getItem('cookie-agreement') === 'true';
    },
    methods: {
        closeMessage() {
            this.agree = true;
            localStorage.setItem('cookie-agreement', 'true');
        },
    },
});
</script>
