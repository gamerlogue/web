<script setup lang="ts">
import type {InertiaLinkProps} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';

defineProps<{
  href: InertiaLinkProps['href'];
  large?: boolean;
}>();
</script>

<template>
  <Link class="logo-container" :class="{large}" :href="href">
    <img src="@images/Logo.svg" alt="Maicol07"/>
    <span>Maicol07</span>
  </Link>
</template>

<style scoped lang="scss">
span {
  font-family: Anta, sans-serif;
  font-size: var(--md-sys-typescale-headline-medium-size);
  font-weight: var(--md-sys-typescale-headline-medium-weight);
  line-height: var(--md-sys-typescale-headline-medium-line-height);
  color: var(--md-sys-color-secondary, #1a237e);
  text-transform: uppercase;
  letter-spacing: 1.5px;
}

img {
  height: 33px;
}

.logo-container {
  display: flex;
  gap: .5rem;
  align-items: center;

  width: fit-content;

  text-decoration: none;

  &.large {
    span {
      font-size: var(--md-sys-typescale-display-small-size);
      font-weight: var(--md-sys-typescale-display-small-weight);
      line-height: var(--md-sys-typescale-display-small-line-height);
    }

    img {
      height: 55px;
    }
  }
}
</style>
