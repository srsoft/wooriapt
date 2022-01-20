<template>
  <div class="twitter-layout">
    <header>
      <div v-sticky>
        <navbar-twitter />
      </div>
    </header>
    <main>
      <child />
    </main>
  </div>
</template>

<script>
import NavbarTwitter from '~/components/NavbarTwitter'

export default {
  name: 'MainLayout',

  components: {
    NavbarTwitter
  }
}
</script>
<style lang="scss">
.twitter-layout {
  display: flex;
  width: 1290px;
  justify-content: space-between;
  background-color: #fff;
  margin: auto;
  header {
    width: 300px;
    .navbar {
      padding: 0px;
    }
  }
  main {
    flex: 1;
    border-right: 1px solid rgb(239, 243, 244);
  }
}
</style>
