<template>
  <div>
    <div :key="item.id" v-for="item in comments">
      <CommentListItem :commentObj="item" :loadComments="loadComments"/>
    </div>
    <CommentCreate :table="table" :contentId="contentId" :loadComments="loadComments"/>
  </div>
</template>
<script>
  import CommentListItem from '~/components/comments/CommentListItem';
  import CommentCreate from '~/components/comments/CommentCreate';
  import { commentsGet } from '~/service'
  export default {
    name: "CommentList",
    props: {
      contentId: Number,
      table: String,
    },
    components: {
      CommentListItem,
      CommentCreate,
    },
    created() {
      this.loadComments()
    },
    data() {
      return {
        comments: [],
      }
    },
    methods: {
      async loadComments() {
        const ret = await commentsGet({ table: this.table, parent_id: this.contentId })
        const { data } = ret.data
        this.comments = data
      }
    }
  };
</script>
