/**
 * *** DO NOT EDIT ***
 */

const { merge } = require('webpack-merge');
const common = require('./webpack.config.common');
const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const devPlugins = [];
const { browsersyncEnabled, browsersyncHost, browsersyncPort, browsersyncProxy } = require('../../config/webpack.config');

// Error handling for BrowserSync settings
if (browsersyncEnabled) {
    if (!browsersyncHost || !browsersyncPort || !browsersyncProxy) {
        throw new Error('BrowserSync is enabled, but one or more of its settings (host, port, proxy) are missing or invalid.');
    }

    devPlugins.push(
        new BrowserSyncPlugin({
            host: browsersyncHost,
            port: browsersyncPort,
            proxy: browsersyncProxy,
        }),
    );
}

module.exports = merge(common, {
    mode: 'development',
    watch: true,
    watchOptions: {
        ignored: ['**/acf-json', '**/node_modules', '**/assets', '**/bin', '**/dist', '**/.*', '**/*.log', '**/*.ini', '**/*.db', '**/*.tmp', '**/webpack.config.common.js', '**/webpack.config.dev.js', '**/webpack.config.prod.js'],
    },
    plugins: devPlugins,
});
