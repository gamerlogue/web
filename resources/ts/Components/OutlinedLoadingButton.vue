<script setup lang="ts">
import '@material/web/button/outlined-button.js';
import '@material/web/progress/circular-progress.js';

const {loading = false} = defineProps<{loading?: boolean}>();
</script>

<template>
  <md-outlined-button :disabled="loading">
    <md-circular-progress v-if="loading" indeterminate/>
    <slot v-if="!loading"></slot>
  </md-outlined-button>
</template>

<style scoped lang="scss">
md-outlined-button:has(> md-circular-progress:not([slot="icon"])) {
  height: 40px;

  md-circular-progress {
    --md-circular-progress-size: 24px;
    --md-circular-progress-active-indicator-color: var(--_label-text-color);
  }

  &:disabled md-circular-progress {
    --md-circular-progress-active-indicator-color: var(--_disabled-label-text-color);
  }
}
</style>
