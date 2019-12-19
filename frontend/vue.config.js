module.exports = {
  publicPath: '/',
  outputDir: 'dist',
  assetsDir: 'h5',
  devServer: {
    proxy: {
      '/api': {
        target: 'https://manage.siring.com.cn/',
        // target:'http:www.siring.com/',
        changeOrigin: true,
        pathRewrite: {
          '^/api': ''
        }
      }
    }
  }
}