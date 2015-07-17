module.exports = function(grunt) {
    var jsFiles = [
        'src/lang/*.js',
        'src/filters/*.js',
        'src/controllers/*.js',
        'src/services/*.js'
    ];

    var sassFiles = [
        'styles/main.scss'
    ];

    grunt.initConfig({
        'uglify': {
            'js': {
                'src': jsFiles,
                'dest': 'public/application.min.js'
            }
        },
        'sass': {
            dist: {
                options: {
                    'sourcemap': 'none',
                    'style': 'expanded'
                },
                files: {
                    'public/style.css': sassFiles
                }
            }

        },
        'cssmin': {
            'css': {
                'src': 'public/style.css',
                'dest': 'public/style.min.css'
            }
        },
        'includeSource': {
            myTarget: {
                files: {
                    'views/scripts_include/dev.html': 'views/dev_scripts_include.tpl.html'
                }
            }
        },
        'watch': {
            'js': {
                'files': jsFiles.concat(sassFiles),
                'tasks': ['uglify', 'sass', 'cssmin', 'includeSource']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-include-source');
};
