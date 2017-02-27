var gulp = require('gulp');
var chug = require('gulp-chug');
var argv = require('yargs').argv;

config_vendor = [
    '--rootPath',
    argv.rootPath || '../../../web/assets/',
    '--nodeModulesPath',
    argv.nodeModulesPath || '../../../node_modules/'
];

config_src = [
    '--rootPath',
    argv.rootPath || '../../../../web/assets/',
    '--nodeModulesPath',
    argv.nodeModulesPath || '../../../../node_modules/'
];

gulp.task('odiseo-admin', function() {
    gulp.src('vendor/odiseoteam/odiseo-admin-bundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config_vendor }))
    ;
});

gulp.task('client-admin', function() {
    gulp.src('src/Client/Bundle/AdminBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config_src }))
    ;
});

gulp.task('client-app', function() {
    gulp.src('src/Client/Bundle/AppBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config_src }))
    ;
});

gulp.task('default', ['odiseo-admin', 'client-admin', 'client-app']);