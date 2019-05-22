<template>
    <div>
        <div class="zan_wrap" @click="zanOrCancel" :class="[{is_zan:is_zan}]">
            <span class="iconfont icon-dianzan"></span>
        </div>
        <div class="count">{{ fav_count }}人点赞</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fav_count: 0,
                is_zan: false,
            }
        },
        props: {
            post_id: Number
        },
        mounted() {
            axios.get('/api/posts/is-zan/' + this.post_id).then(response => {
                this.is_zan = response.data.is_zan;
                this.fav_count = response.data.fav_count;
            })
        },
        methods: {
            zanOrCancel() {
                axios.get('/api/posts/zan-or-cancel/'+this.post_id).then(response => {
                    this.is_zan = response.data.is_zan;
                    this.fav_count = response.data.fav_count;
                })
            }
        }
    }
</script>

<style scoped lang="scss">
    .zan_wrap {
        width: 66px;
        height: 66px;
        background: #fff;
        border-radius: 50%;
        text-align: center;
        margin: 0 auto;
        line-height: 66px;
        background: rgba(255,170,0,.1);
        color: #fa0;
        cursor: pointer;
        .iconfont {
            font-size: 30px;
        }
    }
    .is_zan {
        background: rgb(255, 170, 0);
        color: #fff;
    }
    .count {
        margin-top: 4px;
        margin-bottom: 4px;
        font-size: 13px;
        text-align: center;
    }

</style>
