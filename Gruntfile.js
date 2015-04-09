module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		clean: {
			build: {
				src: ['dist/']
			}
		},

		copy: {
			main: {
				expand: true,
				cwd: 'src',
				src: ['**', '!assets/css/**', '!**/*.jade'],
				dest: 'dist/',
			},
		},

		jadephp: {
			options: {
				pretty: true
			},
			compile: {
				expand: true,
				cwd: 'src/',
				src: 'layouts/**/*.twig.jade',
				dest: 'dist/',
				ext: '.twig'
			}
		},

		sass: {
			dist: {
				options: {
					style: 'compressed'
				},
				files: {
					'dist/style.css': 'src/assets/css/main.sass'
				}
			}
		},

		autoprefixer: {
			no_dest: {
				src: 'dist/style.css'
			},
			options: {
				map: true
			}
		},

		htmlmin: {
			dist: {
				options: {
					removeComments: true,
					collapseWhitespace: true
				},
				files: [
					{
						expand: true,
						cwd: 'dist/',
						src: '**/*.twig',
						dest: 'dist/',
						ext: '.twig'
					},
				],
			}
		},

		'class-id-minifier': {
			simple: {
				options: {
					jsMapFile: 'dist/map.js',
					jsMapDevFile: 'dist/map.dev.js'
				},
				files: [
					{
						expand: true,
						cwd: 'dist/',
						src: '**/*.{twig,css,js}',
						dest: 'dist/'
					}
				]
			}
		},

		watch: {
			options: {
				livereload: true,
				spawn: true
			},

			php: {
				files: ['src/**/*.php'],
				tasks: ['copy']
			},

			jade: {
				files: ['src/layouts/**/*.jade'],
				tasks: ['jadephp']
			},

			css: {
				files: ['src/assets/css/**/*.sass', 'src/assets/css/**/*.scss'],
				tasks: ['sass']
			},

			img: {
				files: ['src/**/*.jpg', 'src/**/*.png'],
				tasks: ['copy']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-jade-php');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-autoprefixer');

	grunt.loadNpmTasks('grunt-contrib-htmlmin');
	grunt.loadNpmTasks('grunt-class-id-minifier');

	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('build-dev',        ['clean', 'copy', 'jadephp', 'sass', 'autoprefixer']);
	grunt.registerTask('build-production', ['build-dev', 'htmlmin', 'class-id-minifier']);
	grunt.registerTask('default',          ['build-dev', 'watch']);
};
