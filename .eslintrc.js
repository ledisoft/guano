module.exports = {
  root: true,
  env: {
    es6: true,
    node: true,
    browser: true,
  },
  extends: [
    'eslint:recommended',
    'plugin:vue/recommended',
  ],
  parser: 'vue-eslint-parser',
  parserOptions: {
    ecmaVersion: 2018,
    sourceType: 'module',
    parser: 'babel-eslint',
    allowImportExportEverywhere: false
  },
  plugins: [
    'vue',
  ],
  rules: {
    'padded-blocks': [
      'error', 'never'
    ],
    'arrow-spacing': [
      'error', {
        'before': true,
        'after': true,
      }
    ],
    'block-spacing': [
      'error', 'always'
    ],
    'no-unused-vars': [
      'error',
      {
        vars: 'all',
        args: 'none',
      }
    ],
    'spaced-comment': [
      'error', 'always', {
        'markers': [
          ',',
          '!',
          'eslint',
          'global',
          'globals',
          '*package',
          'eslint-disable'
        ]
      }
    ],
    'space-before-function-paren': [
      'error', 'never'
    ],
    'space-in-parens': [
      'error', 'never'
    ],
    'space-infix-ops': 'error',
    'space-unary-ops': [
      'error', {
        'words': true,
        'nonwords': false
      }
    ],
    'no-multiple-empty-lines': [
      'error', {
        'max': 2
      }
    ],
    'padding-line-between-statements': [
      'error', {
        'blankLine': 'always',
        'prev': '*',
        'next': 'return'
      }, {
        'blankLine': 'always',
        'prev': 'if',
        'next': '*'
      }
    ],
    'vue/max-attributes-per-line': [
      'error', {
        'singleline': 4,
        'multiline': {
          'max': 1,
          'allowFirstLine': false,
        },
      }
    ],
    'vue/no-v-html': 'off',
    'vue/singleline-html-element-content-newline': 'off',
  }
};
