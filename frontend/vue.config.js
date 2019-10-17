module.exports = {
  publicPath: '/',
  outputDir: 'dist',
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