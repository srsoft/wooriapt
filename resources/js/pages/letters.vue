<template>
  <div>
    <div class="search-area">
      <b-form-select v-model="searchPart">
        <b-form-select-option
          v-for="(option, idx) in searchPartOptions"
          :key="idx"
          :value="option.key"
        >
          {{ option.label }}
        </b-form-select-option>
      </b-form-select>
      <b-input v-model="searchText" />
      <b-button @click="searchClick">찾기</b-button>
    </div>
    <b-table striped hover :items="items" :per-page="perPage" :current-page="currentPage" :fields="fields" @row-clicked="rowClick">
      <template #cell(letter_thumbnail)="data">
        <b-img :src="`/storage/${data.value}`" class="thumbnail"/>
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="perPage"
      align="center"
    ></b-pagination>
    <b-button @click="writeContent">글쓰기</b-button>
  </div>
</template>

<script>
import { lettersGet } from '~/service'
export default {
  name: 'letters',
  async created () {
    const ret = await lettersGet({ searchPart: '', searchText: '' })
    const { data } = ret.data
    this.items = data
  },
  data () {
    return {
      perPage: 10,
      currentPage: 1,
      fields: [
        {
          key: 'id',
          label: '번호',
          sortable: true
        },
        {
          key: 'user.name',
          label: '작성자',
          sortable: true
        },
        {
          key: 'letter_thumbnail',
          label: '섬네일',
          sortable: true
        },
        {
          key: 'animal_name',
          label: '동물이름',
          sortable: true
        },
        {
          key: 'contents',
          label: '내용',
          sortable: true
        },
        {
          key: 'letter_favorites_count',
          label: '찜갯수',
          sortable: true
        },
        {
          key: 'letter_comments_count',
          label: '댓글갯수',
          sortable: true
        },
        {
          key: 'created_at',
          label: '작성일시',
          sortable: true
        }
      ],
      items: [],
      searchPart: '1',
      searchPartOptions: [
        {
          key: '1',
          label: '편지내용'
        },
        {
          key: '2',
          label: '글쓴이'
        },
        {
          key: '3',
          label: '이름'
        }
      ],
      searchText: ''
    }
  },
  methods: {
    async searchClick () {
      console.log(this.searchPart, this.searchText)
      const ret = await lettersGet({ searchPart: this.searchPart, searchText: this.searchText })
      const { data } = ret.data
      this.items = data
    },
    rowClick (item, index, e) {
      this.$router.push({
        path: `letters/${item.id}`
      })
    },
    writeContent () {
      this.$router.push({
        path: 'letters/create'
      })
    }
  },
  computed: {
    rows () {
      return this.items.length
    }
  }
}
</script>
<style scoped lang="scss">
.search-area {
  display: flex;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
  justify-content: center;
  margin-bottom: 20px;
  select {
    width: 150px;
    margin-right: 10px;
  }
  input {
    width: 300px;
    margin-right: 10px;
  }
}
.thumbnail {
  width: 100px;
}
</style>
