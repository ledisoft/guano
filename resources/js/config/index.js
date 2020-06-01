import i18n from '~/i18n';

/**
 * Bootstrap-Vue
 *
 * @type {Object}
 */
export const BootstrapVueConfig = {
  // TODO: BootstrapVue default configuration
};

/**
 * NProgress configuration
 *
 * @type {Object}
 */
export const NProgressConfig = {
  showSpinner: false,
  defaultMessage: (_, values) => i18n.t(`vee-validate.${ values._rule_ }`, values),
};

/**
 * Vee-Validation
 *
 * @type {Object}
 */
export const VeeValidateConfig = {
  mode: 'eager',
};
