<template>
    <div class="share-wrapper">
        <ul class="share-item">
            <li class="item copy-link":data-clipboard-text="copyText" @click="copyLink()" data-container="body" data-toggle="popover" data-placement="right"
                data-content="复制成功！">
                <span class="iconfont icon-lianjie"></span>
            </li>

            <li class="item" @mouseover="wechat()" @mouseout="wechat()">
                <span class="iconfont icon-weixin"></span>
            </li>
            <li class="item">
                <a :href="qq()" target="_blank">
                    <span class="iconfont icon-tubiao215"></span>
                </a>
            </li>
            <li class="item">
                <a :href="weibo()" target="_blank">
                    <span class="iconfont icon-weibo"></span>
                </a>
            </li>
        </ul>
        <transition name="fade">
            <div class="wechat-qrcode" v-show="is_show">
                <h4>微信扫一扫：分享</h4>
                <div class="qrcode">
                </div>
                <div class="help">
                    <p>微信里点“扫一扫”，扫一下</p>
                    <p>二维码便可将本文分享至朋友圈</p>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import ClipboardJS from 'clipboard'
    export default {
        name: 'Share',
        data () {
            return {
                url: '',
                title: '',
                timer: null,
                is_show: false
            }
        },
        methods: {
            qq() {
                return `http://connect.qq.com/widget/shareqq/index.html?url=${this.url}&title=${this.title
                    }`;
            },
            weibo() {
                return `https://service.weibo.com/share/share.php?url=${this.url}&title=${this.title
                    }`
            },
            wechat() {
                this.is_show = !this.is_show;
            },
            copyLink() {
                let btn = new ClipboardJS('.copy-link');
                btn.on('success', (e) => {
                    clearInterval(this.timer);
                    $("[data-toggle='popover']").popover('show');
                    this.timer = setTimeout(() => {
                        $("[data-toggle='popover']").popover('hide')
                    },1500)
                })
            }
        },
        computed: {
            copyText () {
                return this.title + '\n' + window.location.href
            }
        },
        mounted () {
            this.url = encodeURIComponent(window.location.href);
            this.title = $('.detail-title .d-t').html();
            $('.qrcode').qrcode({render: 'canvas', width: 100, height: 100 , text: this.url});
        }
    }
</script>

<style lang="scss" scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
    .wechat-qrcode {
        position: absolute;
        z-index: 9;
        top: 12px;
        left: 66px;
        width: 200px;
        height: 192px;
        color: #666;
        font-size: 12px;
        text-align: center;
        background-color: #fff;
        box-shadow: 0 2px 10px #aaa;
        h4 {
            font-weight: normal;
            height: 26px;
            line-height: 26px;
            font-size: 12px;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
            color: #777;
        }
        .qrcode {
            width: 105px;
            margin: 10px auto;
        }
        .help {
            p {
                font-weight: normal;
                line-height: 16px;
                padding: 0;
                margin: 0;
            }
        }
    }
    .share-wrapper {
        .title {
            font-size: 14px;
        }
        .share-item {
            margin-top: 2px;
            .item {
                background: #fff;
                margin-top: 10px;
                display: block;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                line-height: 40px;
                cursor: pointer;
                a {
                    color: #666;
                    .iconfont {
                        font-size: 20px;
                    }
                }
            }
        }
    }
</style>