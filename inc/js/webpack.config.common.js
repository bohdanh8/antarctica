/**
 * *** DO NOT EDIT ***
 */

const path = require('path');
const fs = require('fs');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FileManagerPlugin = require('filemanager-webpack-plugin');
const { themePath, uploadToStaging } = require('../../config/webpack.config');
const { themeName } = require('../../config/webpack.config.base');
const glob = require('glob');

const acfJsonThemePath = `${themePath}/${themeName}/acf-json`;
const acfJsonMainPath = 'acf-json';

let copyACF = false;

const acfJsonThemeExists = fs.existsSync(acfJsonThemePath);
const acfJsonMainExists = fs.existsSync(acfJsonMainPath);

if (!acfJsonThemeExists && acfJsonMainExists) {
    copyACF = [
        {
            source: 'acf-json',
            destination: 'dist/acf-json',
        },
    ];
} else if ((acfJsonThemeExists && !acfJsonMainExists) || (acfJsonThemeExists && acfJsonMainExists)) {
    copyACF = [
        {
            source: `${themePath}/${themeName}/acf-json`,
            destination: 'acf-json',
        },
        {
            source: 'acf-json',
            destination: 'dist/acf-json',
        },
    ];
}

const localizedScripts = glob.sync(path.resolve(__dirname, '../../src/js/*.{localize.js,localized.js}')).reduce((entries, file) => {
    const fileName = path.basename(file); // e.g. prosek_nav.localize.js -or- prosek_nav.localized.js (catch-all for potential typos)
    const entryKey = fileName.replace(/\.js$/, '');
    entries[entryKey] = file;
    return entries;
}, {});

module.exports = {
    entry: {
        main: path.resolve(__dirname, 'index.js'),
        ...localizedScripts,
    },
    output: {
        clean: true,
        path: path.resolve(__dirname, '../../dist/assets/'),
        filename: 'js/[name].js',
        assetModuleFilename: '[name][ext]',
    },
    devtool: 'source-map',
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            importLoaders: 1,
                        },
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                plugins: [require('tailwindcss'), require('autoprefixer')],
                            },
                        },
                    },
                ],
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'images/[name][ext]',
                },
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'fonts/[name][ext]',
                },
            },
        ],
    },
    optimization: {
        splitChunks: {
            cacheGroups: {
                header: {
                    test: /modules\/header-footer\/index\.js/,
                    name: 'header-footer',
                    chunks: 'all',
                    enforce: true,
                },
                main: {
                    test: /index\.js/,
                    name: 'main',
                    chunks: 'all',
                    enforce: true,
                },
            },
        },
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),
        new webpack.IgnorePlugin({
            resourceRegExp: /\/_/,
            contextRegExp: /.+\/?$/,
        }),
        new webpack.DefinePlugin({
            MODULES_PATH: JSON.stringify(path.resolve(__dirname, 'modules')),
        }),
        new FileManagerPlugin({
            events: {
                onStart: {
                    ...(copyACF ? { copy: [...copyACF] } : {}),
                    delete: [
                        'bin/*',
                        '**/.DS_Store',
                        '.github/workflows/*',
                        {
                            source: `${themePath}/${themeName}`,
                            options: {
                                force: true,
                            },
                        },
                    ],
                },
                onEnd: {
                    copy: [
                        ...(uploadToStaging
                            ? [
                                  {
                                      source: '.github/disabled-workflows/main.yml',
                                      destination: '.github/workflows/',
                                      globOptions: {
                                          ignore: ['**/_*'],
                                          dot: false,
                                      },
                                  },
                              ]
                            : []),
                        {
                            source: 'src/js/*.localize.js',
                            destination: 'dist/assets/js',
                        },
                        {
                            source: 'src/js/*.localized.js',
                            destination: 'dist/assets/js',
                        },
                        {
                            source: 'src/templates/**/*',
                            destination: 'dist/assets/templates',
                            globOptions: {
                                ignore: ['**/_*'],
                                dot: false,
                            },
                        },
                        {
                            source: 'src/nav-walkers/**/*',
                            destination: 'dist/assets/nav-walkers',
                            globOptions: {
                                ignore: ['**/_*'],
                                dot: false,
                            },
                        },
                        {
                            source: '**/*',
                            destination: 'dist',
                            globOptions: {
                                ignore: ['**/node_modules', '**/*.log', '**/tailwind.*.js', '**/webpack.*.js', '**/package.json', '**/package-lock.json', '**/screenshot.psd', '**/server-config.yml', '**/dist', '**/src', '**/bin', 'inc/js', '**/_*'],
                                dot: false,
                            },
                        },
                        {
                            source: 'dist',
                            destination: `${themePath}/${themeName}`,
                        },
                    ],
                },
            },
            runTasksInSeries: true,
        }),
    ],
};
