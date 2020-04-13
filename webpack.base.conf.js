const VueLoaderPlugin = require('vue-loader/lib/plugin')
const nodeExternals = require('webpack-node-externals')
var path = require('path');


module.exports = {
  mode: 'development',
  module: {
    rules: [
      {
        test: /\.(js|ts)/,
        include: path.resolve('resources/js'), // instrument only testing sources with Istanbul, after ts-loader runs
        exclude: /node_modules/,
        loader: 'istanbul-instrumenter-loader',
        query: {
          esModules: true
        }
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.css$/,
        use: [
          'vue-style-loader',
          'css-loader'
        ]
      },
      {
        test: /\.ts$/,
        exclude: /(node_modules|bower_components)/,
        loader: 'ts-loader'
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin()
  ],
  externals: [nodeExternals()],
  devtool: 'inline-cheap-module-source-map',
}