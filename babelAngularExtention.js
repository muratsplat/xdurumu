var gulp = require('gulp');
var Elixir = require('laravel-elixir');

/**
 * These for Angular + Babel + Uglify + Avoid issues of the Dependency Injection  
 */
var sourcemaps	= require('gulp-sourcemaps');
var babel		= require('gulp-babel');;
var rename		= require("gulp-rename");
var babelify	= require('babelify');
var browserify	= require('browserify');
var source		= require('vinyl-source-stream');
var buffer		= require('gulp-buffer');
var gutil		= require('gulp-util');
var jshint		= require('gulp-jshint');
var stylish		= require('jshint-stylish');
var babel		= require('babel/register');
var uglify		= require('gulp-uglify');
var ngAnnotate  = require('gulp-ng-annotate');

var $ = Elixir.Plugins;

var Task = Elixir.Task;

Elixir.extend('angularPlusBabel', function(opts) {

	    new Task('angularPlusBabel', function() {

			var entries = opts.src;
			var dist    = opts.dist;

			this.log(opts.src, opts.dist);

			 return browserify({			    
					entries: entries,
			   	    debug: true
				}).transform(babelify)
			    .bundle()
				.pipe(source('bundle.js'))
				.pipe(buffer())
				.pipe(sourcemaps.init({loadMaps: true}))
				.pipe($.if(Elixir.config.production,  ngAnnotate()))
				.pipe($.if(Elixir.config.production, $.uglify()))
				.on('error', function(e) {
					new Elixir.Notification().error(e, 'angularPlusBabel Failed!');
					this.emit('end');
				 })
				.pipe(sourcemaps.write('.'))
				.pipe(gulp.dest(dist))
				.pipe(new Elixir.Notification('angularPlusBabel Compiled!'));
		});
});

