import fs from 'node:fs';
import process from 'node:process';
import timer from 'node:timers/promises';

import {wayfinder} from '@laravel/vite-plugin-wayfinder';
import laravel from 'laravel-vite-plugin';
import {defineConfig} from 'vite';
import VitePluginRestart from 'vite-plugin-restart';

const SERVER_NAME = process.env.SERVER_NAME;
const ssl = {
  key: `.data/caddy/certificates/local/${SERVER_NAME}/${SERVER_NAME}.key`,
  cert: `.data/caddy/certificates/local/${SERVER_NAME}/${SERVER_NAME}.crt`
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
      '@animations/': '/resources/animations/'
    }
  },
  plugins: [
    laravel({
      input: ['resources/scss/app.scss', 'resources/ts/app.ts'],
      refresh: true
    }),
    // TODO: Remove check when https://github.com/laravel/wayfinder/issues/59 is done
    ...(process.env.WAYFINDER_WORKAROUND === 'true'
      ? []
      : [wayfinder({
        path: 'resources/ts'
      })]),
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
