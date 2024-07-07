const path = require('path');

const copy = require('./src/copy');
const CopyPlugin = require('copy-webpack-plugin');

const nodeAssets = copy.nodeAssets.map(asset => {
	return {
		from: __dirname + '/node_modules/' + asset,
		to: path.resolve(__dirname, 'public', 'assets', 'lib'),
	};
});

const assets = copy.assets.map(asset => {
	return {
		from: path.resolve(__dirname, 'src', 'assets', 'image', asset),
		to: path.resolve(__dirname, 'public', 'assets', 'image'),
	};
});

module.exports = {
	entry: './src/index.js',
	output: {
		filename: 'bundle.js',
		path: path.resolve(__dirname, 'public', 'assets'),
	},
	module: {
		rules: [
			{
				test: /\.css$/i,
				use: ['style-loader', 'css-loader'],
			},
			{
				test: /\.s[ac]ss$/i,
				use: [
					'style-loader',
					'css-loader',
					{
						loader: 'sass-loader',
						options: {
							// Prefer `dart-sass`
							implementation: require('sass'),
						},
					},
				],
			},
			{
				test: /\.(png|svg|jpg|jpeg|gif)$/i,
				type: 'public/assets/image' /* Check output */,
			},
		],
	},
	plugins: [
		new CopyPlugin({
			// Only if required
			patterns: [...nodeAssets, ...assets],
		}),
	],
};
