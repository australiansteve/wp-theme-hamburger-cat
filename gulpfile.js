// Load our plugins
var	gulp			= require('gulp'),
	sass			= require('gulp-sass'),  // Our sass compiler
	notify			= require('gulp-notify'), // Basic gulp notificatin using OS
	sourcemaps		= require('gulp-sourcemaps'), // Sass sourcemaps
	rename			= require('gulp-rename'), // Allows us to rename our css file prior to minifying
	autoprefixer		= require('gulp-autoprefixer'), // Adds vendor prefixes for us
	browserSync		= require('browser-sync'), // Sends php, js, img and css updates to browser for us
	concat			= require('gulp-concat'), // Concat our js
	uglify			= require('gulp-uglify'), // Minify our js
	jshint 			= require('gulp-jshint'); // Checks for js errors

// Our browser-sync task.

gulp.task('browser-sync', function() {
	var files = [
		'**/*.php'
	];

	browserSync.init(files, {
		proxy: 'localhost/'
	});
});


// Our 'styles' tasks, which handles our sass actions such as compliling and minification

gulp.task('styles', function() {
	gulp.src('assets/sass/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed'
		})
		.on('error', notify.onError(function(error) {
			return "Error: " + error.message;
		}))
		)
		.pipe(autoprefixer({
			browsers: ['last 2 versions', 'ie >= 9']
		})) // our autoprefixer - add and remove vendor prefixes using caniuse.com
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./assets/dist/css')) // Location of our app.css file
		.pipe(browserSync.stream({match: '**/*.css'}))
		.pipe(notify({
			message: "Styles task complete!"
		}));
});


// Our 'scripts' task, which handles our javascript elements
gulp.task('js', ['foundation-js'], function() {
	return gulp.src('assets/js/**/*.js')
		.pipe(concat('app.js'))
		.pipe(gulp.dest('./assets/dist/js'))
		.pipe(rename({suffix: '.min'}))
		.pipe(uglify()
		.on('error', notify.onError(function(error) {
			return "Error: " + error.message;
		}))
		)
		.pipe(gulp.dest('./assets/dist/js'))
		.pipe(browserSync.reload({stream:true}))
		.pipe(notify({ message: "Scripts task complete!"}));
});

// Foundation JS task, which gives us flexibility to choose what plugins we want
gulp.task('foundation-js', function() {
	return gulp.src([

		/* Choose what JS Plugin you'd like to use. Note that some plugins also
		require specific utility libraries that ship with Foundation—refer to a
		plugin's documentation to find out which plugins require what, and see
		the Foundation's JavaScript page for more information.
		http://foundation.zurb.com/sites/docs/javascript.html */

		// Core Foundation - needed when choosing plugins ala carte
		'node_modules/foundation-sites/js/foundation.core.js',

		// Choose the individual plugins you want in your project
		'node_modules/foundation-sites/js/foundation.abide.js',
		'node_modules/foundation-sites/js/foundation.accordion.js',
		'node_modules/foundation-sites/js/foundation.accordionMenu.js',
		'node_modules/foundation-sites/js/foundation.drilldown.js',
		'node_modules/foundation-sites/js/foundation.dropdown.js',
		'node_modules/foundation-sites/js/foundation.dropdownMenu.js',
		'node_modules/foundation-sites/js/foundation.equalizer.js',
		'node_modules/foundation-sites/js/foundation.interchange.js',
		'node_modules/foundation-sites/js/foundation.magellan.js',
		'node_modules/foundation-sites/js/foundation.offcanvas.js',
		'node_modules/foundation-sites/js/foundation.orbit.js',
		'node_modules/foundation-sites/js/foundation.responsiveMenu.js',
		'node_modules/foundation-sites/js/foundation.responsiveToggle.js',
		'node_modules/foundation-sites/js/foundation.reveal.js',
		'node_modules/foundation-sites/js/foundation.slider.js',
		'node_modules/foundation-sites/js/foundation.sticky.js',
		'node_modules/foundation-sites/js/foundation.tabs.js',
		'node_modules/foundation-sites/js/foundation.toggler.js',
		'node_modules/foundation-sites/js/foundation.util.box.js',
		'node_modules/foundation-sites/js/foundation.util.keyboard.js',
		'node_modules/foundation-sites/js/foundation.util.mediaQuery.js',
		'node_modules/foundation-sites/js/foundation.util.motion.js',
		'node_modules/foundation-sites/js/foundation.util.nest.js',
		'node_modules/foundation-sites/js/foundation.util.timerAndImageLoader.js',
		'node_modules/foundation-sites/js/foundation.util.touch.js',
		'node_modules/foundation-sites/js/foundation.util.triggers.js',

	])
	.pipe(concat('foundation.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./assets/dist/js'));
});

// Our 'fontawesome' task, which handles our sass actions such as compliling and minification

gulp.task('fontawesome', function() {
		
		gulp.src('./assets/components/components-font-awesome/fonts/**/*', {base: './assets/components/components-font-awesome/fonts'})
		.pipe(gulp.dest('./assets/dist/fonts'));

		gulp.src('./assets/components/components-font-awesome/scss/**/*.scss')
		.pipe(sass({
			style: 'expanded',
			sourceComments: true
		})
		.on('error', notify.onError(function(error) {
			return "Error: " + error.message;
		}))
		)
		.pipe(autoprefixer({
			browsers: ['last 2 versions', 'ie >= 8']
		})) // our autoprefixer - add and remove vendor prefixes using caniuse.com
		.pipe(gulp.dest('./assets/dist/css')) // Location of our app.css file
		.pipe(browserSync.reload({stream:true})) // CSS injection when app.css file is written
		.pipe(rename({suffix: '.min'})) // Create a copy version of our compiled app.css file and name it app.min.css
		.pipe(minifycss({
			keepSpecialComments:0
		})) // Minify our newly copied app.min.css file
		.pipe(gulp.dest('./assets/dist/css')) // Save app.min.css onto this directory
		.pipe(browserSync.reload({stream:true})) // CSS injection when app.min.css file is written
		.pipe(notify({
			message: "Font-Awesome task complete!"
		}));

});

//Our 'deploy' task which deploys on a local dev environment

gulp.task('deploylocal', function() {

	var files = [
		'assets/components/modernizr/modernizr.js',
		'assets/components/fastclick/lib/fastclick.js',
		'assets/components/foundation/js/foundation.min.js',
		'node_modules/underscore/underscore-min.js',
		'assets/dist/**/*', 
		'inc/**/*.*',
		'js/**/*.js',
		'languages/**.*',
		'page-templates/**/*',
		'screenshot.png',
		'style.css',
		'*.php'];

	var dest = '/var/www/html/theme-dev/wp-content/themes/hamburgercat';

	return gulp.src(files, {base:"."})
	        .pipe(gulp.dest(dest));
});

// Watch our files and fire off a task when something changes
gulp.task('watch', function() {
	gulp.watch('assets/sass/**/*.scss', ['styles']);
	gulp.watch('assets/js/**/*.js', ['js']);
});


// Our default gulp task, which runs all of our tasks upon typing in 'gulp' in Terminal
gulp.task('default', ['styles', 'js', 'browser-sync', 'watch']);
