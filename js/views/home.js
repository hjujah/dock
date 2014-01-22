/*
Dock Page
Author: Filip Arneric
*/

define(['app', 'text!templates/home.html'], function(App, Template) {

    App.Views.Home = Backbone.View.extend({
        el: '#main',
        template: Template,
        firstInit: true,
        curSlide: 1,
        
        slider: function(){
		  	
		  	var self = this;
		  	var $boxes = self.$(".slides");
		  	var $im1 = self.$(".img1");
		  	var $im2 = self.$(".img2");
		  	
		  	self.tlReveal && self.tlReveal.pause(); 
 			
 			self.curSlide = (self.curSlide < self.collection.length - 1) ? ++self.curSlide : 0;
            
            var secondImg = $('#img2Holder img').attr("src");
            var newSrc = self.collection[self.curSlide].src;
                
            self.tlReveal = new TimelineMax({
            	autoRemoveChildren: false, 
            	onComplete: function(){
            	
                	$(".firstImage img").attr('src',secondImg);
                	$(".slides, .img1").removeAttr("style");
                	$(".img2").attr('src', absurl+"img/home/"+newSrc);
                	
                	TweenMax.to($im2, 0, {
		                x: '1000px',
		                onComplete: function(){ }
		             })  
                	
                	var t = setTimeout(function(){
	                	self.slider();
                	},3000)
                	
                }
            })
            
            self.tlReveal2 = new TimelineMax({
            	autoRemoveChildren: false, 
            	onComplete: function(){
                	console.log("AN2");
                }
            }) 
            
            self.tlReveal3 = new TimelineMax({
            	autoRemoveChildren: true, 
            	onComplete: function(){
                }
            })          
            
            self.tlReveal.staggerTo($boxes, .4, {
            	left: '-12.5%',
            	ease:"Quad.easeOut"
            }, .08);
            
            self.tlReveal2.staggerTo($im1, .8, {
            	left: '50%',
            	ease:"Quad.easeOut",
            	//delay: 0.2
            }, .04);
            
            self.tlReveal3.staggerTo($im2, .4, {
            	x: '0',
            	ease:"Quad.easeOut"
            }, .04);
            
		  	  
	    },

                                        
        render: function() {
        	
        	var self = this;
        	
        	//compile template
            var template = Handlebars.compile(self.template);
            self.content = template({
                data: self.model
            }); 
        	self.$el.html(self.content);  
        	
        	            
            var t = setTimeout(function(){
	            self.slider();
            }, 1200); 
        	
        	console.log(this.collection);
        },

        initialize: function() {
            var self = this;
            _.bindAll(this, 'render');
        }

    });

}); 