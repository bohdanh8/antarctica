/**
 * *** DO NOT EDIT ***
 */

const { merge } = require('webpack-merge');
const common = require('./webpack.config.common');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const FileManagerPlugin = require('filemanager-webpack-plugin');
const { themeName } = require('../../config/webpack.config.base');

module.exports = merge(common, {
    mode: 'production',
    optimization: {
        minimizer: [new CssMinimizerPlugin(), new TerserPlugin()],
    },
    plugins: [
        new FileManagerPlugin({
            events: {
                onEnd: {
                    archive: [
                        {
                            source: 'dist',
                            destination: `bin/${themeName}.zip`,
                        },
                    ],
                },
            },
            runTasksInSeries: true,
        }),
    ],
});
