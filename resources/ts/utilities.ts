import type {Replace} from 'type-fest';
import type {ComposerTranslation} from 'vue-i18n';

import {useMediaQuery} from '@vueuse/core';
import * as mdi from 'mdi-vue3';
import {match} from 'ts-pattern';
import * as simpleIcons from 'vue3-simple-icons';

export type Icons = typeof mdi & typeof simpleIcons;
export type IconShortName = Replace<keyof Icons, 'Icon', ''>;

export function getIconComponentName(name: IconShortName) {
  const iconName = `${name}Icon`;
  return mdi[iconName as keyof typeof mdi] ?? simpleIcons[iconName as keyof typeof simpleIcons];
}

export function useIsMobile() {
  return useMediaQuery('(max-width: 768px)');
}

export function capitalizeFirstLetter(string_: string, locale = navigator.language) {
  return string_.replace(/^\p{CWU}/u, (char) => char.toLocaleUpperCase(locale));
}

export function getLocalizedLabel(key: string, $t: ComposerTranslation) {
  return match(key)
    .with('first_name', () => $t('First Name'))
    .with('last_name', () => $t('Last Name'))
    .with('email', () => $t('Email'))
    .with('nickname', () => $t('Nickname'))
    .with('name', () => $t('Name'))
    .otherwise(() => key);
}
