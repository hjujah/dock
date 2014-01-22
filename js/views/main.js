/*
Dock - Main Page
Copyright Kitchen S.R.O. May 2013. 
Author: Filip Arneric
*/

define(['app','tweenmax'], function(App) {
	
	 App.Views.Main = Backbone.View.extend({   
	    el: 'body',
	    
	    events: {
	        'click .links' : 'changeRoute',
	    },  
	    
		    
	  	render: function(){
	  		
	  		var self = this;
	  		
		  	this.view = App.Pages[App.activepage].view;
		  	this.view.collection =  App.Pages[App.activepage].collection;		  	
            this.view.render(); 
		  	
	  	},
	  		    
	    changeRoute: function(e) {
	    	var self = this;
	        e.preventDefault();
	        var target = $(e.currentTarget),
				href = target.attr("href").replace(absurl,'');
	        App.Router.navigate(href, true);
	    },
	    
	    initialize: function(){	    	
	    	var self = this;	
	    	
	    	//handlebars helpers		    	            
            Handlebars.registerHelper('if_eq', function(context, options) {
                if (context == options.hash.compare) return options.fn(this);
                return options.inverse(this);
            });


            Handlebars.registerHelper('unless_eq', function(context, options) {
                if (context == options.hash.compare) return options.inverse(this);
                return options.fn(this);
            });

            Handlebars.registerHelper('times', function(n, block) {
                var accum = '';
                for (var i = 1; i <= n; ++i)
                accum += block.fn(i);
                return accum;
            });

            Handlebars.registerHelper('lang', function() {
                return App.lang
            });

            Handlebars.registerHelper('baseUrl', function() {
                return absurl
            });

            //handle resize
            $(window).on('smartresize', function() {
            });
	  
	    }
	
	});		
	
})