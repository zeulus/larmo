module.exports = function(grunt) {
    var jsFiles = [
        'src/lang/*.js',
        'src/filters/*.js',
        'src/controllers/*.js',
        'src/services/*.js'
    ];

    var sassFiles = [
        'styles/layout.scss'
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
        'watch': {
            'js': {
                'files': jsFiles.concat(sassFiles),
                'tasks': ['uglify', 'sass', 'cssmin']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
};
