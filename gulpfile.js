const { src, dest, watch, series, parallel } = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const concat = require('gulp-concat')
const postcss = require('gulp-postcss')
const terser = require('gulp-terser')
const autoprefixer = require('autoprefixer')
const cssnano = require('cssnano')

function stylesTask() {
    return src('source/style/style.scss', {sourcemaps: true})
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(dest('.', {sourcemaps: '.'}))
}

function editorStylesTask() {
    return src('source/style/style-editor.scss', {sourcemaps: true})
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(dest('.', {sourcemaps: '.'}))
}

function scriptsTask() {
    return src(
        [
            'source/scripts/scripts.js',
            'source/scripts/**/*.js',
        ], { sourcemaps: true })
        .pipe(concat('scripts.js'))
        .pipe(terser())
        .pipe(dest('.', { sourcemaps: '.' }))
}

function watchTask() {
    watch(['source', 'blocks'],
        parallel(stylesTask, editorStylesTask, scriptsTask)
    )
}

exports.default = parallel(stylesTask, editorStylesTask, scriptsTask)
exports.watch = series(watchTask)
