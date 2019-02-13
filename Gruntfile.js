const sass = require('node-sass');

module.exports = function(grunt) {
	grunt.file.defaultEncoding = 'utf8';
	grunt.file.preserveBOM = true;

	const username = process.env.USER || process.env.USERNAME;

	grunt.initConfig({
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js'
			]
		},
		jsvalidate: {
			files: [
				'<%= jshint.all %>'
			]
		},
		uglify: {
			dist: {
				files: {
					'public/js/iis-pack-password-strength-meter.min.js': [
						'public/js/wp-password-strength-meter.js',
						'public/js/iis-pack-password-strength-meter.js',
					]
				}
			}
		},
		clean: {
			dist: [
				'public/js/iis-pack-password-strength-meter.min.js',
				'public/js/iis-pack-password-strength-meter.*.min.js'
			]
		},
		watch: {
			css: {
				files: 'public/css/src/*.scss',
				tasks: [ 'clean', 'sass', 'cssmin', 'version' ],
				options: {
					spawn: false,
				},
			},
			js: {
				files: [
					'<%= jshint.all %>',
					'public/js/iis-pack-password-strength-meter.js',
				],
				tasks: ['uglify', 'version'],
				options: {
					spawn: false,
				},
			},
		},
		sass: {
			options: {
				'sourceMap': false,
				'implementation': sass
			},
			dist: {
				files: {
					'public/css/iis-pack-public.css': 'public/css/src/source-iis-pack-public.scss'
				}
			}
		},
		cssmin: {
			add_banner: {
				options: {
					banner: '/* This is a generated file, no changes here please, thanks. */'
					// processImport: false
				},
				files: {
					'public/css/iis-pack-public.min.css': [
						"public/css/iis-pack-public.css"
					]
				}
			}
		},
		version: {
			assets: {
				src: ['public/js/iis-pack-password-strength-meter.min.js','public/css/iis-pack-public.min.css'],
				dest: 'public/class-iis-pack-public.php'
			}
		},
		phplint: {
			options: {
				swapPath: '/tmp'
			},
			all: [
				'./**/*.php'
			]
		},
		phpcs: {
			application: {
				dir: ['.']
			},
			options: {
				bin: 'phpcs -p --standard=wordpress-rules.xml',
				report: 'summary'
			}
		},
		gitinfo: {
			options: {
				cwd: '.'
			}
		},
	});

	// Register tasks
	grunt.registerTask('default', [
		'clean',
		'sass',
		'cssmin',
		'uglify',
		'version'
	]);

	grunt.registerTask('multiversion', 'more than one file to wp-version', function(mode) {
		var config = {
			assets: {
				src: ['public/js/iis-pack-public.min.js','public/js/iis-pack-password-strength-meter.min.js','public/css/iis-pack-public.min.css'],
				dest: 'public/class-iis-pack-public.php'
			}
		};
		grunt.config.set('version', config);
		grunt.task.run('version');
	});

	grunt.registerTask('dev', [
		'watch'
	]);

	grunt.registerTask('test', [
		'jshint',
		'jsvalidate',
		'phplint',
		'phpcs'
	]);

    // Load tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
};
