const path = require('path')

module.exports = {
    resolve: {
        // for Ide
        alias: {
            '@': path.resolve(__dirname),
            '~': path.resolve(__dirname),
        }
    }
}