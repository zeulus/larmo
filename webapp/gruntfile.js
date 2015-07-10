module.exports = function(grunt) {
    var jsFiles = [
        'src/lang/*.js',
        'src/filters/*.js',
        'src/controllers/*.js',
        'src/services/*.js'
    ];

    grunt.initConfig({
        'uglify': {
            'js': {
                'src': jsFiles,
                'dest': 'public/application.min.js'
            }
        },
        'watch': {
            'js': {
                'files': jsFiles,
                'tasks': ['uglify']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
};
