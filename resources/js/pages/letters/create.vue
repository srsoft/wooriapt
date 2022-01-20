<template>
  <div>
    <label for="">동물선택</label>
    [{{ updateMode }} / {{ user }}]
    <b-form-select v-model="animal_name">
      <b-form-select-option :value="null">동물을 선택해주세요.</b-form-select-option>
      <b-form-select-option
        v-for="(option, idx) in animal_name_options"
        :key="idx"
        :value="option.animal_name"
      >
        {{ option.animal_name }}
      </b-form-select-option>
    </b-form-select>
    <label for="">내용입력</label>
    <b-form-textarea
      v-model="contents"
      placeholder="내용을 입력해 주세요"
      rows="3"
      max-rows="6"
    ></b-form-textarea>
    {{ thumbnail }}
    <p><img :src="thumbnail" class="thumbnail"/></p>
    <p><input type="file" class="form-control" v-on:change="onFileChange"></p>
    <b-button @click="updateMode ? updateContent() : uploadContent()" class="btn btn-success">저장</b-button>
    <b-button @click="cancel">취소</b-button>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import { lettersPost, lettersGetShow, lettersPut, animalsWriteGet } from '~/service'

  export default {
    name: "create",
    data() {
      return {
        contents: '',
        thumbnail: '',
        letter_thumbnail: '',
        letter_favorites_count: 0,
        letter_comments_count: 0,
        updateMode: this.$route.params.contentId > 0 ? true : false,

        name: '',
        file: '',
        success: '',

        // 동물불러오기
        animal_name: null,
        animal_name_options: [
          {
              animal_name: 'dog'
          },
          {
              animal_name: 'cat'
          }
        ],
      }
    },
    computed: mapGetters({
      user: 'auth/user'
    }),
    created() {
      if (this.updateMode) {
        // lettersInfiniteGet({ page: page }).then(response => {
        //   this.loadMore($state, response);
        // });

        lettersGetShow({ id: this.$route.params.contentId }).then(response => {
          const { data } = response.data;
          console.log(data.body);
          // this.user_id = this.user.id;
          this.animal_name = data.body.animal_name;
          this.contents = data.body.contents;
          this.thumbnail = '/storage/' + data.body.letter_thumbnail;
          this.letter_thumbnail = data.body.letter_thumbnail;
          this.letter_favorites_count = data.body.letter_favorites_count;
          this.letter_comments_count = data.body.letter_comments_count;
        });


      }

      // 동물리스트 보기
      // const ret = await animalsWriteGet({ user_id: this.user.id })
      // const { data } = ret.data
      // this.animal_name_options = data
    },
    methods: {
      onFileChange(e){
        console.log(e.target.files[0]);
        this.file = e.target.files[0];
        this.letter_thumbnail = e.target.files[0];
      },
      async uploadContent() {
        console.log(this.user.id, this.animal_name, this.contents)
        await lettersPost({
          user_id: this.user.id,
          animal_name: this.animal_name,
          contents: this.contents,
          letter_thumbnail: this.letter_thumbnail,
          letter_favorites_count: this.letter_favorites_count,
          letter_comments_count: this.letter_comments_count,
        })
        this.$router.push({
          path: '/letters'
        })
      },
      async updateContent() {
        // console.log('updateContent:', this.user.id, this.animal_name, this.content, this.letter_thumbnail);
        var response = await lettersPut({
          id: this.$route.params.contentId,
          user_id: this.user.id,
          animal_name: this.animal_name,
          contents: this.contents,
          letter_thumbnail: this.letter_thumbnail,
          letter_favorites_count: this.letter_favorites_count,
          letter_comments_count: this.letter_comments_count,
        })
        console.log(response);
        this.$router.push({
          path: '/letters'
        })
      },
      cancel() {
        this.$router.push({
          path: '/letters'
        })
      },
    }
  }
</script>

<style scoped>
  .thumbnail {
    width: 200px;
  }
</style>
