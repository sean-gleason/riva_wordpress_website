const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

module.exports = {
  plugins: [
    process.env.LANDO ? false : cssnano(),
    autoprefixer({
      cascade: false,
    }),
  ],
}
