<script setup lang="ts">
import '@material/web/labs/card/filled-card.js';
import '@maicol07/material-web-additions/avatar/avatar.js';

const {titleElement = 'h2'} = defineProps<{
  titleElement?: 'h1' | 'h2' | 'h3' | 'h4' | 'h5' | 'h6' | 'span' | 'strong';
}>();
</script>

<template>
  <md-filled-card>
    <div class="header">
      <md-avatar v-if="$slots.icon">
        <slot name="icon"></slot>
      </md-avatar>

      <component :is="titleElement"><slot name="title"></slot></component>
    </div>

    <slot></slot>

    <div class="actions">
      <slot name="actions"></slot>
    </div>
  </md-filled-card>
</template>

<style scoped lang="scss">
md-filled-card {
  padding: 16px;

  .header {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-bottom: 12px;

    md-avatar {
      --md-avatar-container-color: var(--md-sys-color-primary);
      --md-avatar-text-color: var(--md-sys-color-on-primary);
      --md-avatar-size: 40px;
    }
  }

  .actions {
    display: flex;
    flex-grow: 1;
    align-items: end;
    justify-content: flex-end;

    margin-top: 6px;

    md-text-button {
      display: flex;
      gap: 4px;
      align-items: center;

      height: fit-content;

      font-size: var(--md-sys-typescale-label-large-size);
      font-weight: var(--md-sys-typescale-label-large-weight);
      line-height: var(--md-sys-typescale-label-large-line-height);
      color: var(--md-sys-color-primary);
    }
  }

  &.danger {
    --md-filled-card-container-color: var(--md-sys-color-error-container);
    color: var(--md-sys-color-on-error-container);

    .header {
      md-avatar {
        --md-avatar-container-color: var(--md-sys-color-error);
        --md-avatar-text-color: var(--md-sys-color-on-error);
      }
    }

    .actions {
      --md-text-button-label-text-color: var(--md-sys-color-on-error-container);
      --md-text-button-focus-label-text-color: var(--md-sys-color-on-error-container);
      --md-text-button-hover-label-text-color: var(--md-sys-color-on-error-container);
      --md-text-button-pressed-label-text-color: var(--md-sys-color-on-error-container);
      --md-text-button-icon-color: var(--md-sys-color-on-error-container);
      --md-text-button-focus-icon-color: var(--md-sys-color-on-error-container);
      --md-text-button-hover-icon-color: var(--md-sys-color-on-error-container);
      --md-text-button-pressed-icon-color: var(--md-sys-color-on-error-container);
      --md-text-button-hover-state-layer-color: var(--md-sys-color-on-error-container);
      --md-text-button-pressed-state-layer-color: var(--md-sys-color-on-error-container);
    }
  }
}
</style>
