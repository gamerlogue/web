declare module 'inertia-modal' {
  import type {VisitOptions} from '@inertiajs/core';
  import type {Component, ObjectPlugin, Ref} from 'vue';

  export function useModal(): {
    show: Ref<boolean>;
    vnode: Ref;
    close: () => void;
    redirect: (options: VisitOptions = {}) => void;
    props: Record<string, unknown>;
  };

  export const Modal: Component;
  export const modal: ObjectPlugin;
}
