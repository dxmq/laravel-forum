<template>
    <div>
        <hr>
          <comment-root :post_id="post_id" :user_id="user_id" :comments="comments" :collections="comment_list"></comment-root>
        <hr>
        <form method="POST" @submit.prevent="post_comment" accept-charset="UTF-8" v-if="signedIn">
            <div class="form-group">
                <textarea v-model="comment_content" id="comment" name="comment" rows="4" class="form-control"
                          placeholder="请填写您的评论"
                          required="required"></textarea>
            </div>
            <button type="submit" class="btn btn-submit form-control">提交评论</button>
        </form>
        <p class="text-center" v-else>
            请先<a href="/login">登录</a>，然后再发表评论
        </p>
    </div>
</template>
<script>
    export default{
        props:['post_id','collections','comments','user_id'],
        data(){
            return{
              comment_content:'',
              comment_list:this.collections,
            }
        },
        methods:{
            post_comment(){
                axios.post('/api/posts/'+this.post_id+'/comment',{'body':this.comment_content}).then((response)=>{
                    if(response.data.reply_block){
                        this.comment_list.push(response.data.reply_block);
                        this.comment_content='';
                    }
                });
            },
        }
    }
</script>
<style scoped lang="scss">
    .btn-submit {
      background: #37f;
      color:#fff;
    }
    .comment-footer {
        margin-left: 30px;
    }
</style>
