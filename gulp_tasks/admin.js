var gulp = require('gulp');
var chug = require('gulp-chug');
var concat = require('gulp-concat');
var env = process.env.GULP_ENV;
var gulpif = require('gulp-if');
var livereload = require('gulp-livereload');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var argv = require('yargs').argv;

var nodeModulesPath = 'node_modules/';
var srcPath = 'assets/admin';
var rootPath = 'public/assets/admin/';

var paths = {
    admin: {
        js: [
            nodeModulesPath + 'chart.js/dist/Chart.js',
            srcPath + 'js/**'
        ]
    }
};

config_vendor = [
    '--rootPath',
    argv.rootPath || '../../../public/assets/',
    '--nodeModulesPath',
    argv.nodeModulesPath || '../../../' + nodeModulesPath
];

gulp.task('odiseo-admin', function() {
    gulp.src('vendor/odiseoteam/odiseo-admin-bundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config_vendor }))
    ;
});

gulp.task('admin-js', function () {
    return gulp.src(paths.admin.js)
        .pipe(concat('app-admin.js'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(rootPath + 'js/'))
        .pipe(livereload())
    ;
});

gulp.task('admin-watch', function () {
    livereload.listen();

    gulp.watch(paths.admin.js, ['admin-js']);
});


gulp.task('admin', ['admin-js']);