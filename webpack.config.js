const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const glob = require('glob');
const { PurgeCSSPlugin } = require('purgecss-webpack-plugin');
const RtlCssPlugin = require('rtlcss-webpack-plugin'); // Agrega esta línea
var mode = 'development'; // 'development' o 'production'
module.exports = [
    {
        mode: mode,
        devtool: mode === 'development' ? 'source-map' : false, // Genera mapas de código fuente
        resolve: {
            modules: [path.resolve(__dirname, 'src'), 'node_modules'],
            alias: {
                '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
            }
        },
        entry: { // admin
            'scfs_arnelioconnect_output_plugin'    : path.resolve(__dirname, './src/admin/js/scfs_arnelioconnect_output_plugin.js'),
            'scfs_arnelioconnect_all_offcanvas'    : path.resolve(__dirname, './src/admin/js/scfs_arnelioconnect_all_offcanvas.js'),
            'scfs_arnelioconnect_dashboard'        : path.resolve(__dirname, './src/admin/js/scfs_arnelioconnect_dashboard.js'),
            'scfs_arnelioconnect_alimentacion'     : path.resolve(__dirname, './src/admin/js/scfs_arnelioconnect_alimentacion.js'),
            'scfs_arnelioconnect_alimentacion_cat' : path.resolve(__dirname, './src/admin/js/scfs_arnelioconnect_alimentacion_cat.js'),
            'scfs_arnelioconnect_alimentacion_tag' : path.resolve(__dirname, './src/admin/js/scfs_arnelioconnect_alimentacion_tag.js'),
            'scfs_arnelioconnect_alimentacion_item': path.resolve(__dirname, './src/admin/js/scfs_arnelioconnect_alimentacion_item.js'),
            'scfs_arnelioconnect_plantilla'         : path.resolve(__dirname, './src/admin/js/scfs_arnelioconnect_plantilla.js')
            // Elementor
            //'elementor_shortcode_widget'       : path.resolve(__dirname, './elementor/assets/js/elementor_shortcode_widget.js')
        },
        output: {
            filename: 'js/[name].js',
            path: path.resolve(__dirname, 'dist/admin'),
        },
        target: ['web', 'browserslist:IE 11'],
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: mode === 'development', // Habilita los mapas de código fuente para css-loader
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    config: path.resolve(__dirname, 'postcss.config.js'),
                                },
                                sourceMap: mode === 'development', // Habilita los mapas de código fuente para postcss-loader
                            },
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: mode === 'development', // Habilita los mapas de código fuente para sass-loader
                                sassOptions: {
                                    includePaths: ['./node_modules']
                                }
                            },
                        },
                    ],
                },
                {
                    test: /\.css$/,
                    use: [
                      MiniCssExtractPlugin.loader,
                      'css-loader',
                      'postcss-loader',
                    ],
                  },
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                    },
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: 'css/[name].css',
            }),
            new RtlCssPlugin({
                filename: 'css/[name]-rtl.css',
            }),
            ...(mode !== 'development' ? [new CleanWebpackPlugin({
                cleanOnceBeforeBuildPatterns: ['**/*.map'],
            })] : []),
        ],
        optimization: {
            minimizer: [
                new CssMinimizerPlugin(),
                new TerserPlugin(),
            ],
        },
        watch: true, // Parte admin
    },
    {
        mode: mode,
        devtool: mode === 'development' ? 'source-map' : false, // Genera mapas de código fuente
        resolve: {
            modules: [path.resolve(__dirname, 'src'), 'node_modules'],
            alias: {
                '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
            }
        },
        entry: { // public
            //'public': path.resolve(__dirname, './src/public/public.js'),
        },
        output: {
            filename: 'js/[name].js',
            path: path.resolve(__dirname, 'dist/public'),
        },
        target: ['web', 'browserslist:IE 11'],
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: mode === 'development', // Habilita los mapas de código fuente para css-loader
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                postcssOptions: {
                                    config: path.resolve(__dirname, 'postcss.config.js'),
                                },
                                sourceMap: mode === 'development', // Habilita los mapas de código fuente para postcss-loader
                            },
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: mode === 'development', // Habilita los mapas de código fuente para sass-loader
                                sassOptions: {
                                    includePaths: ['./node_modules']
                                }
                            },
                        },
                    ],
                },
                {
                    test: /\.css$/,
                    use: [
                      MiniCssExtractPlugin.loader,
                      'css-loader',
                      'postcss-loader',
                    ],
                  },
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                    },
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: 'css/[name].css',
            }),
            new RtlCssPlugin({
                filename: 'css/[name]-rtl.css',
            }),
            ...(mode !== 'development' ? [new CleanWebpackPlugin({
                cleanOnceBeforeBuildPatterns: ['**/*.map'],
            })] : []),
        ],
        optimization: {
            minimizer: [
                new CssMinimizerPlugin(),
                new TerserPlugin(),
            ],
        },
        watch: true, // Parte publica
    }
];
