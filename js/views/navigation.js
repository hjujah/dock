/*
Dock Navigation
Author: Filip Arneric
*/

define(['app', 'text!templates/navigation.html'], function(App, Template) {	
	
	//Navigation View
	App.Views.Navigation = Backbone.View.extend({
		el: '#navigation',
		template: Template,
		
		render: function(){
	    	var self = this;
	    	
	    	//compile template
            var template = Handlebars.compile(self.template);
            self.content = template({
                data: self.model
            }); 
        	self.$el.html(self.content);  

	    },
	    	    
	    initialize: function(){
	    	var self = this;	 	    		    	

	    	//handle resize
			$(window).on('resize', function(){

			});		
	    	 					
	    }
	    
	});
	
});