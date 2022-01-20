<template>
  <div class="comment-create">
    <b-input-group :prepend="name" class="mt-3">
      <b-form-textarea
        id="textarea"
        v-model="context"
        placeholder="댓글에 댓글을 달아주세요~!"
        rows="3"
        max-rows="6"
      ></b-form-textarea>
      <b-input-group-append>
        <b-button variant="info" @click="createComment">작성하기</b-button>
      </b-input-group-append>
    </b-input-group>
  </div>
</template>
<script>
  import { mapGetters } from 'vuex'
  import { commentsPost } from '~/service'
  export default {
    name: "CommentCreate",
    props: {
      table: String,
      contentId: Number,
      loadComments: Function,
    },
    data() {
      return {
        name: "",
        context: ""
      };
    },
    computed: mapGetters({
      user: 'auth/user'
    }),
    created() {
      this.name = this.user.name
    },
    methods: {
      async createComment() {
        await commentsPost({
          table: this.table,
          user_id: this.user.id,
          parent_id: this.contentId,
          content: this.context,
        })

        this.loadComments();
        this.context = "";
      },
    }
  };
</script>
<style scoped>
  .comment-create {
    display: flex;
    margin-bottom: 1em;
  }
</style>
