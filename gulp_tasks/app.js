var gulp = require('gulp');
var concat = require('gulp-concat');
var env = process.env.GULP_ENV;
var gulpif = require('gulp-if');
var livereload = require('gulp-livereload');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');

var nodeModulesPath = 'node_modules/';
var srcPath = 'assets/app';
var rootPath = 'public/assets/app/';

var paths = {
    app: {
        js: [
            nodeModulesPath + 'jquery/dist/jquery.min.js',
            nodeModulesPath + 'bootstrap/dist/js/bootstrap.min.js',
            nodeModulesPath + 'jquery-validation/dist/jquery.validate.min.js',
            srcPath + 'js/main.js'
        ],
        css: [
            nodeModulesPath + 'bootstrap/dist/css/bootstrap.min.css',
            nodeModulesPath + 'font-awesome/css/font-awesome.min.css',
            nodeModulesPath + 'animate.css/animate.min.css',
            srcPath + 'css/main.css'
        ],
        img: [
            srcPath + 'img/**'
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
        .pipe(gulp.dest(rootPath + 'js/'))
        .pipe(livereload())
    ;
});

gulp.task('app-css', function () {
    return gulp.src(paths.app.css)
        .pipe(concat('app.css'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(rootPath + 'css/'))
        .pipe(livereload())
    ;
});

gulp.task('app-img', function() {
    return gulp.src(paths.app.img)
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(rootPath + 'img/'))
        .pipe(livereload())
    ;
});

gulp.task('app-fonts', function() {
    return gulp.src(paths.app.fonts)
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(rootPath + 'fonts/'))
        .pipe(livereload())
    ;
});

gulp.task('app-watch', function () {
    livereload.listen();

    gulp.watch(paths.app.js, ['app-js']);
    gulp.watch(paths.app.css, ['app-css']);
    gulp.watch(paths.app.img, ['app-img']);
    gulp.watch(paths.app.fonts, ['app-fonts']);
});

gulp.task('app', ['app-js', 'app-css', 'app-img', 'app-fonts']);