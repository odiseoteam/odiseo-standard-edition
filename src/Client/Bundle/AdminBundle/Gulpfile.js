var concat = require('gulp-concat');
var env = process.env.GULP_ENV;
var gulp = require('gulp');
var gulpif = require('gulp-if');
var livereload = require('gulp-livereload');
var merge = require('merge-stream');
var order = require('gulp-order');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var argv = require('yargs').argv;

var rootPath = argv.rootPath;
var adminRootPath = rootPath + 'admin/';
var nodeModulesPath = argv.nodeModulesPath;

var paths = {
    admin: {
        js: [
            nodeModulesPath + 'chart.js/dist/Chart.js',
            'Resources/private/js/dashboard.js'
        ]
    }
};

gulp.task('client-admin-js', function () {
    return gulp.src(paths.admin.js)
        .pipe(concat('client-admin.js'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(adminRootPath + 'js/'))
        ;
});

gulp.task('client-admin-watch', function() {
    gulp.watch(paths.admin.js, ['client-admin-js']);
});

gulp.task('default', ['client-admin-js', 'client-admin-watch']);
gulp.task('watch', ['default', 'app-watch']);