// Extra libs
const CSS = [];

const JS = [
	'jquery/dist/jquery.min.js',
	'bootstrap/dist/css/bootstrap.min.css',
];

const IMG = [
	/* 'hero.jpg', 'logo.png', 'futbol_v.png' */
];

// FIXME: REMOVE IMG ASSETS FROM WEBPACK CONFIG
module.exports = {
	nodeAssets: [...CSS, ...JS],
	assets: IMG,
};
