import type {DefineComponent, DirectiveBinding, VNode} from 'vue';

import {autoAnimatePlugin} from '@formkit/auto-animate/vue';
import {createInertiaApp, Head, Link, router} from '@inertiajs/vue3';
import messages from '@intlify/unplugin-vue-i18n/messages';
import axios from 'axios';
import {modal} from 'inertia-modal';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {createApp, h} from 'vue';
import CircleFlags from 'vue-circle-flags';
import {createI18n} from 'vue-i18n';
import Scaffold from '~/Components/Layout/Scaffold.vue';

import.meta.glob([
  '../images/favicon/**'
]);

// Fix empty messages
for (const lang in messages) {
  if (Object.hasOwn(messages, lang)) {
    for (const key in messages[lang]) {
      if (Object.hasOwn(messages, lang)) {
        const translation = messages[lang][key];
        // eslint-disable-next-line ts/no-unsafe-member-access
        if (translation.body?.static === '') {
          messages[lang][key] = messages.en[key];
        }
      }
    }
  }
}

const i18n = createI18n({
  legacy: false,
  locale: document.documentElement.lang,
  fallbackLocale: 'en',
  messages,
  fallbackWarn: false,
  missingWarn: false
});

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

void createInertiaApp({
  resolve: async (name) => {
    const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')) as {default: DefineComponent};
    page.default.layout = ((page.default.layout as VNode | undefined) || h(Scaffold));
    return page.default;
  },
  title: (title) => `${title} - Maicol07 Account`,
  setup({
    el,
    App,
    props,
    plugin
  }) {
    // noinspection JSUnusedGlobalSymbols
    createApp({render: () => h(App, props)})
      .use(plugin)
      .use(autoAnimatePlugin)
      .use(CircleFlags)
      .use(i18n)
      .use(modal, {
        resolve: async (name: string) => resolvePageComponent(`./Dialogs/${name}.vue`, import.meta.glob('./Dialogs/**/*.vue'))
      })
      .component('Head', Head)
      .component('Link', Link)
      .directive('visit', {
        mounted(element: HTMLAnchorElement, binding: DirectiveBinding<string>) {
          element.addEventListener('click', (event: MouseEvent) => {
            event.preventDefault();
            router.visit(element.href ?? binding.value);
          });
        }
      })
      .mount(el);
  }
});
