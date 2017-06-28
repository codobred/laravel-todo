'use strict';

let ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    context: __dirname + '/resources/assets',
    entry:  {
        main: './js',
    },
    output:  {
        path:     __dirname + '/public/assets',
        publicPath: '/',
        filename: 'js/[name].js'
    },
    resolve: {
        extensions: ['', '.js', '.styl']
    },

    module: {
        loaders: [{
            test:   /\.js$/,
            loader: "babel?presets[]=es2015"
        }, {
            test:   /\.styl$/,
            loader: ExtractTextPlugin.extract('css!stylus?resolve url')
        }, {
            test:   /\.(png|jpg|svg|ttf|eot|woff|woff2)$/,
            loader: 'file?name=[path][name].[ext]'
        }]
    },

    plugins: [
        new ExtractTextPlugin('css/[name].css')
    ]
};
