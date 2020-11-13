// Load Gulp...of course
const { src, dest, task, watch, series, parallel } = require('gulp');

// CSS related plugins
var sass         = require( 'gulp-sass' );
var autoprefixer = require( 'gulp-autoprefixer' );
var minifycss    = require( 'gulp-uglifycss' );

// JS related plugins
var concat       = require( 'gulp-concat' );
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var plumber      = require( 'gulp-plumber' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );

// Browser related plugins
var browserSync  = require( 'browser-sync' ).create();

// Project related variables
var projectURL   = 'https://plugin-development.local';

var styleSRC     = './src/scss/mystyle.scss';
var styleForm    = './src/scss/form.scss';
var styleSlider  = './src/scss/slider.scss';
var styleAuth  = './src/scss/auth.scss';
var styleURL     = './assets/css/';
var mapURL       = './';

var jsAdmin      = 'myscript.js';
var jsForm   	 = 'form.js';
var jsSlider     = 'slider.js';
var jsAuth     = 'auth.js';
var jsFiles      = [jsAdmin, jsForm, jsSlider, jsAuth];
var jsSRC        = './src/js/';
var jsURL        = './assets/js/';

var imgSRC       = './src/images/**/*';
var imgURL       = './assets/images/';

var fontsSRC     = './src/fonts/**/*';
var fontsURL     = './assets/fonts/';

var htmlSRC     = './src/**/*.html';
var htmlURL     = './assets/';

var phpSRC     = './**/*.php';
var phpURL     = '/assets/';

var styleWatch   = './src/scss/**/*.scss';
var jsWatch      = './src/js/**/*.js';
var phpWatch     = './**/*.php';
var imgWatch     = './src/images/**/*.*';
var fontsWatch   = './src/fonts/**/*.*';
var htmlWatch    = './src/**/*.html';

// Tasks
function browser_sync() {
	browserSync.init({
		// server: {
		// 	baseDir: './assets/'
		// },
		proxy: projectURL,
		injectChanges: true,
		open: false
	});
}

function reload(done) {
	browserSync.reload();
	done();
}

function css(done) {
	src( [ styleSRC, styleForm, styleSlider, styleAuth ] )
		.pipe( sourcemaps.init() )
		.pipe( sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}) )
		.on( 'error', console.error.bind( console ) )
		.pipe( autoprefixer({ overrideBrowserslist: [ 'last 2 versions', '> 5%', 'Firefox ESR' ] }) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( sourcemaps.write( mapURL ) )
		.pipe( dest( styleURL ) )
		.pipe( browserSync.stream() );
	done();
}

function js(done) {
	jsFiles.map( function(entry) {
		return browserify({
			entries: [jsSRC + entry]
		})
		.transform( babelify, { presets: [ '@babel/preset-env' ] } )
		.bundle()
		.pipe( source( entry ) )
		.pipe( rename( {
			extname: '.min.js'
        } ) )
		.pipe( buffer() )
		.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
		.pipe( sourcemaps.init({ loadMaps: true }) )
		.pipe( uglify() )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( dest( jsURL ) )
		.pipe( browserSync.stream() );
	});
	done();
}

function triggerPlumber( src_file, dest_file ) {
	return src( src_file )
		.pipe( plumber() )
		.pipe( dest( dest_file ) );
}

function images() {
	return triggerPlumber( imgSRC, imgURL );
}

function fonts() {
	return triggerPlumber( fontsSRC, fontsURL );
}

function html() {
	return triggerPlumber( htmlSRC, htmlURL );
}

function php() {
	return triggerPlumber( phpSRC, phpURL );
}

function watch_files() {
	watch(styleWatch, series(css, reload));
	watch(jsWatch, series(js, reload));
	watch(imgWatch, series(images, reload));
	watch(fontsWatch, series(fonts, reload));
	watch(htmlWatch, series(html, reload));
	watch(phpWatch, series(php, reload));
	src(jsURL + 'myscript.min.js')
		.pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
}

task("css", css);
task("js", js);
task("images", images);
task("fonts", fonts);
task("html", html);
task("default", parallel(css, js, images, fonts, html));
task("watch", parallel(browser_sync, watch_files));