const path = require('path');
const glob = require('glob');

const entries = {};

glob.sync('./js/*.js').forEach(filepath => {
  return entries[path.basename(filepath, '.js')] = filepath;
});

module.exports = {
  mode: 'production',
  entry: {
    main: './js/main.js',
    ...entries,
  },
  output: {
    path: path.resolve(__dirname, 'js'),
    filename: '[name].js',
    // Follow existing sourcemap nesting convention set in
    // gulpfile for CSS mapping.
    sourceMapFilename: 'sourcemaps/[name].js.map',
  },
	resolve: {
		alias: {
			js: path.resolve(__dirname, 'js'),
		}
	},
  externals: {
    jQuery: 'jQuery',
		jquery: 'jQuery',
  },
  module: {
    rules: [
			{
        test: /\.js$/,
        exclude: /node_modules/,
        use: ['babel-loader'],
      },
    ],
  },
  devtool: 'source-map',
}
