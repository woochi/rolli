'use strict'

var browserify = require('browserify');
var gulp = require('gulp');
var gutil = require('gulp-util');
var transform = require('vinyl-transform');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var watchify = require('watchify');
var jade = require("gulp-jade");
var sass = require("gulp-sass");
var cssmin = require('gulp-cssmin');
var prefix = require('gulp-autoprefixer');
var watch = require('gulp-watch');
var connect = require('gulp-connect');
var flatten = require("gulp-flatten");
var rsync = require("gulp-rsync");
var del = require("del");
var sequence = require('run-sequence');

var bundles = [
  {source: './app/assets/javascripts/theme.coffee', out: "theme.js"},
  {source: './app/assets/javascripts/admin.coffee', out: "admin.js"},
  {source: './app/assets/javascripts/preview.coffee', out: "preview.js"}
];

var bundlers = bundles.map(browserifyBundle);

function browserifyBundle(config) {
  var bundler = browserify(config.source);
  bundler
    .transform("coffeeify", {extension: ".coffee"})
    .transform("browserify-shim");

  var bundle = function () {
    bundler.bundle()
      .on("error", gutil.log.bind(gutil, "Browserify Error"))
      .pipe(source(config.out))
      .pipe(buffer())
      .pipe(sourcemaps.init({loadMaps: true}))
      .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest("./build/javascripts"))
      .pipe(connect.reload());
  }

  bundler.on("update", bundle);
  bundler.on("log", gutil.log);
  return bundle;
}

gulp.task("scripts", function() {
  bundlers.forEach(function (bundler) { bundler(); });
});

gulp.task("styles", function(){
  gulp.src([
    "./app/assets/stylesheets/theme/style.sass",
    "./app/assets/stylesheets/admin/admin.sass"
  ])
    .on("error", gutil.log)
    .pipe(sourcemaps.init())
    .pipe(sass({
      indentedSyntax: true,
      errLogToConsole: true,
      includePaths: ["vendor/foundation/scss"]
    }))
    .pipe(prefix("last 1 version", "> 1%", "ie 8", "ie 7"))
    .pipe(cssmin())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest("./build"))
    .pipe(connect.reload())
});

gulp.task("images", function(){
  gulp.src("./app/assets/images/screenshot.png")
    .pipe(gulp.dest("./build/"))
  gulp.src("./app/assets/images/**/*")
    .pipe(gulp.dest("./build/images"))
})

gulp.task("copy", function(){
  gulp.src([
    "./app/templates/**",
    "./app/includes/**",
    "./app/functions/**"
  ])
    .on("error", gutil.log)
    .pipe(flatten())
    .pipe(gulp.dest("./build"))
});

gulp.task("clean", function(callback){
  del(["./build/**/*"], {force: true}, callback);
});

gulp.task("watch", function(){
  watch("./app/assets/javascripts/**/*.coffee", function(){gulp.start("scripts");});
  watch("./app/assets/stylesheets/**/*", function(){gulp.start("styles");});
  watch("./app/assets/images/**/*", function(){gulp.start("images");});
  watch([
    "./app/functions/**/*",
    "./app/includes/**/*",
    "./app/templates/**/*"
  ], function(){gulp.start("copy");});
});

gulp.task("rsync", function(){
  gulp.src("build/")
    .pipe(rsync({
      destination: "/var/www/wp-content/themes/rolli",
      host: "root@128.199.42.152",
      recursive: true,
      delete: true
    }));
});

gulp.task("default", function(){
  sequence("clean", ["clean", "scripts", "styles", "images", "copy"], "watch")
});

gulp.task("deploy", function(callback){
  sequence("clean", ["scripts", "styles", "images", "copy"], "rsync");
});
