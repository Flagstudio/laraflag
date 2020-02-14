<template>
    <card class="flex flex-col items-center justify-center nova-instructions instructions-card">
        <div class="px-3 py-3">
            <h1>Инструкции</h1>
            <ul>
                <li
                    v-for="instruction in instructions"
                >
                    <a :href="instruction.link ? instruction.link : false">{{instruction.title}}</a>
                </li>
            </ul>
        </div>
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
        data() {
            return {
                instructions: this.card.instructions,
            }
        },
    }
</script>

<style>
    .instructions-card {
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
