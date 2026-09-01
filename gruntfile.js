'use strict';
module.exports = function (grunt) {


  // Load the plugin

  // Default task(s).



  grunt.initConfig({
    // jshint: {
    //   options: {
    //     jshintrc: '.jshintrc'
    //   },
    //   all: [
    //     'Gruntfile.js',
    //     'assets/js/**/*.js',
    //     '!assets/build/app.min.js'
    //   ]
    // },
    babel: {
      options: {
        sourceMap: true
      },
      dist: {
        files: [{
          expand: true,
          cwd: 'assets/es6/',
          src: '*.js',
          dest: 'assets/compiled_js',
          rename: function (dst, src) {
            // To keep the source js files and make new files as `*.min.js`:
            return dst + '/' + src.replace('.js', '.compiled.js');
            // Or to override to src:
            // return src;
          }
        }]

      }
    },
    sass: {
      dist: {
        options: {
          style: 'compressed',
          compass: false,
          sourcemap: false
        },
        files: {
          'style.css': [
            'assets/scss/style.scss'
          ]
        }
      }
    },
    uglify: {
      dist: {
        files: [{
          expand: true,
          cwd: 'assets/',
          src: ['compiled_js/*.js', 'js/*.js'],
          dest: 'js',
          rename: function (dst, src) {
            // To keep the source js files and make new files as `*.min.js`:
            return dst + '/' + src.replace('.compiled', '').replace('.js', '.min.js').replace("compiled_js/", "").replace("js/", "");
            // Or to override to src:
            // return src;
          }
        }]


      }
    },


    watch: {
      options: {
        livereload: true
      },
      sass: {
        files: [
          'assets/scss/**/*.scss',
          'assets/scss/**/*.sass'
        ],
        tasks: ['sass']
      },
      js: {
        files: [
          'assets/js/**/*.js',
          'asets/compiled_js/*.js'
        ],
        // tasks: ['jshint', 'uglify']
        tasks: ['uglify']
      },
      babel: {
        files: [
          'assets/es6/*.js'
        ],
        // tasks: ['jshint', 'uglify']
        tasks: ['babel', 'uglify']
      },
      twig: {
        files: [
          '**/*.twig',
          '**/*.php'
        ],
        options: {
          spawn: false,
          livereload: true
        }

      },
      html: {
        files: [
          '**/*.html'
        ]
      }
    },
    clean: {
      dist: [
        'style.css',
        'assets/compiled_js/main_compiled.js'
      ]
    }
  });

  // Load tasks
  grunt.loadNpmTasks('grunt-babel');

  grunt.loadNpmTasks('grunt-contrib-clean');
  // grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  // grunt.loadNpmTasks('grunt-libsass');


  // Register tasks
  grunt.registerTask('default', [
    'clean',
    'sass',
    'babel',
    'uglify'
  ]);
  grunt.registerTask('dev', [
    'watch'
  ]);

};