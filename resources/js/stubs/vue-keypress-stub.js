/**
 * Stub temporal para vue-keypress
 * Reemplazar con @keydown o @keyup nativos de Vue 3
 */
export default {
  name: 'Keypress',
  template: '<div></div>',
  props: {
    keyevent: String,
    preventdefault: Boolean
  }
}

