<script>
    import Replies from '../components/Replies';
    import SubscribeButton from '../components/SubscribeButton'

    export default {
        props: ['thread'],

        components: {Replies, SubscribeButton},

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
            };
        },

        methods: {
            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

                this.locked = ! this.locked;
            },
            test() {
                return this.locked ? '取消锁定' : '锁定';
            }
        }
    }
</script>