/*
Dock Load
Copyright Kitchen S.R.O. September 2013. 
Author: Filip Arneric
*/
require.config({
	urlArgs: "noCache=" + (new Date).getTime(),
    baseUrl: absurl+'js/',
    waitSeconds: 120,
    dir: "../webapp-build",
    paths: {
        'jquery': 'vendor/jquery-1.10.2.min',
 		'jqueryMigrate': 'vendor/jquery-migrate.min',
        'underscore': 'vendor/underscore',
        'backbone': 'vendor/backbone',
        'handlebars': 'vendor/handlebars',
        'text': 'vendor/text',
        'async': 'vendor/async',
 		'noext': 'vendor/noext',
 		"imagesLoaded": "libs/jquery.imagesloaded",
        'bootstrap': 'vendor/sass-bootstrap.min',
        'smartresize': 'libs/smartresize',
        'tweenmax': "libs/TweenMax.min",
        'imgLiquid' : 'libs/imgLiquid-min',
        'modernizr' : 'vendor/modernizr',
        'backstretch' : 'libs/jquery.backstretch.min',
        'nicescroll' : 'libs/jquery.nicescroll.min',
        'royal' : 'libs/jquery.royalslider.min',
        'cssPlugin' : 'libs/CSSPlugin',
        'easing' : 'libs/masterslider/jquery.easing.min',
        'fittext' : 'libs/jquery.fittext'
    },
    shim: {
        bootstrap: {
            deps: ['jquery'],
            exports: 'Bootstrap'
        },
 	    
        smartresize: {
            deps: ['jquery'],
            exports: 'Smartresize'
        },
 
 		fittext: {
            deps: ['jquery']
        },
 	
 		backstretch: {
            deps: ['jquery']
        },
 
 		cssPlugin: {
            deps: ['tweenmax']
        },
 	
        imagesLoaded: {
            deps: ['jquery']
        },
 
		jqueryMigrate: {
            deps: ['jquery']
        },
        
        royal: {
            deps: ['jquery']
        },

        tweenmax: {
            deps: ['jquery']
        },
          
        imgLiquid: {
            deps: ['jquery']
        }        

    }
});

require([ 'app', 'scripts', 'loadApp', "modernizr" ],function ( App ) {
	
})