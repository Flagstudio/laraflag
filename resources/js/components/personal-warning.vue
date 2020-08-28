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

<script>
export default {
    name: 'PersonalWarning',
    data() {
        return {
            agree: true,
        };
    },
    mounted() {
        this.agree = localStorage.getItem('cookie-agreement') === 'true';
    },
    methods: {
        closeMessage() {
            this.agree = true;
            localStorage.setItem('cookie-agreement', 'true');
        },
    },
};
</script>
