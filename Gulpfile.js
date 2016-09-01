var gulp = require('gulp');
var ts = require('gulp-typescript');

var SOURCE_PATH = 'src/**/*.ts';
var APP_PATH = 'app/';

gulp.task('compile' , function(){
    return gulp.src(SOURCE_PATH)
        .pipe(ts({"target": "es5", "module": "commonjs", "sourceMap": true}))
        .pipe(gulp.dest(APP_PATH));
});

gulp.task('watch', function () {
    gulp.watch(SOURCE_PATH, ['compile']);
});
