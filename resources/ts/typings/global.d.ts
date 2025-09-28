// noinspection JSUnusedGlobalSymbols

import type {vAutoAnimate} from '@formkit/auto-animate/vue';
import type {Directive} from 'vue';
import type CircleFlags from 'vue-circle-flags/dist/components/CircleFlags.vue';

declare module 'vue' {
  export interface ComponentCustomProperties extends Window {
    vAutoAnimate: typeof vAutoAnimate;
  }
  export interface GlobalComponents {
    CircleFlags: typeof CircleFlags;
  }
  export interface GlobalDirectives {
    vVisit: Directive<HTMLElement, string>;
  }
}
