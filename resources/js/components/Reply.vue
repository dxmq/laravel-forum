<template>
    <div :id="'reply'+id" class="panel" :class="isBest ? 'panel-success' : 'panel-default'">
        <div class="panel-heading">
            <div class="level">
                <a :href="'/profiles/'+reply.owner.slug" :title="reply.owner.name" class="media-object img-thumbnail">
                    <img  width="30" :src="reply.owner.avatar_path" alt="reply.owner.name">
                </a>&nbsp;
                <span class="flex">
                    <a :href="'/profiles/'+reply.owner.slug"
                       v-text="reply.owner.name">
                    </a> 在 <span v-text="ago"></span> 说：
                </span>

                <div class="level" v-if="authorize('owns',reply) || authorize('owns',reply.thread)">
                    <div v-if="authorize('owns',reply)">
                        <button class="btn btn-xs mr-1" @click="editReply">编辑</button>
                        <button class="btn btn-xs btn-danger mr-1" @click="destroy">删除</button>
                    </div>

                    <button class="btn btn-xs btn-default ml-a" @click="markBestReply" v-if="authorize('owns',reply.thread)" style="margin-right: 12px">最佳回复</button>
                </div>

                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <form @submit.prevent="update">
                    <div class="form-group">
                        <wysiwyg v-model="body"></wysiwyg>
                    </div>

                    <button class="btn btn-xs btn-primary" >更新</button>
                    <button class="btn btn-xs btn-link" @click="cancelReply" type="button">取消</button>
                </form>
            </div>

            <div v-else v-html="body"> </div>
        </div>


    </div>
</template>
<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow();
            }
        },

        created() {
            window.events.$on('best-reply-selected',id => {
                this.isBest = (id === this.id)
            });
        },

        methods:{
            update() {
                axios.patch('/replies/' + this.reply.id,{
                    body:this.body
                })
                    .catch(error => {
                        flash(error.response.data,'danger');
                    });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted',this.id);
            },

            editReply(){
                this.old_body_data = this.body;
                this.editing = true;
            },

            cancelReply(){
                this.body = this.old_body_data;
                this.old_body_data = '';
                this.editing = false;
            },

            markBestReply() {
                this.isBest = true;

                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected',this.id);
            }
        }
    }
</script>