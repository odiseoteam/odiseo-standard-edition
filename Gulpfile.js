var gulp = require('gulp');
var chug = require('gulp-chug');
var argv = require('yargs').argv;

config_admin = [
    '--rootPath',
    argv.rootPath || '../../../web/assets/',
    '--nodeModulesPath',
    argv.nodeModulesPath || '../../../node_modules/'
];

config_app = [
    '--rootPath',
    argv.rootPath || '../../../../web/assets/',
    '--nodeModulesPath',
    argv.nodeModulesPath || '../../../../node_modules/'
];

gulp.task('admin', function() {
    gulp.src('vendor/odiseoteam/odiseo-backend-bundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config_admin }))
    ;
});

gulp.task('app', function() {
    gulp.src('src/Odiseo/Bundle/AppBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config_app }))
    ;
});
gulp.task('default', ['admin', 'app']);