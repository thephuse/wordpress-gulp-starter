'use strict'

const fs = require('fs')
const gulp = require('gulp')
const watch = require('gulp-watch')
const rimraf = require('gulp-rimraf')
const stylus = require('gulp-stylus')
const rename = require('gulp-rename')
const plumber = require('gulp-plumber')
const webpack = require('webpack-stream')
const autoprefixer = require('gulp-autoprefixer')
const browserSync = require('browser-sync').create()

const manifest = JSON.parse(fs.readFileSync('./package.json'))

const src = './src'
const theme = `./wordpress/wp-content/themes/${manifest.name}`
const staticFiles = `*.{png,gif,jpg,jpeg,svg,php,json,txt,twig,css}`

const manifestTask = function() {
  let tmpl =
    `/*
    Theme Name: ${manifest.longName}
    Description: ${manifest.description}
    Version: ${manifest.version}
    Author: ${manifest.author}
    */`
  return fs.writeFileSync(`${src}/style.css`, tmpl, 'utf8')
}

const cleanTask = function() {
  return gulp.src(`${theme}/**/*`, { read : false })
    .pipe(rimraf())
}

const watchTask = function() {
  browserSync.init()
  watch(`${src}/js/**/*.js`, webpackTask)
  watch(`${src}/styl/**/*.styl`, stylusTask)
  watch(`${src}/**/${staticFiles}`, function() {
    copyTask()
    return browserSync.reload()
  })
  watch(`${theme}/main.js`, browserSync.reload)
}

const copyTask = function() {
  return gulp.src([`${src}/**/${staticFiles}`], { base : `${src}` })
    .pipe(gulp.dest(`${theme}`))
}

const stylusTask = function() {
  return gulp.src(`${src}/styl/main.styl`)
    .pipe(plumber())
    .pipe(stylus())
    .pipe(autoprefixer({
      browsers : ['last 3 versions', 'ie 9-11'],
      cascade: false
    }))
    .pipe(gulp.dest(`${theme}/`))
    .pipe(browserSync.stream())
}

const webpackTask = function() {
  return gulp.src(`${src}/js/main.js`)
    .pipe(plumber())
    .pipe(webpack({
      module: {
        loaders: [
          {
            test: /\.js$/,
            exclude: /(node_modules)/,
            loader: 'babel?presets[]=es2015'
          }
        ],
      }
    }))
    .pipe(rename(path => {
      path.basename = 'main'
    }))
    .pipe(gulp.dest(`${theme}/`))
}

gulp.task('manifest', manifestTask)
gulp.task('clean', cleanTask)
gulp.task('copy', copyTask)
gulp.task('stylus', stylusTask)
gulp.task('webpack', ['copy'], webpackTask)
gulp.task('make', ['manifest', 'copy', 'webpack', 'stylus'])
gulp.task('watch', watchTask)
gulp.task('dev', ['make', 'watch'])
