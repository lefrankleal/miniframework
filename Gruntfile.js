module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      dev: {
        options: {
          mangle: {
            reserved: ['jQuery']
          }
        },
        files: [{
          expand: true,
          ext: '.min.js',
          src: ['assets/js/**/*.js', '!assets/js/**/*.min.js'],
        }]
      }
    },
    cssmin: {
      target: {
        files: [{
          expand: true,
          ext: '.min.css',
          src: ['assets/css/**/*.css', '!assets/css/**/*.min.css'],
        }]
      }
    }
  });
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.registerTask('default', ['uglify', 'cssmin']);
};