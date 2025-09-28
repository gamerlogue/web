<script setup lang="ts">
import type {PageComponentProps} from '~/typings/inertia';
import {usePage} from '@inertiajs/vue3';
import {match} from 'ts-pattern';
import {computed, ref, watch} from 'vue';
import {useI18n} from 'vue-i18n';
import '@maicol07/material-web-additions/snackbar/snackbar.js';

const page = usePage<PageComponentProps>();
const {t: $t} = useI18n();

const statusSnackbarOpen = ref(false);
const persistent = ref(false);
const multiline = ref(false);

// Message overrides
const message = computed(() => match(page.props.flash?.status)
  .returnType<string | null>()
  .with('profile-information-updated', () => $t('Your profile has been updated successfully!'))
  .with('password-updated', () => $t('Your password has been updated successfully!'))
  .with('two-factor-authentication-disabled', () => $t('Two-factor authentication has been disabled.'))
  .otherwise(() => page.props.flash?.status)
);

const ignoredFlashStatuses = [
  'two-factor-authentication-enabled',
  'two-factor-authentication-confirmed',
  'password-confirmed'
];

watch(page, () => {
  statusSnackbarOpen.value = false; // This is needed to reset the snackbar state when the page changes and let it re-open if needed.
  statusSnackbarOpen.value = typeof page.props.flash?.status === 'string' && !ignoredFlashStatuses.includes(page.props.flash?.status);
  persistent.value = page.props.flash?.status_persistent === true;
  multiline.value = page.props.flash?.status_multiline === true;
}, {immediate: true});
</script>

<template>
  <md-snackbar
    fixed
    :open="statusSnackbarOpen"
    :action-text="persistent ? $t('OK') : undefined"
    :timeout="persistent ? 0 : 5000"
    :two-lines="multiline || undefined"
    @closed="statusSnackbarOpen = false"
  >
    {{ message }}
  </md-snackbar>
</template>
