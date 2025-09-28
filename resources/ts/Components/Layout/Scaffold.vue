<script setup lang="ts">
import {Modal} from 'inertia-modal';
import {ref} from 'vue';
import FlashSnackbar from '~/Components/FlashSnackbar.vue';
import Footer from '~/Components/Layout/Footer.vue';
import NavigationDrawer from '~/Components/Layout/NavigationDrawer.vue';
import TopAppBar from '~/Components/Layout/TopAppBar.vue';
import '@maicol07/material-web-additions/avatar/avatar.js';
import '@maicol07/material-web-additions/top-app-bar/small-top-app-bar.js';
import '@material/web/iconbutton/icon-button.js';

defineOptions({
  inheritAttrs: false
});

const drawerOpen = ref(false);
</script>

<template>
  <TopAppBar :menu-button-selected="drawerOpen" @menu-button-toggle="drawerOpen = !drawerOpen"/>
  <div class="main">
    <NavigationDrawer v-model="drawerOpen" @navigation-drawer-changed="drawerOpen = $event"/>

    <main class="authenticated">
      <slot></slot>
    </main>
  </div>
  <Footer/>
  <FlashSnackbar/>
  <Modal/>
</template>

<style scoped lang="scss">
.main {
  display: flex;
  flex: 1;
  margin-top: 8px;
}

.avatar {
  --md-icon-button-container-color: var(--md-sys-color-secondary-container);
  --md-icon-button-color: var(--md-sys-color-on-secondary-container);
}
</style>
