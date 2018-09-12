import { uglify } from 'rollup-plugin-uglify';
import concat from 'gulp-concat';
import gulp from 'gulp';
import gulpif from 'gulp-if';
import livereload from 'gulp-livereload';
import merge from 'merge-stream';
import order from 'gulp-order';
import sourcemaps from 'gulp-sourcemaps';
import upath from 'upath';
import uglifycss from 'gulp-uglifycss';
import yargs from 'yargs';

const { argv } = yargs.options({
  rootPath: {
    description: '<path> path to web assets directory',
    type: 'string',
    requiresArg: true,
    required: true,
  },
  nodeModulesPath: {
    description: '<path> path to node_modules directory',
    type: 'string',
    requiresArg: true,
    required: false,
  },
});

const env = process.env.GULP_ENV;
const rootPath = upath.joinSafe(upath.normalizeSafe(argv.rootPath), 'app');
const sourcePath = upath.normalizeSafe('../source_assets/app');
const nodeModulesPath = upath.normalizeSafe(argv.nodeModulesPath);

const paths = {
  app: {
    js: [
      upath.joinSafe(nodeModulesPath, 'jquery/dist/jquery.min.js'),
      upath.joinSafe(nodeModulesPath, 'bootstrap/dist/js/bootstrap.min.js'),
      upath.joinSafe(nodeModulesPath, 'jquery-validation/dist/jquery.validate.min.js'),
      upath.joinSafe(sourcePath, 'js/main.js'),
    ],
    css: [
      upath.joinSafe(nodeModulesPath, 'bootstrap/dist/css/bootstrap.min.css'),
      upath.joinSafe(nodeModulesPath, 'font-awesome/css/font-awesome.min.css'),
      upath.joinSafe(nodeModulesPath, 'animate.css/animate.min.css'),
      upath.joinSafe(sourcePath, 'css/main.css'),
    ],
    img: [
      upath.joinSafe(sourcePath, 'images/**'),
    ],
    fonts: [
      upath.joinSafe(nodeModulesPath, 'bootstrap/dist/fonts/**'),
      upath.joinSafe(nodeModulesPath, 'font-awesome/fonts/**'),
    ],
  },
};

const sourcePathMap = [
  {
    sourceDir: upath.relative('', nodeModulesPath),
    destPath: '/node_modules/',
  },
];

const mapSourcePath = function mapSourcePath(sourcePath) {
  const match = sourcePathMap.find(({ sourceDir }) => (
    sourcePath.substring(0, sourceDir.length) === sourceDir
  ));

  if (!match) {
    return sourcePath;
  }

  const { sourceDir, destPath } = match;

  return upath.joinSafe(destPath, sourcePath.substring(sourceDir.length));
};

export const buildAppJs = function buildAppJs() {
  return gulp.src(paths.app.js, { base: './' })
    .pipe(gulpif(env !== 'prod', sourcemaps.init()))
    .pipe(concat('app.js'))
    .pipe(gulpif(env === 'prod', uglify()))
    .pipe(gulpif(env !== 'prod', sourcemaps.mapSources(mapSourcePath)))
    .pipe(gulpif(env !== 'prod', sourcemaps.write('./')))
    .pipe(gulp.dest(upath.joinSafe(rootPath, 'js')))
    .pipe(livereload());
};
buildAppJs.description = 'Build app js assets.';

export const buildAppCss = function buildAppCss() {
  const cssStream = gulp.src(paths.app.css, { base: './' })
    .pipe(gulpif(env !== 'prod', sourcemaps.init()))
    .pipe(concat('css-files.css'));


  return merge(cssStream)
    .pipe(order(['css-files.css']))
    .pipe(concat('app.css'))
    .pipe(gulpif(env === 'prod', uglifycss()))
    .pipe(gulpif(env !== 'prod', sourcemaps.mapSources(mapSourcePath)))
    .pipe(gulpif(env !== 'prod', sourcemaps.write('./')))
    .pipe(gulp.dest(upath.joinSafe(rootPath, 'css')))
    .pipe(livereload());
};
buildAppCss.description = 'Build app css assets.';

export const buildAppImg = function buildAppImg() {
  return merge(
    gulp.src(paths.app.img)
      .pipe(gulp.dest(upath.joinSafe(rootPath, 'images'))),
  );
};
buildAppImg.description = 'Build app img assets.';

export const buildAppFonts = function buildAppFonts() {
  return merge(
    gulp.src(paths.app.fonts)
      .pipe(gulp.dest(upath.joinSafe(rootPath, 'fonts'))),
  );
};
buildAppFonts.description = 'Build app fonts assets.';

export const watchApp = function watchApp() {
  livereload.listen();

  gulp.watch(paths.app.js, buildAppJs);
  gulp.watch(paths.app.css, buildAppCss);
  gulp.watch(paths.app.img, buildAppImg);
  gulp.watch(paths.app.fonts, buildAppFonts);
};
watchApp.description = 'Watch app asset sources and rebuild on changes.';

export const build = gulp.parallel(buildAppJs, buildAppCss, buildAppImg, buildAppFonts);
build.description = 'Build assets.';

export const watch = gulp.parallel(watchApp);
watch.description = 'Watch asset sources and rebuild on changes.';

export default build;