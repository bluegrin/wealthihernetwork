const path = require( 'path' )
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' )
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' )
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const { getWordPressSrcDirectory } = require( '@wordpress/scripts/utils' );

module.exports = (env, args) => {

    const mode = args.mode ?? 'production';
    const sourceMap = 'production' !== mode;

    return [
        {
            ...defaultConfig,
            entry: path.resolve( getWordPressSrcDirectory(), 'index.js' ),
            mode: mode,
            name: 'block-editor',
        },
        {
            devtool: 'source-map',
            entry: path.resolve( getWordPressSrcDirectory(), 'main.js' ),
            output: {
                filename: 'main.js',
                path: path.resolve( __dirname, './assets' ),
                publicPath: 'assets/',
            },
            mode: mode,
            module: {
                rules: [
                    {
                        test: /\.scss$/,
                        use: [
                            MiniCssExtractPlugin.loader,
                            {
                                loader: 'css-loader',
                                options: {
                                    sourceMap: sourceMap,
                                    url: false,
                                },
                            },
                            {
                                loader: 'postcss-loader',
                                options: {
                                    postcssOptions: {
                                        plugins: [
                                            [ 'autoprefixer', ],
                                        ],
                                    },
                                    sourceMap: sourceMap,
                                },
                            },
                            {
                                loader: 'sass-loader',
                                options: {
                                    sourceMap: sourceMap,
                                },
                            },
                        ],
                    },
                ],
            },
            plugins: [
                new CleanWebpackPlugin(),
                new MiniCssExtractPlugin(),
            ],
            name: 'theme',
        },
    ];
}