<script setup lang="ts">
import {Gravatar} from '@sauromates/vue-gravatar';
import {AccountCircleOutlineIcon} from 'mdi-vue3';
import {match} from 'ts-pattern';
import {computed} from 'vue';

const {size} = defineProps<{
  user: App.Models.User;
  size?: 'xsmall' | 'small' | 'large' | 'xlarge';
}>();

const sizeNumber = computed(() => {
  return match(size)
    .with('xsmall', () => 40)
    .with('small', () => 80)
    .with('large', () => 120)
    .with('xlarge', () => 160)
    .otherwise(() => 80);
});
</script>

<template>
  <AccountCircleOutlineIcon
    v-if="user.picture === null"
    :class="{
      xsmall: size === 'xsmall',
      small: size === 'small',
      large: size === 'large',
      xlarge: size === 'xlarge',
    }"
  />
  <Gravatar
    v-else-if="user.picture === 'gravatar'"
    :email="user.email as typeof Gravatar['email']"
    alt="User's avatar from Gravatar service"
    default="mp"
    :size="sizeNumber < 80 ? 80 : sizeNumber"
    rating="g"
    :class="{
      xsmall: size === 'xsmall',
      small: size === 'small',
      large: size === 'large',
      xlarge: size === 'xlarge',
    }"
  />
  <img
    v-else
    :src="user.picture"
    :alt="user.name"
    :class="{
      xsmall: size === 'xsmall',
      small: size === 'small',
      large: size === 'large',
      xlarge: size === 'xlarge',
    }"
    loading="lazy"
  />
</template>

<style scoped lang="scss">
// eslint-disable-next-line vue-scoped-css/no-unused-selector
img, svg {
  border-radius: 50%;

  &.xsmall {
    width: 40px;
    height: 40px;
  }

  &.small {
    width: 80px;
    height: 80px;
  }

  &.large {
    width: 120px;
    height: 120px;
  }

  &.xlarge {
    width: 160px;
    height: 160px;
  }
}
</style>
