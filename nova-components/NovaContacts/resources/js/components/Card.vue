<template>
    <card class="flex flex-col items-center justify-center nova-contacts contacts-card">
        <div class="px-3 py-3">
            <h1>Информация по проекту</h1>
            Тестовая площадка: <a :href="flagstudioInfo.testapp">{{flagstudioInfo.testapp}}</a><br>
            Логин: {{flagstudioInfo.login}}<br>
            Пароль: {{flagstudioInfo.password}}<br>
            Ваш менеджер: {{flagstudioInfo.manager}}<br>
            E-mail: {{flagstudioInfo.email}}<br>
            Телефон: {{flagstudioInfo.phone}}<br>
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
                flagstudioInfo: this.card.flagstudioInfo,
            }
        },
    }
</script>

<style>
    .contacts-card {
        display: flex;
        padding: 32px 24px;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        min-height: 220px;
        height: auto;

        font-size: 18px;
        line-height: 1.3;
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
