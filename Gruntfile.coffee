module.exports = (grunt) ->

  grunt.initConfig
    connect:
      server:
        options:
          port: 1337
          hostname: '*'
          base: './'
          keepalive: true
          open: true

  grunt.loadNpmTasks 'grunt-contrib-connect'

  grunt.registerTask 'default',           ['connect']
