const path = require('path');

module.exports = {
    configureWebpack: {
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            alias: {
                app: path.resolve(__dirname, 'src/'),
            },
        },
    },
    devServer: {
        proxy: {
            '^/comment': {
                secure: false,
                target: 'https://localhost:8000',
            },
            '^/comments': {
                secure: false,
                target: 'https://localhost:8000',
            },
        }
    },
};