module.exports = {
    publicPath: '/',
    outputDir: 'dist',
    assetsDir: 'h5',
    devServer: {
        proxy: {
            '/api': {
                target: 'https://www.siring.com.cn/',
                changeOrigin: true,
                pathRewrite: {
                    '^/api': ''
                }
            }
        }
    }
}