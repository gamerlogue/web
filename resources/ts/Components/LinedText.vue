<script setup lang="ts">
import '@material/web/divider/divider.js';
</script>

<template>
  <div class="lined-text">
    <div>
      <md-divider/>
    </div>
    <slot></slot>
    <div>
      <md-divider/>
    </div>
  </div>
</template>

<style scoped lang="scss">
// Line before and after text (horizontal)
.lined-text {
  display: grid;
  grid-template-columns: 1fr max-content 1fr;
  column-gap: .75rem;

  & > div:has(> md-divider) {
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
</style>
