var gulp = require('gulp');
var notify = require("gulp-notify");
var sass = require('gulp-sass');

gulp.task('default', ['styles']);


gulp.task('styles', function () {
    gulp.src('app/resources/scss/main.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('public/styles'))
        .pipe(notify({message: 'Styles task complete'}));
});

gulp.task('fonts', function() {
    return gulp.src([
        'app/resources/fonts/**'])
        .pipe(gulp.dest('public/fonts/'));
});

gulp.task('watch', function () {
    gulp.start('default');
    gulp.watch('app/resources/scss/**/*.scss', ['styles']);
});