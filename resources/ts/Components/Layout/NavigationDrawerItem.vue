<script setup lang="ts">
import {usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
import '@material/web/list/list-item.js';

const {href} = defineProps<{
  href: string | {url: string; method: string};
}>();

const page = usePage();

const realUrl = computed(() => typeof href === 'object' ? href.url : href);
const isCurrentRoute = computed(() => {
  return page.url === realUrl.value;
});
</script>

<template>
  <md-list-item v-visit type="link" :href="realUrl" :data-active="isCurrentRoute" role="menuitem">
    <slot slot="start" name="start"/>
    <slot></slot>
    <slot slot="end" name="end"/>
  </md-list-item>
</template>

<style scoped lang="scss">
md-list-item {
  border-radius: var(--md-sys-shape-corner-full, 0);
  transition: background-color 0.2s ease-in-out;

  &[data-active="true"] {
    color: var(--md-sys-color-on-secondary-container, #fff);
    background-color: var(--md-sys-color-secondary-container, #6200ee);
  }
}
</style>
