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
  grid-column-gap: .75rem;
  grid-template-columns: 1fr max-content 1fr;

  & > div:has(> md-divider) {
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
</style>
