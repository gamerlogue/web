<script setup lang="ts">
import type {PageComponentProps} from '~/typings/inertia.js';
import {router, usePage} from '@inertiajs/vue3';
import {CloseIcon, LogoutIcon} from 'mdi-vue3';
import {computed} from 'vue';
import UserAccountImage from '~/Components/UserAccountImage.vue';
import {logout} from '~/routes';
import '@material/web/menu/menu.js';
import '@material/web/iconbutton/icon-button.js';
import '@material/web/button/outlined-button.js';

defineProps<{
  id: string;
  anchor: string;
  open: boolean;
}>();

defineEmits<{
  close: [];
}>();

const page = usePage<PageComponentProps>();
const user = computed(() => page.props.user);
</script>

<template>
  <md-menu :id="id" :anchor="anchor" :open="open">
    <div class="contents">
      <div class="header">
        <span class="email">{{ user.email }}</span>
        <md-icon-button aria-label="Close user menu" @click="$emit('close')">
          <md-icon>
            <CloseIcon/>
          </md-icon>
        </md-icon-button>
      </div>
      <div class="account-image-container">
        <UserAccountImage :user="user" size="large"/>
      </div>
      <div class="account-name">
        <span>{{ $t('Hi {name}', {name: user.name ?? user.nickname}) }}</span>
      </div>
      <!-- Logout button -->
      <md-outlined-button @click="router.visit(logout().url, {method: 'post'})">
        <md-icon slot="icon">
          <LogoutIcon/>
        </md-icon>
        {{ $t('Logout') }}
      </md-outlined-button>
    </div>
  </md-menu>
</template>

<style scoped lang="scss">
md-menu {
  --md-menu-container-shape: var(--md-sys-shape-corner-large);

  min-width: 350px;

  .contents {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: center;

    padding-inline: 8px;

    .header {
      display: flex;
      align-items: center;

      // noinspection CssInvalidPropertyValue
      width: -webkit-fill-available;

      // noinspection CssInvalidPropertyValue
      width: -moz-available;

      > span.email {
        display: flex;
        flex: 1;
        align-self: center;
        justify-content: center;
      }
    }
  }
}
</style>
