const VueLoaderPlugin = require('vue-loader/lib/plugin')
const nodeExternals = require('webpack-node-externals')
var path = require('path');


module.exports = {
  mode: 'development',
  module: {
    rules: [
      {
        test: /\.(js)$/,
        include: path.resolve('resources/js'), // instrument only testing sources with Istanbul, after ts-loader runs
        exclude: [
          path.resolve(`node_modules`),
          path.resolve(`test/javascript`),
        ],
        loader: 'istanbul-instrumenter-loader',
        options: {
          esModules: true
        }
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin()
  ],
  externals: [nodeExternals()],
  devtool: 'inline-cheap-module-source-map',
}