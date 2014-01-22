/*
Dock - Navigator Page
Author: Filip Arneric
*/

define(['app',  'text!templates/navigator.html'], function(App, Template) {

    App.Views.Navigator = Backbone.View.extend({
        el: '#main',
        template: Template,
        firstInit: true,
                                        
        render: function() {
        	
        	var self = this;
        	
        	//compile template
            var template = Handlebars.compile(self.template);
            self.content = template({
                data: self.model
            }); 
        	self.$el.html(self.content);   
        	
            console.log(this.collection);
        },


        initialize: function() {
            var self = this;
            _.bindAll(this, 'render');
        }

    });

}); 