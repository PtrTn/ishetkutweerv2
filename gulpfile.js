var gulp = require('gulp');
var notify = require("gulp-notify");
var sass = require('gulp-sass');
var merge = require('merge-stream');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var plumber = require('gulp-plumber');

gulp.task('default', ['styles']);

gulp.task('scripts', function() {
    return gulp.src('app/resources/js/**/*.js')
        .pipe(plumber())
        .pipe(uglify({mangle: false}))
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest('public/scripts/'))
        .pipe(notify({message: 'Scripts task complete'}));
});

gulp.task('scripts-vendor', function() {
    return gulp.src('bower_components/angular/angular.min.js')
        .pipe(plumber())
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest('public/scripts'))
        .pipe(notify({message: 'Vendor task complete'}));
});

gulp.task('styles', function () {

    // Compile scss
    var scssStream = gulp.src('app/resources/scss/main.scss')
        .pipe(sass().on('error', sass.logError));

    // Retrieve css
    var cssStream = gulp.src('app/resources/css/**/*.css')
        .pipe(concat('css.css'));

    // Merge scss and css into styles.css
    return merge(scssStream, cssStream)
        .pipe(concat('styles.css'))
        .pipe(gulp.dest('public/styles'))
        .pipe(notify({message: 'Styles task complete'}));
});

// Copy fonts to public/fonts
gulp.task('fonts', function() {
    return gulp.src([
        'app/resources/fonts/**'])
        .pipe(gulp.dest('public/fonts/'));
});

gulp.task('watch', function () {
    gulp.start('default');
    gulp.watch('app/resources/js/**/*.js', ['scripts']);
    gulp.watch([
        'app/resources/scss/**/*.scss',
        'app/resources/css/**/*.css'
    ], ['styles']);
});