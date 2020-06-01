const path = require('path');

module.exports = {
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
        options: {
          presets: [
            '@babel/preset-env'
          ],
          plugins: [
            'dynamic-import-node',
            'babel-plugin-transform-vue-jsx',
            'babel-plugin-syntax-dynamic-import',
            '@babel/plugin-syntax-dynamic-import',
            '@babel/plugin-transform-runtime'
          ]
        }
      },
      {
        test: /\.scss$/,
        loader: 'sass-loader'
      },
      {
        test: /\.(js|vue)?$/,
        loader: 'eslint-loader',
        exclude: /node_modules/,
        enforce: 'pre',
      }
    ]
  },
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      vue$: 'vue/dist/vue.esm.js',
      '~': path.join(__dirname, '/resources/js'),
    }
  }
};
