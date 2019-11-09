module.exports = {
  publicPath: '/',
  outputDir: 'dist',
  assetsDir: 'h5',
  devServer: {
    proxy: {
      '/api': {
        target: 'https://manage.siring.com.cn/',
        changeOrigin: true,
        pathRewrite: {
          '^/api': ''
        }
      }
    }
  }
}