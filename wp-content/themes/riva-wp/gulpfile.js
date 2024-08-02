const beep = require('beepbeep');
const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sassGlob = require('gulp-sass-glob');
const sourcemaps = require('gulp-sourcemaps');
const postcss = require('gulp-postcss');
const webpack = require('webpack');
const webpackStream = require('webpack-stream');
const webpackConfig = require('./webpack.config');

const config = {
  input: {
    js: 'js/',
    // this is needed but not used. @see webpack.config.js

    css: 'sass/*.s+(a|c)ss',
    // globbing of all SCSS happens in sass/*.scss files that do not begin with an underscore:
    // main.scss, admin.scss, login.scss, etc.  Each of these files without a leading underscore
    // generates an associated, compiled .css file in dist/css/.
  },
  output: {
    js: 'dist/js/',
    css: 'dist/css/',
  },
  watch: {
    js: [
      'js/*.js',
			'js/**/*.js',
			'modules/**/*.js',
			'blocks/**/*.js'
		],
    css: [
			'sass/**/*.s+(a|c)ss',
			'modules/**/*.s+(a|c)ss',
			'blocks/**/*.s+(a|c)ss',
		],
  },
  sourcemaps: './sourcemaps',
};

function js() {
  return gulp
    .src(config.input.js)
    .pipe(webpackStream(webpackConfig, webpack))
    .on('error', function handleError() {
      this.emit('end'); // Recover from errors
      beep();
    })
    .pipe(gulp.dest(config.output.js));
}

function css() {
  return gulp
    .src(config.input.css)
    .pipe(sassGlob())
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        outputStyle: 'expanded',
        includePaths: ['node_modules'],
      })
      .on('error', sass.logError)
      .on('error', beep)
    )
    .pipe(postcss())
    .pipe(sourcemaps.write(config.sourcemaps))
    .pipe(gulp.dest(config.output.css));
}

function watchCSS() {
  gulp.watch(config.watch.css, css);
}

function watchJS() {
  gulp.watch(config.watch.js, js);
}

const buildAll = gulp.parallel(js, css);

exports.js = gulp.series(js);
exports.sass = gulp.series(css);
exports.css = gulp.series(css);
exports.watch = gulp.series(buildAll, gulp.parallel(watchCSS, watchJS));
exports.build = gulp.series(buildAll);

exports.default = gulp.series(buildAll);
