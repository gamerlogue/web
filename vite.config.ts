import fs from 'node:fs';
import path, {dirname, resolve} from 'node:path';
import process from 'node:process';
import timer from 'node:timers/promises';
import {fileURLToPath} from 'node:url';

import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite';
import {wayfinder} from '@laravel/vite-plugin-wayfinder';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import {defineConfig} from 'vite';
import VitePluginRestart from 'vite-plugin-restart';

const SERVER_NAME = process.env.SERVER_NAME;
const ssl = {
  key: `${process.env.HOME}/.local/share/caddy/certificates/local/${SERVER_NAME}/${SERVER_NAME}.key`,
  cert: `${process.env.HOME}/.local/share/caddy/certificates/local/${SERVER_NAME}/${SERVER_NAME}.crt`
};

// Don't do it in production
if (process.env.APP_ENV === 'local') {
  if (!fs.existsSync(ssl.key) || !fs.existsSync(ssl.cert)) {
    console.error(`SSL certificate files not found. Make sure Caddy is running and has generated the SSL certificates for ${SERVER_NAME}.`);
    process.exit(1);
  }

  // Wait for the SSL certificate files to be available
  const maxAttempts = 10;
  let attempts = 0;
  while ((!fs.existsSync(ssl.key) || !fs.existsSync(ssl.cert)) && attempts < maxAttempts) {
    console.log(`Waiting for SSL certificate files to be available... (Attempt ${attempts + 1}/${maxAttempts})`);
    await timer.setTimeout(3000); // Wait for 3 seconds before checking again
    attempts++;
  }
}

// noinspection JSUnusedGlobalSymbols (Removes the false positive on "isCustomElement")
export default defineConfig({
  assetsInclude: [
    '**/*.xml'
  ],
  resolve: {
    alias: {
      '~/': '/resources/ts/',
      '@images/': '/resources/images/',
      '@animations/': '/resources/animations/',
      'inertia-modal': path.resolve('vendor/emargareten/inertia-modal')
    }
  },
  plugins: [
    laravel({
      input: ['resources/scss/app.scss', 'resources/ts/app.ts'],
      refresh: true
    }),
    vue({
      template: {
        compilerOptions: {
          isCustomElement: (tag: string) => tag.startsWith('md-')
        }
      }
    }),
    VueI18nPlugin({
      // Locale messages resource pre-compile option
      include: resolve(dirname(fileURLToPath(import.meta.url)), './lang/**.json')
    }),
    wayfinder({
      path: 'resources/ts'
    }),
    VitePluginRestart({
      restart: [ssl.key, ssl.cert]
    })
  ],
  server: {
    https: {
      key: (process.env.APP_ENV === 'local') ? fs.readFileSync(ssl.key) : undefined,
      cert: (process.env.APP_ENV === 'local') ? fs.readFileSync(ssl.cert) : undefined
    },
    hmr: {
      host: SERVER_NAME
    },
    watch: {
      ignored: [
        '**/.config/**',
        '**/.data/**'
      ]
    }
  }
});
