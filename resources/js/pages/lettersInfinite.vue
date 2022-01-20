<template>
  <div id="body">
      <div class="title" v-sticky><h2>소통</h2></div>
      <div class="post" v-for="(post, index) in posts" :key="index" @click="rowClick(post)">
        <div class="post-title">[{{ index + 1 }} / {{ post.id }}] {{ post.animal_name }}</div>
        <div class="post-body">
          <b-img :src="`/storage/${post.letter_thumbnail}`" class="thumbnail"/>
          <div>{{ post.contents }}</div>
        </div>
      </div>
      <infinite-loading @infinite="infiniteHandler">
          <span slot="no-more">
              더이상 데이터가 없습니다
          </span>
      </infinite-loading>
  </div>
</template>

<script>
import { lettersInfiniteGet } from '~/service'
import InfiniteLoading from 'vue-infinite-loading';

export default {
  layout: 'layoutTwitter',
  components: { InfiniteLoading },
  data() {
    return {
      posts: [],
    }
  },
  methods: {
    infiniteHandler ($state) {
      let page = this.posts.length / 10 + 1;
      lettersInfiniteGet({ page: page }).then(response => {
        this.loadMore($state, response);
      });
    },
    loadMore ($state, response) {
      if (response.data.data.length) {
        this.posts = this.posts.concat(response.data.data);

        setTimeout(() => {
          $state.loaded();
        }, 3000);

        if (response.data.total == this.posts.length) {
          $state.complete();
        }
      } else {
        $state.complete();
      }

    },
    rowClick (post) {
      console.log(post.id);
      this.$router.push({
        path: `letters/${post.id}`
      })
    }
  },
}
</script>

<style lang="scss" scoped>
#body {
  .title {
    background-color: #fff;
    border-bottom: 1px solid rgb(239, 243, 244);
    padding: 16px;
    h2 {
      font-size: 1.25rem;
      margin-bottom: 0px;
    }
  }
}
.post {
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid rgb(239, 243, 244);
}
.post-title { font-size: 2em; padding: 16px; }
.post-body { font-size: 1.4em; padding: 16px; }
.thumbnail { width: 100px; }
.test { border: 1px solid red; }
</style>
