var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var runSequence = require('run-sequence');
var del = require('del');
var image = require('gulp-image');

gulp.task('sass', function () {
    return gulp.src('./src/AppBundle/Resources/Public/scss/master.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./web/css/'));
});

gulp.task('materialize', function () {
    return gulp.src('./node_modules/materialize-css/dist/fonts/bootstrap/*')
        .pipe(gulp.dest('./web/fonts/materialize/'));
});

gulp.task('build', function (callback) {
    runSequence('sass', 'materialize', callback);
});