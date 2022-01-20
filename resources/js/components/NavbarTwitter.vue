<template>
  <nav class="navbar">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        <em>{{ appName }}</em> 롯데캐슬 베네치아
      </router-link>

      <router-link :to="{ name: 'community' }" :class="`community ${$route.name == 'community' ? 'on' : ''}`">
        <span>
          <i class="icon"/>
          <span>소통</span>
        </span>
      </router-link>
      <router-link :to="{ name: 'notifications' }" :class="`notifications ${$route.name == 'notifications' ? 'on' : ''}`">
        <span>
          <i class="badge">2</i>
          <i class="icon"/>
          <span>알림</span>
        </span>
      </router-link>
      <router-link :to="{ name: 'messages' }" :class="`messages ${$route.name == 'messages' ? 'on' : ''}`">
        <span>
          <i class="icon"/>
          <span>메시지</span>
        </span>
      </router-link>
      <!--
      <router-link :to="{ name: 'lettersInfinite' }" :class="`lettersInfinite ${$route.name == 'lettersInfinite' ? 'on' : ''}`">
        <span>
          <svg viewBox="0 0 24 24" aria-hidden="true"><g><path d="M21 7.337h-3.93l.372-4.272c.036-.412-.27-.775-.682-.812-.417-.03-.776.27-.812.683l-.383 4.4h-6.32l.37-4.27c.037-.413-.27-.776-.68-.813-.42-.03-.777.27-.813.683l-.382 4.4H3.782c-.414 0-.75.337-.75.75s.336.75.75.75H7.61l-.55 6.327H3c-.414 0-.75.336-.75.75s.336.75.75.75h3.93l-.372 4.272c-.036.412.27.775.682.812l.066.003c.385 0 .712-.295.746-.686l.383-4.4h6.32l-.37 4.27c-.036.413.27.776.682.813l.066.003c.385 0 .712-.295.746-.686l.382-4.4h3.957c.413 0 .75-.337.75-.75s-.337-.75-.75-.75H16.39l.55-6.327H21c.414 0 .75-.336.75-.75s-.336-.75-.75-.75zm-6.115 7.826h-6.32l.55-6.326h6.32l-.55 6.326z"></path></g></svg>
          <span>민원</span>
        </span>
      </router-link>
      <router-link :to="{ name: 'lettersInfinite' }" class="":class="`community ${$route.name == 'community' ? 'on' : ''}`">
        <span>
          <svg viewBox="0 0 24 24" aria-hidden="true"><g><path d="M22.46 7.57L12.357 2.115c-.223-.12-.49-.12-.713 0L1.543 7.57c-.364.197-.5.652-.303 1.017.135.25.394.393.66.393.12 0 .243-.03.356-.09l.815-.44L4.7 19.963c.214 1.215 1.308 2.062 2.658 2.062h9.282c1.352 0 2.445-.848 2.663-2.087l1.626-11.49.818.442c.364.193.82.06 1.017-.304.196-.363.06-.818-.304-1.016zm-4.638 12.133c-.107.606-.703.822-1.18.822H7.36c-.48 0-1.075-.216-1.178-.798L4.48 7.69 12 3.628l7.522 4.06-1.7 12.015z"></path><path d="M8.22 12.184c0 2.084 1.695 3.78 3.78 3.78s3.78-1.696 3.78-3.78-1.695-3.78-3.78-3.78-3.78 1.696-3.78 3.78zm6.06 0c0 1.258-1.022 2.28-2.28 2.28s-2.28-1.022-2.28-2.28 1.022-2.28 2.28-2.28 2.28 1.022 2.28 2.28z"></path></g></svg>
          <span>방문차량</span>
        </span>
      </router-link>
      <router-link :to="{ name: 'lettersInfinite' }" :class="`community ${$route.name == 'community' ? 'on' : ''}`">
        <span>
          <svg viewBox="0 0 24 24" aria-hidden="true"><g><path d="M22.46 7.57L12.357 2.115c-.223-.12-.49-.12-.713 0L1.543 7.57c-.364.197-.5.652-.303 1.017.135.25.394.393.66.393.12 0 .243-.03.356-.09l.815-.44L4.7 19.963c.214 1.215 1.308 2.062 2.658 2.062h9.282c1.352 0 2.445-.848 2.663-2.087l1.626-11.49.818.442c.364.193.82.06 1.017-.304.196-.363.06-.818-.304-1.016zm-4.638 12.133c-.107.606-.703.822-1.18.822H7.36c-.48 0-1.075-.216-1.178-.798L4.48 7.69 12 3.628l7.522 4.06-1.7 12.015z"></path><path d="M8.22 12.184c0 2.084 1.695 3.78 3.78 3.78s3.78-1.696 3.78-3.78-1.695-3.78-3.78-3.78-3.78 1.696-3.78 3.78zm6.06 0c0 1.258-1.022 2.28-2.28 2.28s-2.28-1.022-2.28-2.28 1.022-2.28 2.28-2.28 2.28 1.022 2.28 2.28z"></path></g></svg>
          <span>택배방문</span>
        </span>
      </router-link>
      <router-link :to="{ name: 'lettersInfinite' }" :class="`community ${$route.name == 'community' ? 'on' : ''}`">
        <span>
          <svg viewBox="0 0 24 24" aria-hidden="true"><g><path d="M22.46 7.57L12.357 2.115c-.223-.12-.49-.12-.713 0L1.543 7.57c-.364.197-.5.652-.303 1.017.135.25.394.393.66.393.12 0 .243-.03.356-.09l.815-.44L4.7 19.963c.214 1.215 1.308 2.062 2.658 2.062h9.282c1.352 0 2.445-.848 2.663-2.087l1.626-11.49.818.442c.364.193.82.06 1.017-.304.196-.363.06-.818-.304-1.016zm-4.638 12.133c-.107.606-.703.822-1.18.822H7.36c-.48 0-1.075-.216-1.178-.798L4.48 7.69 12 3.628l7.522 4.06-1.7 12.015z"></path><path d="M8.22 12.184c0 2.084 1.695 3.78 3.78 3.78s3.78-1.696 3.78-3.78-1.695-3.78-3.78-3.78-3.78 1.696-3.78 3.78zm6.06 0c0 1.258-1.022 2.28-2.28 2.28s-2.28-1.022-2.28-2.28 1.022-2.28 2.28-2.28 2.28 1.022 2.28 2.28z"></path></g></svg>
          <span>나눔마켓</span>
        </span>
      </router-link>
      -->
      <router-link :to="{ path: '/' + user.name }" :class="`profile ${$route.name == 'profile' ? 'on' : ''}`">
        <span>
          <i class="icon"/>
          <span>프로필</span>
        </span>
      </router-link>

      <span class="comunityWrite">소통쓰기</span>

    </div>
    <div id="navbar" class="navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <!-- Authenticated -->
        <li v-if="user" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark"
             href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
          >
            <img :src="user.photo_url" class="rounded-circle profile-photo me-1">
            {{ user.name }}
          </a>
          <div class="dropdown-menu">
            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
              <fa icon="cog" fixed-width />
              {{ $t('settings') }}
            </router-link>

            <div class="dropdown-divider" />
            <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
              <fa icon="sign-out-alt" fixed-width />
              {{ $t('logout') }}
            </a>
          </div>
        </li>
        <!-- Guest -->
        <template v-else>
          <li class="nav-item">
            <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
              {{ $t('login') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
              {{ $t('register') }}
            </router-link>
          </li>
        </template>
      </ul>
    </div>

  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style lang="scss" scoped>
nav.navbar {
  height: 100vh;
  align-content: space-between;
  box-shadow: none;
  border-right: 1px solid rgb(239, 243, 244);
  .navbar-brand {
    padding: 10px 15px;
    em { padding: 0px; color: rgb(29, 155, 240); font-style: normal }
  }
  a {
    width: 100%; color: #0f1419;
    text-decoration: none;
    > span {
      position: relative;
      display: inline-flex;
      align-items: center;
      border-radius: 9999px;
      padding: 10px 25px 10px 15px;
      > i.badge {
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 6px;
        left: 29px;
        width: 18px;
        height: 18px;
        border: 1px solid #fff;
        background-color: #1d9bf0;
        font-style: normal;
        border-radius: 999px;
        font-weight: normal;
      }
      > i.icon {
        width: 30px;
        height: 30px;
        margin-right: 20px;
        background-repeat: no-repeat;
      }
      > svg {
        width: 30px;
        height: 30px;
        margin-right: 20px;
      }
      > span {
        font-size: 18px;
        font-weight: 500;
      }
    }
    &:hover {
      > span {
        background-color: rgb(15, 20, 25, 0.1);
      }
    }
    &.on {
      > span {
        > span {
          font-weight: 800;
        }
      }
      &.community > span > i.icon {
        background-image: url('/storage/icons/nav-community-on.svg');
      }
      &.notifications > span > i.icon {
        background-image: url('/storage/icons/nav-notifications-on.svg');
      }
      &.messages > span > i.icon {
        background-image: url('/storage/icons/nav-messages-on.svg');
      }
      &.profile > span > i.icon {
        background-image: url('/storage/icons/nav-profile-on.svg');
      }
    }
    &.community > span > i.icon {
      background-image: url('/storage/icons/nav-community.svg');
    }
    &.notifications > span > i.icon {
      background-image: url('/storage/icons/nav-notifications.svg');
    }
    &.messages > span > i.icon {
      background-image: url('/storage/icons/nav-messages.svg');
    }
    &.profile > span > i.icon {
      background-image: url('/storage/icons/nav-profile.svg');
    }
  }
  .comunityWrite {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    width: 100%;
    max-width: 225px;
    height: 52px;
    color: #fff;
    background-color: rgb(29, 155, 240);
    margin-top: 10px;
    transition-duration: 0.2s;
    cursor: pointer;
    &:hover {
      background-color: rgb(26, 140, 216);
    }
  }
}
.container {
  flex-direction: column;
  text-align: left;
  align-items: flex-start;
  a { display: block; }
}
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
