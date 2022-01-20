<template>
  <div>
    <div v-show="!commentUpdateToggle" class="comment-list-item">
      <div class="comment-list-item-name">
        <div>user_id : {{ commentObj.user_id }}</div>
        <div>{{ commentObj.created_at }}</div>
      </div>
      <div class="comment-list-item-context">{{ commentObj.content }}</div>
      <div class="comment-list-item-button">
        <b-button variant="info" @click="commentUpdateToggle = !commentUpdateToggle">수정</b-button>
        <b-button variant="info" @click="deleteComment">삭제</b-button>
      </div>
    </div>
    <div v-show="commentUpdateToggle" class="comment-list-update">
      <div class="comment-list-update-name">
        <div>user_id : {{ commentObj.user_id }}</div>
        <div>{{ commentObj.created_at }}</div>
      </div>
      <div class="comment-list-update-context">
        <textarea v-model="context" cols="40" rows="2"></textarea>
      </div>
      <div class="comment-list-update-button">
        <b-button variant="info" @click="commentUpdateToggle = !commentUpdateToggle">취소</b-button>
        <b-button variant="info" @click="updateComment">저장</b-button>
      </div>
    </div>
  </div>
</template>
<script>
  import { mapGetters } from 'vuex'
  import { commentsPut, commentsDelete } from '~/service'
  import CommentCreate from "~/components/dashboard/comments/CommentCreate";
  export default {
    name: "CommentListItem",
    props: {
      commentObj: Object,
      loadComments: Function,
    },
    components: {
      CommentCreate
    },
    data() {
      return {
        commentUpdateToggle: false,
        context: this.commentObj.content,
      };
    },
    computed: mapGetters({
      user: 'auth/user'
    }),
    methods: {
      async deleteComment(){
        await commentsDelete({
          id: this.commentObj.id
        })
        this.loadComments()
      },
      async updateComment(){
        // id, table, user_id, parent_id, content
        await commentsPut({
          id: this.commentObj.id,
          table: this.commentObj.table,
          user_id: this.user.id,
          parent_id: this.commentObj.parent_id,
          content: this.context
        })
        this.commentUpdateToggle = false
        this.loadComments()
      },
    }
  };
</script>
<style scoped>
  .comment-list-item { display: flex; justify-content: space-between; border-top: 1px solid black; }
  .comment-list-item-name { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 1em; width: 150px; }
  .comment-list-item-context { display: flex; justify-content: center; align-items: center; flex-grow: 1; }
  .comment-list-item-button { display: flex; flex-direction: row; justify-content: center; align-items: center; padding: 1em; width: 160px; }

  .comment-list-update { display: flex; justify-content: space-between; background-color: #ccc; }
  .comment-list-update-name { display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 1em; width: 150px; }
  .comment-list-update-context { display: flex; justify-content: center; align-items: center; flex-grow: 1; }
  .comment-list-update-button { display: flex; flex-direction: row; justify-content: center; align-items: center; padding: 1em; width: 160px; }

</style>
