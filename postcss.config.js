module.exports = {
  plugins: [
    require('autoprefixer')({
      overrideBrowserslist: ['> 1%', 'last 2 versions', 'iOS >= 8'],
      cascade: false
    })
  ]
}