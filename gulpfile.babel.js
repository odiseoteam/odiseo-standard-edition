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

const env = process.env.GULP_ENV;
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
    .pipe(chug({ args: vendorConfig, tasks: 'build' }));
};
buildOdiseoAdmin.description = 'Build odiseo admin assets.';

export const watchOdiseoAdmin = function watchOdiseoAdmin() {
  return gulp.src('vendor/odiseoteam/odiseo-admin-bundle/gulpfile.babel.js', { read: false })
    .pipe(chug({ args: vendorConfig, tasks: 'watch' }));
};
watchOdiseoAdmin.description = 'Watch odiseo admin assets.';

export const buildAdmin = function buildAdmin() {
  return gulp.src('gulp_tasks/admin.babel.js', { read: false })
    .pipe(chug({ args: appConfig, tasks: 'build' }));
};
buildAdmin.description = 'Build admin assets.';

export const watchAdmin = function watchAdmin() {
  return gulp.src('gulp_tasks/admin.babel.js', { read: false })
    .pipe(chug({ args: appConfig, tasks: 'watch' }));
};
watchAdmin.description = 'Watch admin asset sources and rebuild on changes.';

export const build = gulp.series(gulp.parallel(buildOdiseoAdmin, buildAdmin));
build.description = 'Build assets.';

export const watch = gulp.series(gulp.parallel(watchOdiseoAdmin, watchAdmin));
watch.description = 'Watch asset sources and rebuild on changes.';

gulp.task('odiseo-admin', buildOdiseoAdmin);
gulp.task('odiseo-admin-watch', watchOdiseoAdmin);
gulp.task('admin', buildAdmin);
gulp.task('admin-watch', watchAdmin);

export default build;