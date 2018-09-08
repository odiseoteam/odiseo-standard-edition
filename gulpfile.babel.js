import chug from 'gulp-chug';
import gulp from 'gulp';
import yargs from 'yargs';

const { argv } = yargs
  .options({
    rootPath: {
      description: '<path> path to web assets directory',
      type: 'string',
      requiresArg: true,
      required: false,
    },
    nodeModulesPath: {
      description: '<path> path to node_modules directory',
      type: 'string',
      requiresArg: true,
      required: false,
    },
  });

const vendorConfig = [
  '--rootPath',
  argv.rootPath || '../../../public/assets',
  '--nodeModulesPath',
  argv.nodeModulesPath || '../../../node_modules',
];

const appConfig = [
  '--rootPath',
  '../public/assets',
  '--nodeModulesPath',
  '../node_modules',
];

export const buildOdiseoAdmin = function buildOdiseoAdmin() {
  return gulp.src('vendor/odiseoteam/odiseo-admin-bundle/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: vendorConfig }));
};
buildOdiseoAdmin.description = 'Build odiseo admin assets.';

export const watchOdiseoAdmin = function watchOdiseoAdmin() {
  return gulp.src('vendor/odiseoteam/odiseo-admin-bundle/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: vendorConfig, tasks: 'watch' }));
};
watchOdiseoAdmin.description = 'Watch odiseo admin assets.';

export const buildAdmin = function buildAdmin() {
  return gulp.src('gulp_tasks/admin.babel.js', { read: false })
    .pipe(chug({ args: appConfig }));
};
buildAdmin.description = 'Build admin assets.';

export const watchAdmin = function watchAdmin() {
  return gulp.src('gulp_tasks/admin.babel.js', { read: false })
    .pipe(chug({ args: appConfig, tasks: 'watch' }));
};
watchAdmin.description = 'Watch admin asset sources and rebuild on changes.';

export const buildApp = function buildApp() {
  return gulp.src('gulp_tasks/app.babel.js', { read: false })
    .pipe(chug({ args: appConfig }));
};
buildApp.description = 'Build app assets.';

export const watchApp = function watchApp() {
  return gulp.src('gulp_tasks/app.babel.js', { read: false })
    .pipe(chug({ args: appConfig, tasks: 'watch' }));
};
watchApp.description = 'Watch app asset sources and rebuild on changes.';

export const build = gulp.parallel(buildOdiseoAdmin, buildAdmin, buildApp);
build.description = 'Build assets.';

gulp.task('admin', buildAdmin);
gulp.task('admin-watch', watchAdmin);
gulp.task('app', buildApp);
gulp.task('app-watch', watchApp);

export default build;