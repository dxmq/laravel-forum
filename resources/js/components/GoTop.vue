<template>
    <transition name="fade">
        <div class="goTop" @click="goTop" v-if="isShow">
            <span class="glyphicon glyphicon-menu-up"></span>
        </div>
    </transition>
</template>

<script>
    export default {
        data() {
            return {
                isShow : false,
            }
        },
        mounted() {
            let that = this;
            $(window).scroll(function(){
                if( $(this).scrollTop() > 50 ){
                    that.isShow = true;
                } else {
                    that.isShow = false;
                }
            });
        },
        methods: {
            goTop() {
                $('html,body').animate({scrollTop:0});
            }
        }
    }
</script>
<style scoped lang="scss">
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
    .goTop {
        position: fixed;
        right: 36px;
        bottom: 50px;
        background: #FFF;
        width: 50px;
        height: 50px;
        line-height: 60px;
        text-align: center;
        border-radius: 2px;
        box-shadow: 0 4px 12px 0 rgba(7,17,27,.1);
        cursor: pointer;
        z-index: 1000;
        span {
            font-size: 20px;
        }
    }
</style>
