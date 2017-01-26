var sassIncl = require('sass-include-paths'),
    scssIncludePaths = sassIncl.nodeModulesSync();

exports.config = {
    paths: {
        watched: [
            'app'
        ],
        public: 'public'
    },

    files: {
        javascripts: {
            joinTo: {
                'js/main.js': /^app/,
                'js/vendor.js': /^(?!app)/
            }
        },
        stylesheets: {
            joinTo: {
                'css/styles.css': /^app/
            }
        }
    },

    modules: {
        autoRequire: {
            'js/main.js': ['main.js']
        }
    },

    plugins: {
        babel: {
            presets: ['es2015', 'es2016', 'stage-0']
        },
        modernizr: {
            destination: 'js/modernizr.js',
            options: ['html5shiv', 'addTest', 'setClasses', 'mq'],
            tests: ['mq']
        },
        postcss: {
            processors: [
                require('autoprefixer'),
                require('postcss-clearfix')
            ]
        },
        sass: {
            mode: 'native',
            options: {
                includePaths: scssIncludePaths.concat([
                    'app/utility',
                    'app/components'
                ])
            }
        }
    }
};
