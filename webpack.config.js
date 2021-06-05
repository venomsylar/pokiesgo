let path = require('path');
let Encore = require('@symfony/webpack-encore');
let themeName = 'pokiesgo-main';
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
Encore
		.setOutputPath(path.join(__dirname, 'assets/dist'))
		.setManifestKeyPrefix(`dist/`)
		.setPublicPath(`/wp-content/themes/${themeName}/assets/dist`)
		.cleanupOutputBeforeBuild()
		//START add js files
		.addEntry('main', './assets/development/main.js')
		.addEntry('404', './assets/development/js/pages/404.js')
		.addEntry('casino', './assets/development/js/pages/casino.js')
		//END add js files
		.enableSassLoader()
		.enablePostCssLoader((options) => {
			options.config = {
				path: './postcss.config.js'
			}
		})
		.autoProvideVariables({
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
		})
		.enableSingleRuntimeChunk()
		.splitEntryChunks()
		.enableVersioning(Encore.isProduction())
		.enableSourceMaps(!Encore.isProduction())
		.addPlugin(new UglifyJsPlugin({
			extractComments: {
				condition: /^\**!|@preserve|@license|@cc_on/i,
				filename(file) {
					return `${file}.LICENSE`;
				},
				banner(licenseFile) {
					return '';
				},
			},
			uglifyOptions: {
				ie8: true,
			}
		}));

module.exports = Encore.getWebpackConfig();