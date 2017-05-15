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
    return gulp.src('./node_modules/materialize-css/dist/**')
        .pipe(gulp.dest('./web/fonts/materialize/'));
});

gulp.task('img', function () {
    return gulp.src('./src/AppBundle/Resources/Public/img/**.+(png|jpg|gif|svg|jpeg)')
        .pipe(gulp.dest('./web/img/'));
});

gulp.task('js', function () {
    return gulp.src('./src/AppBundle/Resources/Public/js/**')
        .pipe(gulp.dest('./web/js/'));
});

gulp.task('watch', function () {
    var onChange = function (event) {
        console.log('File ' + event.path + ' has been ' + event.type);
    };

    // Watch Sass files
    gulp.watch([
        './src/AppBundle/Resources/Public/scss/**/*.scss'
    ], ['sass']).on('change', onChange);

    // Watch Javascript files
    gulp.watch([
        './node_modules/jquery/dist/jquery.min.js',
        './src/AppBundle/Resources/Public/js/*.js',
    ], ['js'])
        .on('change', onChange);

    // Watch Images files
    gulp.watch([
        './src/AppBundle/Resources/Public/img/*.+(png|jpg|gif|svg|jpeg)',
    ], ['img']).on('change', onChange);


    gulp.watch([
        './src/CND/ShowCase/ProBundle/Resources/public/docs/*.+(jpeg|jpg|xls|svg|ifc|pdf|png)'
    ], ['docs']).on('change', onChange);
});

gulp.task('build', function (callback) {
    runSequence('sass','js', 'img', 'materialize', callback);
});