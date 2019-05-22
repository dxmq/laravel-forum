<template>
    <div class="col-md-12" :class="{ padding : show_level }">
        <h5>
            <a :href="'/profiles/'+comment['owner'].slug">
                <img :src="comment['owner'].avatar_path" width="40px" class="img-circle"/>
            </a>
            <span style="color:#37f">{{comment['owner'].name}}</span>
            :
            <span>{{comment.body}}</span>
        </h5>
        <div v-if="signedIn">
            <span v-if="get_is_show_reply()"><a class="reply_btn" @click="show_reply">回复</a></span>
        </div>
        <div v-show="is_show">
            <form @submit.prevent="post_comment" accept-charset="UTF-8">
                <div class="form-group">
                    <textarea v-model="comment_content" id="body" name="body" class="form-control"
                              required="required"></textarea>
                </div>
                <button type="submit" class="btn btn-submit">立即回复</button>
                <button @click="show_reply()" type="button" class="btn btn-default">取消回复</button>
            </form>
        </div>
        <div v-if="is_follow()">
            <comment-root :post_id="post_id" :user_id="user_id" :collections="get_child_list()"
                          :comments="real_comments"></comment-root>
        </div>
        <hr>
    </div>
</template>
<script>
    export default {
        props: ['comment', 'comments', 'user_id', 'post_id'],
        data() {
            return {
                show_level: true,
                is_show: false,
                comment_content: '',
                real_comments: this.comments,
            }
        },
        mounted() {
            if (this.comment.level > 2) {
                this.show_level = false;
            } else {
                this.show_level = true;
            }
        },
        methods: {
            show_reply() {
                this.is_show = !this.is_show;
            },
            is_follow() {
                if (typeof(this.comments[this.comment.id]) == 'undefined') {
                    return false;
                }
                return true;
            },
            get_child_list() {
                return this.comments[this.comment.id];
            },
            get_is_show_reply() {
                return this.user_id != this.comment['owner'].id;
            },
            post_comment() {
                axios.post('/api/posts/' + this.post_id + '/comment', {
                    'parent_id': this.comment.id,
                    'body': this.comment_content
                }).then((response) => {
                    if (response.data.reply_block) {
                        this.comment_content = '';
                        this.is_show = !this.is_show;
                        if (typeof(this.real_comments['' + response.data.reply_block.parent_id]) != 'undefined') {
                            this.real_comments[response.data.reply_block.parent_id].push(response.data.reply_block);
                        } else {
                            this.real_comments[this.comment.id] = new Array();
                            this.real_comments[this.comment.id].push(response.data.reply_block);
                        }
                    }
                });
            }
        }
    }
</script>
<style scoped lang="scss">
    .col-md-12 {
        padding: 0;
        &.padding {
            padding-left: 30px
        }
        .reply_btn {
            cursor: pointer;
            color: #37f;
            float: right;
            margin-right: 20px;
        }
        .btn-submit {
            background: #37f;
            color: #fff;
        }
    }
</style>
