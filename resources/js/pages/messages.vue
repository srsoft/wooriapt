<template>
  <div id="community">
    <main>
      <div class="title" v-sticky><h2>메시지</h2></div>
      <div class="post-writer">
        <div class="container">
          <div class="con-left">
            <img src="https://pbs.twimg.com/profile_images/1436343719490297856/lVowcz2q_normal.jpg" alt="" class="avator"/>
          </div>
          <div class="con-right">
            <div class="post-body">
              <textarea v-model="contents"></textarea>
              [{{ letter_thumbnail }}]
<!--              <input type="file" v-model="letter_thumbnail" multiple accept="image/*">-->
              <UploadImages :max="4" @changed="handleImages"/>

            </div>
            <div class="post-footer">
              <div class="post-footer-left">
                <emoji-picker @emoji="insert" :search="search" class="emoji-container">
                  <div class="emoji-invoker" slot="emoji-invoker" slot-scope="{ events: { click: clickEvent } }" @click.stop="clickEvent">
                    <svg viewBox="0 0 24 24" aria-hidden="true" class="r-1cvl2hr r-4qtqp9 r-yyyyoo r-z80fyv r-dnmrzs r-bnwqim r-1plcrui r-lrvibr r-19wmn03"><g><path d="M12 22.75C6.072 22.75 1.25 17.928 1.25 12S6.072 1.25 12 1.25 22.75 6.072 22.75 12 17.928 22.75 12 22.75zm0-20C6.9 2.75 2.75 6.9 2.75 12S6.9 21.25 12 21.25s9.25-4.15 9.25-9.25S17.1 2.75 12 2.75z"></path><path d="M12 17.115c-1.892 0-3.633-.95-4.656-2.544-.224-.348-.123-.81.226-1.035.348-.226.812-.124 1.036.226.747 1.162 2.016 1.855 3.395 1.855s2.648-.693 3.396-1.854c.224-.35.688-.45 1.036-.225.35.224.45.688.226 1.036-1.025 1.594-2.766 2.545-4.658 2.545z"></path><circle cx="14.738" cy="9.458" r="1.478"></circle><circle cx="9.262" cy="9.458" r="1.478"></circle></g></svg>
                  </div>
                  <div slot="emoji-picker" slot-scope="{ emojis, insert, display }" class="emoji-picker">
                    <div class="emoji-search">
                      <input type="text" v-model="search" placeholder="Search emojis">
                    </div>
                    <div class="emoji-contents">
                      <div v-for="(emojiGroup, category) in emojis" :key="category">
                        <h5>{{ category }}</h5>
                        <div>
              <span
                v-for="(emoji, emojiName) in emojiGroup"
                :key="emojiName"
                @click="insert(emoji)"
                :title="emojiName"
              >{{ emoji }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </emoji-picker>
              </div>
              <div class="post-footer-right">
                <span class="write" @click="uploadContent">등록</span>
              </div>



            </div>
          </div>
        </div>
      </div>
      <div class="post" v-for="(post, index) in postsNew" :key="index">
        <post-item :post="post" :rowClick="rowClick" :commentClick="commentClick" :retweetClick="retweetClick" :likeClick="likeClick" :shereClick="shereClick"></post-item>
      </div>
      <div class="post" v-for="(post, index) in posts" :key="index">
        <post-item :post="post" :rowClick="rowClick" :commentClick="commentClick" :retweetClick="retweetClick" :likeClick="likeClick" :shereClick="shereClick"></post-item>
      </div>
      <infinite-loading @infinite="infiniteHandler">
          <span slot="no-more">
              더이상 데이터가 없습니다
          </span>
      </infinite-loading>
    </main>
    <sidebar>
      <div class="searchBar">
        <vue-search
          :img-photo="'path-img'"
          @newitem="newitem()"
          @itemselected="itemselected($event)"
          :source-field="'name'"
          :show-new-botton="true"
          :search-by-field="false"
          :api-source="'https://url-data-source'"
          placeholder="Search Community"
        ></vue-search>
      </div>
      <div class="searchSizedBox"></div>
      <div class="container" v-sticky>
        <ul class="gallery">
          <li><img alt="Image" src="https://pbs.twimg.com/media/FB3pC3QXMAAu6YM?format=jpg&amp;name=240x240"/></li>
          <li><img alt="Image" src="https://pbs.twimg.com/media/FB2SITRXMAIgmDX?format=jpg&name=240x240"/></li>
          <li><img alt="Image" src="https://pbs.twimg.com/media/FB2SHu-X0AcEiRj?format=jpg&name=240x240"/></li>
          <li><img alt="Image" src="https://pbs.twimg.com/media/FB2SHFbWEAEk6Ul?format=jpg&name=240x240"/></li>
          <li><img alt="Image" src="https://pbs.twimg.com/ext_tw_video_thumb/1449468665036951560/pu/img/T2NOP9OIAnURi7Lw?format=jpg&name=240x240"/></li>
          <li><img alt="Image" src="https://pbs.twimg.com/media/FB2MConWQAAg34U?format=jpg&name=240x240"/></li>
        </ul>
        <div class="trendForYou">
          <div class="title">
            <h2>Trands for you</h2>
            <span class="setting"><svg viewBox="0 0 24 24"><g><path d="M12 8.21c-2.09 0-3.79 1.7-3.79 3.79s1.7 3.79 3.79 3.79 3.79-1.7 3.79-3.79-1.7-3.79-3.79-3.79zm0 6.08c-1.262 0-2.29-1.026-2.29-2.29S10.74 9.71 12 9.71s2.29 1.026 2.29 2.29-1.028 2.29-2.29 2.29z"></path><path d="M12.36 22.375h-.722c-1.183 0-2.154-.888-2.262-2.064l-.014-.147c-.025-.287-.207-.533-.472-.644-.286-.12-.582-.065-.798.115l-.116.097c-.868.725-2.253.663-3.06-.14l-.51-.51c-.836-.84-.896-2.154-.14-3.06l.098-.118c.186-.222.23-.523.122-.787-.11-.272-.358-.454-.646-.48l-.15-.014c-1.18-.107-2.067-1.08-2.067-2.262v-.722c0-1.183.888-2.154 2.064-2.262l.156-.014c.285-.025.53-.207.642-.473.11-.27.065-.573-.12-.795l-.094-.116c-.757-.908-.698-2.223.137-3.06l.512-.512c.804-.804 2.188-.865 3.06-.14l.116.098c.218.184.528.23.79.122.27-.112.452-.358.477-.643l.014-.153c.107-1.18 1.08-2.066 2.262-2.066h.722c1.183 0 2.154.888 2.262 2.064l.014.156c.025.285.206.53.472.64.277.117.58.062.794-.117l.12-.102c.867-.723 2.254-.662 3.06.14l.51.512c.836.838.896 2.153.14 3.06l-.1.118c-.188.22-.234.522-.123.788.112.27.36.45.646.478l.152.014c1.18.107 2.067 1.08 2.067 2.262v.723c0 1.183-.888 2.154-2.064 2.262l-.155.014c-.284.024-.53.205-.64.47-.113.272-.067.574.117.795l.1.12c.756.905.696 2.22-.14 3.06l-.51.51c-.807.804-2.19.864-3.06.14l-.115-.096c-.217-.183-.53-.23-.79-.122-.273.114-.455.36-.48.646l-.014.15c-.107 1.173-1.08 2.06-2.262 2.06zm-3.773-4.42c.3 0 .593.06.87.175.79.328 1.324 1.054 1.4 1.896l.014.147c.037.4.367.7.77.7h.722c.4 0 .73-.3.768-.7l.014-.148c.076-.842.61-1.567 1.392-1.892.793-.33 1.696-.182 2.333.35l.113.094c.178.148.366.18.493.18.206 0 .4-.08.546-.227l.51-.51c.284-.284.305-.73.048-1.038l-.1-.12c-.542-.65-.677-1.54-.352-2.323.326-.79 1.052-1.32 1.894-1.397l.155-.014c.397-.037.7-.367.7-.77v-.722c0-.4-.303-.73-.702-.768l-.152-.014c-.846-.078-1.57-.61-1.895-1.393-.326-.788-.19-1.678.353-2.327l.1-.118c.257-.31.236-.756-.048-1.04l-.51-.51c-.146-.147-.34-.227-.546-.227-.127 0-.315.032-.492.18l-.12.1c-.634.528-1.55.67-2.322.354-.788-.327-1.32-1.052-1.397-1.896l-.014-.155c-.035-.397-.365-.7-.767-.7h-.723c-.4 0-.73.303-.768.702l-.014.152c-.076.843-.608 1.568-1.39 1.893-.787.326-1.693.183-2.33-.35l-.118-.096c-.18-.15-.368-.18-.495-.18-.206 0-.4.08-.546.226l-.512.51c-.282.284-.303.73-.046 1.038l.1.118c.54.653.677 1.544.352 2.325-.327.788-1.052 1.32-1.895 1.397l-.156.014c-.397.037-.7.367-.7.77v.722c0 .4.303.73.702.768l.15.014c.848.078 1.573.612 1.897 1.396.325.786.19 1.675-.353 2.325l-.096.115c-.26.31-.238.756.046 1.04l.51.51c.146.147.34.227.546.227.127 0 .315-.03.492-.18l.116-.096c.406-.336.923-.524 1.453-.524z"></path></g></svg></span>
          </div>
          <div class="body">
            <dl>
              <dt>
                <h3>레모네이드</h3>
                <span class="more"><svg viewBox="0 0 24 24"><g><circle cx="5" cy="12" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="19" cy="12" r="2"></circle></g></svg></span>
              </dt>
              <dd>3,409 Posts</dd>
            </dl>
            <dl>
              <dt>
                <h3>레모네이드</h3>
                <span class="more"><svg viewBox="0 0 24 24"><g><circle cx="5" cy="12" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="19" cy="12" r="2"></circle></g></svg></span>
              </dt>
              <dd>3,409 Posts</dd>
            </dl>
            <dl>
              <dt>
                <h3>레모네이드</h3>
                <span class="more"><svg viewBox="0 0 24 24"><g><circle cx="5" cy="12" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="19" cy="12" r="2"></circle></g></svg></span>
              </dt>
              <dd>3,409 Posts</dd>
            </dl>
            <dl>
              <dt>
                <h3>레모네이드</h3>
                <span class="more"><svg viewBox="0 0 24 24"><g><circle cx="5" cy="12" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="19" cy="12" r="2"></circle></g></svg></span>
              </dt>
              <dd>3,409 Posts</dd>
            </dl>
            <dl>
              <dt>
                <h3>레모네이드</h3>
                <span class="more"><svg viewBox="0 0 24 24"><g><circle cx="5" cy="12" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="19" cy="12" r="2"></circle></g></svg></span>
              </dt>
              <dd>3,409 Posts</dd>
            </dl>
            <div class="showMore">Show more</div>
          </div>
        </div>
        <nav class="footer">
          <router-link :to="{ name: 'community' }" class="">Terms of Service</router-link>
          <router-link :to="{ name: 'community' }" class="">Privacy Policy</router-link>
          <br>
          <router-link :to="{ name: 'community' }" class="">Cookie Policy</router-link>
          <router-link :to="{ name: 'community' }" class="">Ads info</router-link>
          <router-link :to="{ name: 'community' }" class="">More</router-link>
          <br>
          <p>© 2021 Apt With, Inc.</p>
        </nav>
      </div>
    </sidebar>
  </div>
</template>

<script>
import { lettersInfiniteGet, lettersPost2 } from '~/service'
import InfiniteLoading from 'vue-infinite-loading';
import 'vue-input-search/dist/vue-search.css'
import VueSearch from 'vue-input-search/dist/vue-search.common'
import { mapGetters } from 'vuex'
import $ from 'jquery';
import PostItem from '~/components/PostItem'
import EmojiPicker from 'vue-emoji-picker'
import UploadImages from 'vue-upload-drop-images'

export default {
  layout: 'layoutTwitter',
  components: { InfiniteLoading, VueSearch, PostItem, EmojiPicker, UploadImages },
  data() {
    return {
      posts: [],
      postsNew: [],
      contents: '',
      search: '',
      letter_thumbnail: [],
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    infiniteHandler ($state) {
      console.log('$state:', $state);
      let page = this.posts.length / 10 + 1;
      lettersInfiniteGet({ page: page }).then(response => {
        this.loadMore($state, response);
      });
    },
    loadMore ($state, response) {
      if (response.data.data.length) {
        console.log(response.data.data);
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
    },
    commentClick (post) {
      alert(1);
    },
    retweetClick (post) {
      alert(2);
    },
    likeClick (post) {
      alert(3);
    },
    shereClick (post) {
      alert(4);
    },
    uploadContent() {
      console.log('this.letter_thumbnail:', this.letter_thumbnail);
      lettersPost({
        user_id: this.user.id,
        animal_name: 'dog',
        contents: this.contents,
        letter_thumbnail: this.letter_thumbnail,
        letter_favorites_count: 1,
        letter_comments_count: 1,
      }).then(response => {
        if (response.status == 201) {
          this.postsNew.unshift(response.data.data);
          $('#community > main > .post:eq(0)').hide().addClass('new');
          $('#community > main > .post:eq(0)').fadeIn(3000);
          setTimeout(() => {
            $('#community > main > .post:eq(0)').removeClass('new');
          }, 3000);
        }
      })
    },
    insert(emoji) {
      this.contents += emoji + '  '
    },
    handleImages(files){
      this.letter_thumbnail = files;
    }
  },
}
</script>

<style lang="scss" scoped>
#community {
  display: flex;
  main {
    max-width: 600px;
    .title {
      background-color: #fff;
      border-bottom: 1px solid rgb(239, 243, 244);
      padding: 16px;

      h2 {
        font-size: 1.25rem;
        margin-bottom: 0px;
      }
    }
    .post-writer {
      border-bottom: 1px solid rgb(239, 243, 244);
      .container {
        display: flex;
        flex-direction: row;
        padding: 0px 16px;
        .con-left {
          width: 60px;
          padding-top: 16px;
          .avator {
            border-radius: 999px;
          }
        }
        .con-right {

        }
      }
    }
    .post {
      border-bottom: 1px solid rgb(239, 243, 244);
      &.new { background-color: #f7f9f9; }
    }
  }
  sidebar {
    width: 390px;
    .searchBar {
      position: fixed;
      display: flex;
      align-items: center;
      width: 390px;
      height: 57px;
      background-color: #fff;
      border-bottom: 1px solid rgb(239, 243, 244);
      padding: 0 16px;
      z-index: 100;
      .border {
        background-color: rgb(239, 243, 244);
        border-radius: 999px;
        padding: 10px 20px;
        svg { width: 20px; height: 20px; }
      }
    }
    .searchSizedBox {
      height: 57px;
      border: 1px solid red;
    }
    .container {
      z-index: 1;
      padding: 0px;
      .gallery {
        width: 288px;
        height: 162px;
        padding: 0px;
        border-radius: 16px;
        overflow: hidden;
        margin: 16px 16px 16px;

        li {
          float: left;
          list-style: none;
          width: 94px;
          height: 80px;
          overflow: hidden;
          margin: 0 2px 2px 0;

          img {

          }
        }
      }
      .trendForYou {
        background-color: rgb(247, 249, 249);
        border-radius: 16px;
        margin: 20px;
        padding: 20px;

        .title {
          display: flex;
          justify-content: space-between;
          align-content: center;
          margin-bottom: 25px;

          h2 {
            font-size: 20px;
            font-weight: 800;
            margin: 0px;
          }

          .setting {
            display: flex;
            cursor: pointer;

            svg {
              width: 20px;
              height: 20px;
            }

            margin-right: 10px;
          }
        }

        .body {
          dl {
            margin-bottom: 25px;

            dt {
              display: flex;
              justify-content: space-between;
              align-content: center;

              h3 {
                font-size: 16px;
                font-weight: 600;
                margin: 0px;
              }

              .more {
                display: flex;
                cursor: pointer;

                svg {
                  width: 20px;
                  height: 20px;
                }
              }
            }

            dd {
              font-size: 14px;
              color: #536471;
            }
          }

        }
      }
      nav.footer {
        padding: 0 32px;
        line-height: 22px;

        a, p {
          color: #536471;
          font-size: 13px;
          margin: 0 15px 0 0;
        }
      }
    }
  }

}

.emoji-container {
  position: relative;
  .emoji-invoker {
    svg {
      width: 20px;
      height: 20px;
    }
  }

  .emoji-picker {
    position: absolute;
    top: 30px;
    left: 0px;
    width: 320px;
    background-color: #fff;
    box-shadow: rgb(101 119 134 / 20%) 0px 0px 15px, rgb(101 119 134 / 15%) 0px 0px 3px 1px;
    border-radius: 16px;

    .emoji-search {
      padding: 10px;

      input {
        width: 100%;
        border: 1px solid rgb(207, 217, 222);
        padding: 10px 20px;
        border-radius: 999px;
      }
    }

    .emoji-contents {
      height: 350px;
      overflow-y: scroll;

      > div {
        padding: 10px;
        border-bottom: 1px solid #eff3f4;

        > div {
          width: 300px;
          overflow: hidden;

          > span {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
            float: left;
          }
        }
      }
    }
  }
}
.post-footer {
  display: flex;
  justify-content: space-between;
  .post-footer-right {
    .write {
      color: #fff;
      background-color: rgb(29, 155, 240);
      padding: 10px 20px;
      border-radius: 999px;
      cursor: pointer;
    }
  }
}
</style>
