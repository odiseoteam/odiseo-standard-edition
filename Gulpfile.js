var gulp = require('gulp');
var requireDir = require('require-dir');

requireDir('./gulp_tasks');

gulp.task('default', ['odiseo-admin', 'admin', 'app']);
gulp.task('watch', ['odiseo-admin', 'admin-watch', 'app-watch']);