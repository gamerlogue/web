<script setup lang="ts">
import type {Select} from '@material/web/select/internal/select';
import type {TCountryCodes} from 'vue-circle-flags/dist/defs/country.js';

import {router} from '@inertiajs/vue3';
import {match} from 'ts-pattern';
import {
  capitalize,
  computed,
  onMounted,
  useTemplateRef
} from 'vue';
import {useI18n} from 'vue-i18n';
import {setLocale as setLocaleRoute} from '~/routes';
import '@material/web/select/outlined-select.js';
import '@material/web/select/select-option.js';

const {locale} = useI18n();
const select = useTemplateRef<Select>('select');

const displayLanguage = computed(() => new Intl.DisplayNames(locale.value, {type: 'language'}));

onMounted(() => {
  const css = new CSSStyleSheet();
  // language=CSS
  css.replaceSync('.field, .select { height: inherit; }');
  select.value?.shadowRoot?.adoptedStyleSheets?.push(css);
});

function setLocale() {
  document.documentElement.lang = locale.value;
  router.visit(setLocaleRoute().url, {method: setLocaleRoute().method, data: {locale: locale.value}});
}

function getCountryFlag(code: string) {
  return match(code)
    .returnType<TCountryCodes>()
    .with('en', () => 'gb')
    .otherwise(() => code as TCountryCodes);
}
</script>

<template>
  <md-outlined-select id="lang-switcher" ref="select" v-model="$i18n.locale" class="slide-fade-in animation-delay-3" @change="setLocale">
    <md-select-option v-for="localeCode in $i18n.availableLocales" :key="localeCode" :value="localeCode">
      <md-icon slot="start">
        <CircleFlags :country="getCountryFlag(localeCode)"/>
      </md-icon>
      <span slot="headline">{{ capitalize(displayLanguage.of(localeCode) ?? '') }}</span>
    </md-select-option>
  </md-outlined-select>
</template>

<style scoped lang="scss">
.circle-flags {
  height: 100%;
}

md-outlined-select {
  --md-outlined-field-top-space: 5px;
  --md-outlined-field-bottom-space: 5px;

  height: 34px;

  md-select-option {
    svg {
      width: 36px;
    }
  }
}
</style>
