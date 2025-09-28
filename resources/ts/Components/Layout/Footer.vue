<script setup lang="ts">
import {FileDocumentOutlineIcon, GavelIcon} from 'mdi-vue3';
import {ref} from 'vue';
import {useI18n} from 'vue-i18n';
import LanguageSwitcher from '~/Components/LanguageSwitcher.vue';
import {useIsMobile} from '~/utilities.ts';

import '@material/web/button/outlined-button.js';
import '@material/web/button/text-button.js';
import '@material/web/dialog/dialog.js';
import '@material/web/iconbutton/icon-button.js';

const creditsDialogOpened = ref(false);
const {locale} = useI18n();

const isMobile = useIsMobile();
</script>

<template>
  <footer>
    <div>
      <span>
        {{ $t('Copyright © {initial_year} - {current_year}', { initial_year: '2019', current_year: new Date().getFullYear() }) }} Maicol07 -&nbsp;
      </span>
      <a href="" @click.prevent="creditsDialogOpened = true">{{ $t('Credits') }}</a>

      <md-dialog :open="creditsDialogOpened" @closed="creditsDialogOpened = false">
        <span slot="headline">{{ $t('Credits') }}</span>
        <div slot="content">
          <span>{{ $t('Developed by') }} Maicol07</span>
          -
          <a href="http://www.freepik.com">{{ $t('Logo symbol designed by') }} Freepik</a>
        </div>
        <div slot="actions">
          <md-text-button @click="creditsDialogOpened = false">
            {{ $t('Close') }}
          </md-text-button>
        </div>
      </md-dialog>
    </div>
    <div v-if="!isMobile">
      <LanguageSwitcher/>
      <md-text-button :href="`https://docs.maicol07.it/${locale}/legal/privacy-cookie`" target="_blank">
        {{ $t('Privacy & Cookie') }}
        <md-icon slot="icon">
          <FileDocumentOutlineIcon/>
        </md-icon>
      </md-text-button>
      <md-text-button :href="`https://docs.maicol07.it/${locale}/legal/terms`" target="_blank">
        {{ $t('Terms') }}
        <md-icon slot="icon">
          <GavelIcon/>
        </md-icon>
      </md-text-button>
    </div>
  </footer>
</template>

<style scoped lang="scss">
@use 'include-media/dist/include-media' as im;

footer {
  position: sticky;
  bottom: 0;

  display: flex;
  align-items: center;

  width: 100%;
  padding-top: 10px;
  padding-bottom: 10px;
  border-top: var(--md-sys-color-outline-variant, #cac4d0) solid 1px;

  color: var(--md-sys-color-on-background);

  background-color: var(--md-sys-color-background, white);

  @include im.media('<tablet') {
    justify-content: center;
  }

  :not(md-dialog) md-text-button {
    --md-text-button-container-height: 30px
  }

  & > div {
    display: flex;
    padding-left: 10px;

    &:first-child {
      span:last-child {
        @include im.media('<tablet') {
          display: none;
        }
      }

      a {
        cursor: pointer;
      }
    }

    &:last-child:not(:first-child) {
      justify-content: flex-end;
      padding-right: 10px;

      @include im.media('<tablet') {
        display: none;
      }

      md-outlined-select {
        margin-right: 8px;
      }
    }

    @include im.media('>=tablet') {
      flex: 1;
    }
  }
}
</style>
