<template>
    <button :class="classes" @click="subscribe" v-text="text"></button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn',this.active ? 'btn-primary' : 'btn-default'];
            },
            text() {
                return this.active ? '取消订阅' : '订阅';
            }
        },

        methods:{
            subscribe(){
                axios[
                    (this.active ? 'delete' : 'post')
                    ](location.pathname + '/subscriptions');

                this.active = ! this.active;
            }
        }
    }
</script>