<template>
    <card class="flex flex-col items-center custom-card justify-center">
        <div class="px-3 py-3" v-html="card.content"></div>
    </card>
</template>

<script>
    export default {
        props: [
            'card',

            // The following props are only available on resource detail cards...
            // 'resource',
            // 'resourceId',
            // 'resourceName',
        ],

        mounted() {
            //
        },
    }
</script>

<style>
    .custom-card {
        display: flex;
        padding: 32px 24px;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        min-height: 220px;
        height: auto;
    }

    h1 {
        font-size: 29px;
        margin-bottom: 24px;
    }

    ul {
        list-style: none;
        padding-left: 0;
        font-size: 18px;
        line-height: 1.3;
    }

    ul li {
        margin-bottom: 12px;
    }
</style>