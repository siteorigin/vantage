module.exports = {
    slug: 'vantage',
    jsMinSuffix: '.min',
    version: {
        src: [
            'functions.php',
            'readme.txt'
        ]
    },
    sass: {
        src: [
            'sass/**/*.scss',
        ],
        include: [
            'sass',
        ],
        external: {
            src: [
                'inc/settings/css/**/*.scss',
            ],
            include: [
                'inc/settings/css'
            ],
        }
    },
    less: {
        src: [
            'style.less',
            'rtl.less',
            'less/**/css/*.less',
            'less/style-editor.less',
        ],
        include:[
            'less/*.less'
        ],
        external: {
            src: [
                'inc/panels-lite/css/**/*.less',
            ],
            include: [
                'inc/panels-lite/css',
            ],
        },
    },
    js: {
        src: [
            'js/**/*.js',
            'inc/sliders/js/**/*.js',
            'inc/customizer/js/**/*.js',
            'inc/metaslider/js/**/*.js',
            'inc/mobilenav/js/**/*.js',
            'inc/settings/js/**/*.js',
            'inc/settings/chosen/*.js',
            'inc/panels-lite/js/**/*.js',
            '!{node_modules,node_modules/**}',  // Ignore node_modules/ and contents
            '!{tests,tests/**}',                // Ignore tests/ and contents
            '!{tmp,tmp/**}'                     // Ignore tmp/ and contents
        ]
    },
    css: {
        src: [
            'style.css',
            'css/woocommerce.css'
        ],
    },    
    copy: {
        src: [
            '**/!(*.js|*.scss|*.md|style.css|woocommerce.css)',   // Everything except .js and .scss files
            '!{build,build/**}',                                  // Ignore build/ and contents
            '!{sass,sass/**}',                                    // Ignore sass/ and contents
            'inc/settings/chosen/*.js',                           // Ensure necessary .js files ignored in the first glob are copied
            '!{inc/settings/bin,inc/settings/bin/**}',            // Ignore settings/bin/ and contents
            '!{inc/settings/README.md}',                          // Ignore settings/README.md
            '!{tests,tests/**}',                                  // Ignore tests/ and contents
            '!{tmp,tmp/**}',                                      // Ignore tmp/ and contents
            '!phpunit.xml',                                       // Not the unit tests configuration file. (If there is one.)
            '!functions.php',                                     // Not the functions .php file. It is copied by the 'version' task.
            '!readme.txt',                                        // Not the readme.txt file. It is copied by the 'version' task.
            '!npm-debug.log'                                      // Ignore debug log from NPM if it's there
        ]
    }
};
