'use strict';
module.exports = function(grunt) {
	grunt.file.defaultEncoding = 'utf8';
	grunt.file.preserveBOM = true;
	var username = process.env.USER || process.env.USERNAME;

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
			// options: {
		 //      mangle: false
		 //    },
			dist: {
				files: {
					'public/js/iis-pack-public.min.js': [
						'public/js/iis-pack-public.js',
					]
				}
			}
		},
		clean: {
			dist: [
				'public/js/iis-pack-public.min.js',
				'public/js/iis-pack-public.*.min.js',
				'public/css/iis-pack-public.*.min.css'
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
					'public/js/iis-pack-public.js',
				],
				tasks: ['uglify', 'version'],
				options: {
					spawn: false,
				},
			},
		},
		sass: {
			dist: {
				options: {
					'sourcemap': 'none'
				},
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
		// deploy via rsync
		// behöver grunt-rsync ~0.6.2 (package.json)
		rsync: {
			// allmänna inställningar för deploy
			options: {
				src: './',
				recursive: true,
				deleteAll: false,
				exclude: ['.git*', 'node_modules', 'wordpress-rules.xml', 'Gruntfile.js',
					'package.json', '.DS_Store', 'README.md', 'config.rb', '.jshintrc'],
				args: ["-t", "-O", "-p", "--chmod=Du=rwx,Dg=rwx,Do=rx,Fu=rw,Fg=rw,Fo=r"],
				// några egna för att underlätta
				pluginname: 'IIS Pack',
				basefolder: '/var/www/sites/',
				pluginfolder: '/wordpress/wp-content/plugins/iis-pack',
				nowordpressfolder: '/wp-content/plugins/iis-pack',
				hostservers: {
					stageserver: 'extweb1.stage.iis.se',
					prodserver: 'extweb1.common.iis.se'
				}
			},

		// speca respektive sajt här, kopiera stage respektive prod och
		// ändra taskname (ex. "stage_sajtkollen") samt ändra sajtnamnet (ex. stage.sajtkollen.se)
		// Kopiera på samma sätt i "slack" (nästa grunt-task)
			//sajtkollen
			stage_sajtkollen: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.sajtkollen.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_sajtkollen: {
				options: {
					dest: '<%= rsync.options.basefolder %>sajtkollen.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			stage_webbstjarnan: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.webbstjarnan.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_webbstjarnan: {
				options: {
					dest: '<%= rsync.options.basefolder %>webbstjarnan.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			// Speciella hostservrar och sökvägar för IIS
			stage_iis: {
				options: {
					dest: '<%= rsync.options.basefolder %>www.iis.se<%= rsync.options.pluginfolder %>',
					host: 'www-adm@extweb5.iis.se'
				}
			},
			prod_iis: {
				options: {
					dest: '<%= rsync.options.basefolder %>www.iis.se<%= rsync.options.pluginfolder %>',
					host: 'www-adm@extweb6.iis.se'
				}
			},
			stage_internetdagarna: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.internetdagarna.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_internetdagarna: {
				options: {
					dest: '<%= rsync.options.basefolder %>internetdagarna.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			stage_internetfonden: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.internetfonden.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_internetfonden: {
				options: {
					dest: '<%= rsync.options.basefolder %>internetfonden.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			stage_internetstatistik: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.internetstatistik.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_internetstatistik: {
				options: {
					dest: '<%= rsync.options.basefolder %>internetstatistik.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			stage_internetmuseum: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.internetmuseum.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_internetmuseum: {
				options: {
					dest: '<%= rsync.options.basefolder %>internetmuseum.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			stage_soi2013: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.soi2013.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_soi2013: {
				options: {
					dest: '<%= rsync.options.basefolder %>soi2013.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			// Sambi
			stage_sambi: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.sambi.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_sambi: {
				options: {
					dest: '<%= rsync.options.basefolder %>sambi.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			// seDirekt - saknar vanliga /wordpress/-foldern, använder "nowordpressfolder"
			stage_sedirekt: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.sedirekt.se<%= rsync.options.nowordpressfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_sedirekt: {
				options: {
					dest: '<%= rsync.options.basefolder %>sedirekt.se<%= rsync.options.nowordpressfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			// Skolfederation
			stage_skolfederation: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.www.skolfederation.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_skolfederation: {
				options: {
					dest: '<%= rsync.options.basefolder %>skolfederation.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			// arkiv.internetmuseum
			stage_internetarkiv: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.arkiv.internetmuseum.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_internetarkiv: {
				options: {
					dest: '<%= rsync.options.basefolder %>arkiv.internetmuseum.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			// datahotell.se
			stage_datahotell: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.datahotell.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_datahotell: {
				options: {
					dest: '<%= rsync.options.basefolder %>datahotell.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			// zonemaster.iis.se
			stage_zonemaster: {
				options: {
					dest: '<%= rsync.options.basefolder %>stage.zonemaster.iis.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.stageserver %>'
				}
			},
			prod_zonemaster: {
				options: {
					dest: '<%= rsync.options.basefolder %>zonemaster.iis.se<%= rsync.options.pluginfolder %>',
					host: '<%= rsync.options.hostservers.prodserver %>'
				}
			},
			//nästa sajt som ska gå att deploya till
		},
		slack: {
			options: {
				endpoint: 'https://hooks.slack.com/services/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',
				channel: '#webbgruppen',
				username: 'gruntbot',
				icon_emoji: ':rocket:',
				icon_url: 'https://slack.com/img/icons/app-57.png' // if icon_emoji not specified
			},
			// speca respektive sajt här, kopiera och ändra taskname (ex. "stage_sajtkollen")
			//sajtkollen
			stage_sajtkollen: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_sajtkollen: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			stage_webbstjarnan: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_webbstjarnan: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			stage_iis: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_iis: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			stage_internetdagarna: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_internetdagarna: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			stage_internetfonden: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_internetfonden: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			stage_internetstatistik: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_internetstatistik: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			stage_internetmuseum: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_internetmuseum: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			stage_soi2013: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_soi2013: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			// Sambi
			stage_sambi: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_sambi: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			// seDirekt
			stage_sedirekt: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_sedirekt: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			// skolfederation
			stage_skolfederation: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_skolfederation: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			// arkiv.internetmuseum
			stage_internetarkiv: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_internetarkiv: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			// datahotell.se
			stage_datahotell: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_datahotell: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			// zonemaster.iis.se
			stage_zonemaster: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			prod_zonemaster: {
				text: '[IIS Plugin: <%= rsync.options.pluginname %>] Deploy <%= grunt.task.current.nameArgs %>. OS-user: ' + username + ' GIT user: <%= gitinfo.local.branch.current.currentUser %> Commit number: <%= gitinfo.local.branch.current.shortSHA %> Branch: <%= gitinfo.local.branch.current.name %>'
			},
			//nästa sajt som ska gå att deploya till
		},
		version: {
			assets: {
				src: ['public/js/iis-pack-public.min.js','public/css/iis-pack-public.min.css'],
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

	// Load tasks
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// deploy reruns minification and concatenation before rsyncing the files
	// deploy:stage_sajtnamn and deploy:prod_sajtnamn are supported
	grunt.registerTask('deploy', 'deploy code to stage or prod', function(target) {
		if (target == null) {
			return grunt.warn('Build target must be specified, like deploy:stage_sajtnamn.');
		}
		grunt.task.run('clean');
		grunt.task.run('sass');
		grunt.task.run('cssmin');
		grunt.task.run('uglify');
		grunt.task.run('version');
		grunt.task.run('gitinfo');
		grunt.task.run('slack:' + target);
		grunt.task.run('rsync:' + target);
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
				src: ['public/js/iis-pack-public.min.js','public/css/iis-pack-public.min.css'],
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

};
