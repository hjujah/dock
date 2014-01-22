/*
Dock Router
Copyright Kitchen S.R.O. September 2013. 
Author: Filip Arneric
*/
define(['app'], function(App) {
			
	//Router
	App.Router = Backbone.Router.extend({
		routes: {
	      "": "render",
          ":lang": "render",
          ":lang/:mod(/)": "render",
          ':lang/:mod/:id(/)': 'render',
          ':lang/:mod/:id/:subid(/)': 'render'
   		 },
 		 
    	render: function(lang, mod, id, subid) {
    	  	    		
   		   var self = this;	 
		   
		   App.lang = lang || 'en';  
		   App.oldPage = App.activepage;
		   App.activepage = mod || 'home';  
		   App.param = (id) ? id : ''; 
		   App.subparam = (subid) ? subid : '';
		   
		   App.Main.render();
		      	  
		   App.firstInit = false;
		},
		
	    initialize: function(){
		   var self = this;
		   Backbone.history = Backbone.history || new Backbone.History({});
		   var root = "~filip/dock/";
		   var enablePushState = true;
		   var pushState = !! (enablePushState && window.history && window.history.pushState);
	       Backbone.history.start({
			   pushState: pushState,
		       root: root
		   });        
	    }
	    
	});

});