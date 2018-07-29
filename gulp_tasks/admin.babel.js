import { uglify } from 'rollup-plugin-uglify';
import concat from 'gulp-concat';
import gulp from 'gulp';
import gulpif from 'gulp-if';
import livereload from 'gulp-livereload';
import sourcemaps from 'gulp-sourcemaps';
import upath from 'upath';
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
const rootPath = upath.joinSafe(upath.normalizeSafe(argv.rootPath), 'admin');
const sourcePath = upath.normalizeSafe('../source_assets/admin');
const nodeModulesPath = upath.normalizeSafe(argv.nodeModulesPath);

const paths = {
    admin: {
        js: [
            upath.joinSafe(nodeModulesPath, 'chart.js/dist/Chart.js'),
            upath.joinSafe(sourcePath, 'js/**'),
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

export const buildAdminJs = function buildAdminJs() {
    return gulp.src(paths.admin.js, { base: './' })
        .pipe(gulpif(env !== 'prod', sourcemaps.init()))
        .pipe(concat('app-admin.js'))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(gulpif(env !== 'prod', sourcemaps.mapSources(mapSourcePath)))
        .pipe(gulpif(env !== 'prod', sourcemaps.write('./')))
        .pipe(gulp.dest(upath.joinSafe(rootPath, 'js')))
        .pipe(livereload());
};
buildAdminJs.description = 'Build admin js assets.';

export const watchAdmin = function watchAdmin() {
    livereload.listen();

    gulp.watch(paths.admin.js, buildAdminJs);
};
watchAdmin.description = 'Watch admin asset sources and rebuild on changes.';

export const build = gulp.parallel(buildAdminJs);
build.description = 'Build assets.';

export const watch = gulp.parallel(build, watchAdmin);
watch.description = 'Watch asset sources and rebuild on changes.';

export default build;