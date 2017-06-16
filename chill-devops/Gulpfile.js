var gulp = require('gulp');
var sass = require('gulp-sass');
var runSequence = require('run-sequence');
var del = require('del');

gulp.task('sass', function () {
    return gulp.src('./src/AppBundle/Resources/public/scss/master.scss')
        .pipe(sass())
        .pipe(gulp.dest('./web/css/'));
});

gulp.task('c3', function () {
    return gulp.src('./src/AppBundle/Resources/public/css/c3.min.css')
        .pipe(gulp.dest('./web/css/'));
});


gulp.task('materialize', function () {
    return gulp.src('./node_modules/materialize-css/dist/**')
        .pipe(gulp.dest('./web/fonts/materialize/'));
});

gulp.task('img', function () {
    return gulp.src('./src/AppBundle/Resources/public/img/**.+(png|jpg|gif|svg|jpeg)')
        .pipe(gulp.dest('./web/img/'));
});

gulp.task('js', function () {
    return gulp.src('./src/AppBundle/Resources/public/js/**')
        .pipe(gulp.dest('./web/js/'));
});

gulp.task('clean', function () {
    del(['./web/css/', './web/js/', './web/fonts/', './web/img/', './web/bundles']);
});

gulp.task('watch', function () {
    var onChange = function (event) {
        console.log('File ' + event.path + ' has been ' + event.type);
    };

    // Watch Sass files
    gulp.watch([
        './src/AppBundle/Resources/public/scss/*.scss'
    ], ['sass']).on('change', onChange);

    // Watch Javascript files
    gulp.watch([
        './node_modules/jquery/dist/jquery.min.js',
        './src/AppBundle/Resources/public/js/*.js',
    ], ['js'])
        .on('change', onChange);

    // Watch Images files
    gulp.watch([
        './src/AppBundle/Resources/public/img/*.+(png|jpg|gif|svg|jpeg)',
    ], ['img']).on('change', onChange);
});

gulp.task('build', function (callback) {
    runSequence('clean', 'sass', 'js', 'img', 'materialize', 'c3', callback);
});