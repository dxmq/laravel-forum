<template>
    <div>
        <div class="zan_wrap" @click="toggle" :class="[{is_zan:classes}]">
            <span class="iconfont icon-dianzan"></span>
        </div>
        <div class="count">{{ count }}人点赞</div>
    </div>
</template>

<script>
    export default {
        props: ['post'],

        data() {
            return {
                count: this.post.favoritesCount,
                active:this.post.isFavorited
            }
        },

        computed: {
            classes() {
                return this.active;
            },

            endpoint() {
                return '/posts/' + this.post.id + '/favorites';
            }
        },
        methods: {
            toggle() {
                if (this.signedIn) {
                    this.active ? this.destroy() : this.create();
                } else {
                    flash('请先登录，然后再点赞！', 'warning');
                }
            },
            create() {
                axios.post(this.endpoint);

                this.active = true;
                this.count++;
            },

            destroy() {
                axios.delete(this.endpoint);

                this.active = false;
                this.count--;
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
        background: rgba(255, 170, 0, .1);
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
