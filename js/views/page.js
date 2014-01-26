/*
Dock Page
Author: Filip Arneric
*/

define(['app', 'text!templates/page.html'], function(App, Template) {

    App.Views.Page = Backbone.View.extend({
        el: '#main',
        template: Template,
        firstInit: true,                   
                                  
        render: function() {
        	
        	var self = this;    	
        	//compile template
            var template = Handlebars.compile(self.template);
            self.content = template({
                data: self.collection
            }); 
        	self.$el.html(self.content);  
        	
        },

        initialize: function() {
            var self = this;
            _.bindAll(this, 'render');
        }

    });

}); 