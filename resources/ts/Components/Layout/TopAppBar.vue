<script setup lang="ts">
/* eslint-disable vue-a11y/aria-props */
import type {PageComponentProps} from '~/typings/inertia.js';
import {usePage} from '@inertiajs/vue3';
import {BullhornOutlineIcon, MenuIcon, MenuOpenIcon} from 'mdi-vue3';
import {computed, ref} from 'vue';
import Logo from '~/Components/Logo.vue';
import UserAccountImage from '~/Components/UserAccountImage.vue';
import UserPopout from '~/Components/UserPopout.vue';
// import {dashboard} from '~/routes';
import '@material/web/focus/md-focus-ring.js';
import '@material/web/icon/icon.js';
import '@material/web/iconbutton/icon-button.js';

defineProps<{menuButtonSelected: boolean}>();
defineEmits<{
  menuButtonToggle: [];
}>();

const page = usePage<PageComponentProps>();
const user = computed(() => page.props.user);

const userPopoutOpen = ref(false);
</script>

<template>
  <md-small-top-app-bar>
    <md-icon-button
      slot="start"
      toggle
      class="menu-button"
      aria-label-selected="open navigation menu"
      aria-label="close navigation menu"
      :aria-expanded="menuButtonSelected ? 'true' : 'false'"
      :title="menuButtonSelected ? 'Close' : 'Open' + 'navigation menu'"
      :selected="menuButtonSelected"
      @input="$emit('menuButtonToggle')"
    >
      <md-icon slot="selected">
        <MenuOpenIcon/>
      </md-icon>
      <md-icon>
        <MenuIcon/>
      </md-icon>
    </md-icon-button>
<!--    <div>-->
<!--      <Logo :href="dashboard()"/>-->
<!--    </div>-->

    <div slot="end">
      <md-icon-button data-target="ln-embed" aria-label="Updates menu">
        <md-icon>
          <BullhornOutlineIcon/>
        </md-icon>
      </md-icon-button>
      <md-icon-button id="userpopout-anchor" class="avatar" aria-label="User menu" @click="userPopoutOpen = !userPopoutOpen">
        <md-icon>
          <UserAccountImage :user="user"/>
        </md-icon>
      </md-icon-button>
      <UserPopout id="userpopout-menu" anchor="userpopout-anchor" :open="userPopoutOpen" @close="userPopoutOpen = false"/>
    </div>
  </md-small-top-app-bar>
</template>

<style scoped lang="scss">
md-small-top-app-bar {
  div[slot="end"] {
    position: relative;
  }
}
</style>
