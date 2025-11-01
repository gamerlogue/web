<script setup lang="ts">
import {router} from '@inertiajs/vue3';
import {AccountCircleOutlineIcon, FileDocumentOutlineIcon, GavelIcon, LockOutlineIcon, MenuOpenIcon, ViewDashboardOutlineIcon} from 'mdi-vue3';
import {watch} from 'vue';
import {useI18n} from 'vue-i18n';
import LanguageSwitcher from '~/Components/LanguageSwitcher.vue';
import NavigationDrawerItem from '~/Components/Layout/NavigationDrawerItem.vue';
import {useIsMobile} from '~/utilities.ts';
import '@material/web/labs/navigationdrawer/navigation-drawer.js';
import '@material/web/labs/navigationdrawer/navigation-drawer-modal.js';
import '@material/web/icon/icon.js';

const emit = defineEmits<{
  navigationDrawerChanged: [boolean];
}>();
const open = defineModel<boolean>();

const isMobile = useIsMobile();
watch(isMobile, () => {
  emit('navigationDrawerChanged', !isMobile.value);
}, {immediate: true});

const {locale} = useI18n();

router.on('finish', () => {
  // Close the navigation drawer when a link is clicked
  if (isMobile.value) {
    open.value = false;
  }
});
</script>

<template>
  <component :is="!isMobile ? 'md-navigation-drawer' : 'md-navigation-drawer-modal'" :opened="open" @navigation-drawer-changed="$emit('navigationDrawerChanged', $event.detail.opened)">
    <div>
      <md-icon-button v-if="isMobile" aria-label="Close navigation menu" @click="$emit('navigationDrawerChanged', false)">
        <md-icon>
          <MenuOpenIcon/>
        </md-icon>
      </md-icon-button>
      <md-list v-auto-animate aria-label="List of pages" role="menubar" class="nav slide-fade-in">
<!--        <NavigationDrawerItem :href="dashboard()">-->
<!--          <md-icon slot="start">-->
<!--            <ViewDashboardOutlineIcon/>-->
<!--          </md-icon>-->
<!--          {{ $t('Dashboard') }}-->
<!--        </NavigationDrawerItem>-->
<!--        <NavigationDrawerItem :href="personalInfo()">-->
<!--          <md-icon slot="start">-->
<!--            <AccountCircleOutlineIcon/>-->
<!--          </md-icon>-->
<!--          {{ $t('Personal info') }}-->
<!--        </NavigationDrawerItem>-->
<!--        <NavigationDrawerItem :href="security.show()">-->
<!--          <md-icon slot="start">-->
<!--            <LockOutlineIcon/>-->
<!--          </md-icon>-->
<!--          {{ $t('Security') }}-->
<!--        </NavigationDrawerItem>-->
        <!--        <template v-for="link in links" :key="link.href"> -->
        <!--          <DrawerItem :href="link.href" @click="isMobile() && (drawerOpen = false)">{{ link.title }}</DrawerItem> -->
        <!--        </template> -->
      </md-list>
      <div v-if="isMobile" class="drawer-footer">
        <md-divider/>
        <LanguageSwitcher/>
        <md-text-button :href="`https://docs.maicol07.it/${locale}/legal/privacy-cookie`" target="_blank">
          {{ $t('Privacy & Cookie') }}
          <md-icon slot="icon">
            <FileDocumentOutlineIcon/>
          </md-icon>
        </md-text-button>
        <md-text-button :href="`https://docs.maicol07.it/${locale}/legal/privacy-cookie`" target="_blank">
          {{ $t('Terms') }}
          <md-icon slot="icon">
            <GavelIcon/>
          </md-icon>
        </md-text-button>
      </div>
    </div>
    <!--    </div> -->
  </component>
</template>

<style scoped lang="scss">
md-navigation-drawer, md-navigation-drawer-modal {
  --md-navigation-drawer-container-color: transparent;
  --md-navigation-drawer-modal-scrim-color: black;

  display: flex;
  flex-direction: column;

  md-divider {
    margin: 16px;
  }

  &:is(md-navigation-drawer) {
    padding: 12px;
  }

  &:is(md-navigation-drawer-modal) {
    --md-navigation-drawer-modal-container-color: var(--md-sys-color-background);
    z-index: 2;

    > div {
      padding: 12px;
      display: flex;
      flex-direction: column;
    }

    .drawer-footer {
      justify-content: space-evenly;
      display: flex;
      flex-wrap: wrap;
    }
  }
}
</style>
