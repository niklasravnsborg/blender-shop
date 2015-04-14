var yaml = require('js-yaml');
var fs = require('fs');
var data = {}; // objects coverted from YAML will be stored here

// used to merge two Objects
function extend(destination, source) {
	for (var property in source) {
		destination[property] = source[property];
	}
}

// load YAML from src/data/ and add it to data object
(function loadYaml() {
	var fileMatch = '.yml';
	var dir = 'src/data/';

	if (fs.existsSync(dir)) {
		var files = fs.readdirSync(dir);
		for (var i in files) {
			if (files[i].match(fileMatch + '$') == fileMatch) {
				extend(data, yaml.load(fs.readFileSync(dir + files[i])));
			}
		}
	}
})();


module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		clean: {
			build: {
				src: 'dist/'
			}
		},

		copy: {
			main: {
				expand: true,
				cwd: 'src',
				src: [
					'*.*',
					'assets/**/*',
					'!assets/css/**'
				],
				dest: 'dist/',
			},
		},

		jade: {
			options: {
				data: data,
				pretty: true,
				basedir: 'src/'
			},
			compile: {
				expand: true,
				cwd: 'src/',
				src: 'templates/layouts/**/*.jade',
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
					'dist/assets/css/main.css': 'src/assets/css/main.sass'
				}
			}
		},

		autoprefixer: {
			no_dest: {
				src: 'dist/assets/css/main.css'
			},
			options: {
				map: true
			}
		},

		htmlmin: {
			dist: {
				options: {
					removeComments: true,
					collapseWhitespace: true,
					keepClosingSlash: true // to maintain SVG structure
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
				files: ['src/templates/**/*.jade', 'src/data/*.yml'],
				tasks: ['jade']
			},

			css: {
				files: ['src/assets/css/**/*.{sass,scss}'],
				tasks: ['sass']
			},

			img: {
				files: ['src/**/*.{jpg,png,svg}'],
				tasks: ['copy']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-jade');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-autoprefixer');

	grunt.loadNpmTasks('grunt-contrib-htmlmin');
	grunt.loadNpmTasks('grunt-class-id-minifier');

	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('build-dev',        ['clean', 'copy', 'jade', 'sass', 'autoprefixer']);
	grunt.registerTask('build-production', ['build-dev', 'htmlmin', 'class-id-minifier']);
	grunt.registerTask('default',          ['build-dev', 'watch']);
};
