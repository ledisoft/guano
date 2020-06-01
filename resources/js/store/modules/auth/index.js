import { assign } from 'lodash';
import { login } from '~/api/auth';

/**
 * Module default state
 *
 * @return {Object}
 */
const defaultState = () => ({
  id: null
});

/**
 * Module states
 *
 * @type {Object}
 */
const state = defaultState();

/**
 * Module mutations
 *
 * @type {Object}
 */
const mutations = {
  RESET_STATE: (state) => {
    assign(state, defaultState());
  }
};

/**
 * Module actions
 *
 * @type {Object}
 */
const actions = {
  login({ commit }, credentials) {
    const { email, password } = credentials;

    return new Promise((resolve, reject) => {
      login({ email: email.trim(), password: password })
        .then(() => {
          resolve();
        })
        .catch(error => {
          reject(error);
        });
    });
  }
};

export default {
  state, mutations, actions
};
