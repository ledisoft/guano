/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import i18n from '~/i18n';
import store from '~/store';
import router from '~/router';
import application from '~/views/application';

import BootstrapVue from 'bootstrap-vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { ValidationObserver, ValidationProvider, configure as ValidationConfig } from 'vee-validate';
import { BootstrapVueConfig, VeeValidateConfig } from '~/config';

/**
 * Prevent the production tip on Vue startup
 *
 * @type {boolean}
 */
Vue.config.productionTip = false;

/**
 * VeeValidate configuration
 */
ValidationConfig(VeeValidateConfig);

/**
 * Load BootstrapVue library
 */
Vue.use(BootstrapVue, BootstrapVueConfig);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.component('FaIcon', FontAwesomeIcon);
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
export const app = new Vue({
  i18n, store, router, ...application
}).$mount('#application');
