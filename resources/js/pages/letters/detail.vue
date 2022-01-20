<template>
  <div>
    <b-card>
      <div class="content-detail-content-info">
        <div class="content-detail-content-info-left">
          <div class="content-detail-content-info-left-number">
            <b-button :pressed.sync="favoriteToggle" class="favorite" @click="onFavorite">
              찜
            </b-button>
          </div>
        </div>
        <div class="content-detail-content-info-right">
          <div class="content-detail-content-info-right-user">
            글쓴이: {{ user.id }}
          </div>
          <div class="content-detail-content-info-right-created">
            등록일: {{ created }}
          </div>
        </div>
      </div>
      <div class="content-detail-content">
        <div><img :src="thumbnail" class="thumbnail"></div>
        <div>{{ animal_name }}</div>
        <br>
        <div>{{ context }}</div>
      </div>
      <div class="prevNext">
        <div class="prev">
          <a v-if="prev" :href="`/letters/${prev.id}`">
            {{ prev.id }} ({{ prev.user_id }})<br>
            {{ prev.animal_name }}
          </a>
        </div>
        <div class="next">
          <a v-if="next" :href="`/letters/${next.id}`">
            {{ next.id }} ({{ next.user_id }})<br>
            {{ next.animal_name }}
          </a>
        </div>
      </div>
      <div class="content-detail-button">
        <b-button variant="primary" @click="updateData">
          수정
        </b-button>
        <b-button variant="success" @click="deleteData">
          삭제
        </b-button>
      </div>
      <div class="content-detail-comment">
<!--        <CommentList :table="table" :content-id="contentId" />-->
      </div>
    </b-card>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { lettersGetShow, lettersDelete, favoritesPost, favoritesDelete } from '~/service'
// import CommentList from '~/components/comments/CommentList'
export default {
  name: 'Detail',
  components: {
    // CommentList
  },
  async created () {
    const ret = await lettersGetShow({ id: this.$route.params.contentId, user_id: this.user.id })
    const { data } = ret.data
    this.thumbnail = '/storage/' + data.body.letter_thumbnail
    this.animal_name = data.body.animal_name
    this.context = data.body.contents
    this.created = data.body.created_at

    this.favoriteId = data.body.favorite ? data.body.favorite.id : null
    this.favoriteToggle = data.body.favorite != null
    this.prev = data.prev
    this.next = data.next
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  data () {
    const contentId = Number(this.$route.params.contentId)
    return {
      table: 'letters',
      contentId: contentId,
      thumbnail: '',
      animal_name: '',
      context: '',
      created: '',
      favoriteToggle: false,
      favoriteId: null,
      prev: null,
      next: null
    }
  },
  methods: {
    async deleteData () {
      const ret = await lettersDelete({ id: this.$route.params.contentId })
      if (ret.status === 204) {
        console.log('삭제성공')
      }
      this.$router.push({
        path: '/letters'
      })
    },
    updateData () {
      this.$router.push({
        path: `/letters/create/${this.contentId}`
      })
    },
    async onFavorite () {
      if (this.favoriteToggle) {
        const ret = await favoritesPost({ letter_id: this.contentId, user_id: this.user.id })
        const { data } = ret.data
        this.favoriteId = data.body.id
        if (ret.status === 201) {
          console.log('on')
        }
      } else {
        console.log('false')
        const ret = await favoritesDelete({ id: this.favoriteId })
        if (ret.status === 204) {
          this.favoriteId = null
          console.log('off')
        }
      }
    }
  }
}
</script>
<style scoped lang="scss">
  .prevNext {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    a {
      padding: 3px 10px;
      border-radius: 5px;
      display: inline-flex;
      background-color: #000;
      color: #fff;
      text-align: center;
    }
  }
  .favorite {
    margin-left: 20px;
    &.active {
      background-color: #007bff !important;
    }
  }
  .content-detail-content-info {
    border: 1px solid black;
    display: flex;
    justify-content: space-between;
  }
  .content-detail-content-info-left {
    width: 720px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
  }
  .content-detail-content-info-right {
    width: 300px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 1rem;
  }
  .content-detail-content {
    border: 1px solid black;
    margin-top: 1rem;
    padding-top: 1rem;
    min-height: 200px;
  }
  .content-detail-button {
    border: 1px solid black;
    margin-top: 1rem;
    padding: 2rem;
  }
  .content-detail-comment {
    border: 1px solid black;
    margin-top: 1rem;
    padding: 2rem;
  }
  .thumbnail {
    width: 200px;
  }
</style>
