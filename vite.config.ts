import type {PluginOption} from 'vite';

import process from 'node:process';
import {wayfinder} from '@laravel/vite-plugin-wayfinder';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import {defineConfig} from 'vite';
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite';
import {bunny} from "laravel-vite-plugin/fonts";

const SERVER_NAME = process.env.SERVER_NAME;

const additionalPlugins: PluginOption[] = [];

// Don't do it in production
if (process.env.APP_ENV === 'local') {
  additionalPlugins.push(wayfinder({
    path: 'resources/ts'
  }));
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
      refresh: true,
      fonts: [
        bunny('Instrument Sans', {
          weights: [400, 500, 600],
        }),
      ],
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
    ...additionalPlugins
  ],
  // No server.https on purpose: Caddy terminates TLS on ${VITE_PORT} and proxies here in
  // plaintext (see deployment/dev/vite.caddyfile). When server.https is set, Vite builds the
  // dev server with node:http2 createSecureServer — hard-coded in resolveHttpServer, with no
  // opt-out — and the HTTP/1.1 Upgrade of the WebSocket handshake never reaches Vite's
  // listener: every HMR attempt gets a 403, even with the vite-ping subprotocol that bypasses
  // all of Vite's own checks.
  server: {
    host: '127.0.0.1',
    port: Number(process.env.VITE_INTERNAL_PORT ?? 5174),
    strictPort: true,
    ws: {
      protocol: 'wss',
      host: SERVER_NAME,
      clientPort: Number(process.env.VITE_PORT ?? 5173)
    },
    watch: {
      ignored: [
        '**/storage/framework/views/**'
      ]
    }
  }
})
;
