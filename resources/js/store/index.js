import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

/**
 * Vuex modules
 *
 * @type {Object}
 */
const modules = {};

/**
 * Custom context. Contains references to all modules in `modules` directory
 *
 * https://webpack.js.org/guides/dependency-management/
 */
const context = require.context('./modules', true, /\/index\.js$/);

context.keys().forEach((file) => {
  /**
   * Find files with only the `index.js` name
   */
  const module = file.replace(/(^.\/)|(\/index\.js$)/g, '');

  modules[module] = context(file).default || context(file);

  if (modules[module].namespaced === undefined) {
    modules[module].namespaced = true;
  }
});

const store = new Vuex.Store({
  modules
});

export default store;
