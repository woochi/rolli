module.exports = ( grunt ) ->
  'use strict'

  shim = require('browserify-shim')
  coffeeify = require('coffeeify')
  # Load all grunt tasks
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks)

  grunt.initConfig
    pkg: grunt.file.readJSON("package.json")
    sass:
      options:
        compass: true
      theme:
        options:
          loadPath: ["bower_components/foundation/scss"]
        files:
          "build/style.css": "app/assets/stylesheets/theme/index.sass"
      admin:
        files:
          "build/admin.css": "app/assets/stylesheets/admin/index.sass"
    cssmin:
      options:
        keepSpecialComments: 1
      compress:
        files: [
          'build/style.css': ['build/style.css']
          "build/admin.css": ["build/admin.css"]
        ]
    browserify:
      options:
        transform: ["coffeeify"]
      theme:
        files:
          "build/javascripts/theme.js": ["app/assets/javascripts/theme.coffee"]
      preview:
        files:
          "build/javascripts/preview.js": ["app/assets/javascripts/preview.coffee"]
    uglify:
      options:
        banner: '/*! <%= pkg.name %> v<%= pkg.version %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
        report: 'gzip'
      dist:
        files:
          'build/javascripts/theme.js': 'build/javascripts/theme.js'
      preview:
        files:
          'build/javascripts/preview.js': 'build/javascripts/preview.js'
    copy:
      build:
        files: [
          {expand: true, flatten: true, src: ['app/templates/**'], dest: 'build/', filter: 'isFile'}
          {expand: true, flatten: true, src: ['app/functions/**'], dest: 'build/', filter: 'isFile'}
          {expand: true, flatten: true, src: ['app/includes/**'], dest: 'build/includes', filter: 'isFile'}
          {expand: true, flatten: true, cwd: "app/assets/", src: ['images/**/*'], dest: 'build/images', filter: "isFile"}
          {expand: true, flatten: true, cwd: "app/assets/", src: ['images/screenshot.png'], dest: 'build/'}
          {expand: true, flatten: true, cwd: "vendor/javascripts", src: ['head.min.js'], dest: 'build/javascripts'}
        ]
    watch:
      options:
        livereload: true
      sass:
        files: ["app/assets/stylesheets/theme/**/*.sass", "app/assets/stylesheets/**/*.scss"]
        tasks: ["sass:theme"]
      scripts:
        files: ["app/assets/javascripts/**/*.coffee"]
        tasks: ["browserify"]
      php:
        files: ["app/templates/**/*.php", "app/functions/**/*.php", "app/includes/**/*.php"]
        tasks: ["copy"]
      admin:
        files: ["app/assets/stylesheets/admin/**/*.sass", "app/assets/stylesheets/admin/**/*.scss"]
        tasks: ["sass:admin"]
    clean: ['build', "package"]
    zip:
      'package/talon.zip': ['build/**/*']
    bower:
      build:
        dest: "vendor/javascripts"
        options:
          packageSpecific:
            'velocity':
              files: ["velocity.ui.js"]
    rsync:
      production:
        options:
          src: "build/"
          dest: "/var/www/wp-content/themes/rolli"
          host: "root@128.199.42.152"
          recursive: true
          delete: true

  grunt.registerTask "default", ["clean", "bower", "browserify", "copy", "sass", "watch"]
  grunt.registerTask "package", ["clean", "bower", "browserify", "copy", "sass", "cssmin", "uglify", "zip"]
  grunt.registerTask "deploy", ["clean", "bower", "browserify", "copy", "sass", "cssmin", "uglify", "rsync:production"]
