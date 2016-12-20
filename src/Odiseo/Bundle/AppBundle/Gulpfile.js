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
var appRootPath = rootPath + 'app/';
var nodeModulesPath = argv.nodeModulesPath;

var paths = {
    app: {
        js: [
            nodeModulesPath + 'jquery/dist/jquery.min.js',
            nodeModulesPath + 'bootstrap/dist/js/bootstrap.min.js',
            'Resources/public/js/main.js'
        ],
        css: [
            nodeModulesPath + 'bootstrap/dist/css/bootstrap.min.css',
            nodeModulesPath + 'font-awesome/css/font-awesome.min.css',
            'Resources/public/css/main.css'
        ],
        img: [
            'Resources/public/img/**'
        ],
        fonts: [
            nodeModulesPath + 'bootstrap/dist/fonts/**',
            nodeModulesPath + 'font-awesome/fonts/**'
        ]
    }
};

gulp.task('app-js', function () {
    return gulp.src(paths.app.js)
        .pipe(concat('app.js'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(appRootPath + 'js/'))
    ;
});

gulp.task('app-css', function () {
    return gulp.src(paths.app.css)
        .pipe(concat('app.css'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(appRootPath + 'css/'))
    ;
});

gulp.task('app-img', function() {
    return gulp.src(paths.app.img)
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(appRootPath + 'img/'))
    ;
});

gulp.task('app-fonts', function() {
    return gulp.src(paths.app.fonts)
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(appRootPath + 'fonts/'))
        .pipe(livereload())
    ;
});

gulp.task('app-watch', function() {
    livereload.listen();

    gulp.watch(paths.app.js, ['app-js']);
    gulp.watch(paths.app.css, ['app-css']);
    gulp.watch(paths.app.img, ['app-img']);
});

gulp.task('default', ['app-js', 'app-css', 'app-img', 'app-fonts']);
gulp.task('watch', ['default', 'app-watch']);