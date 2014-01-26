/*
Dock Home Page
Author: Filip Arneric
*/

define(['app', 'text!templates/home.html'], function(App, Template) {

    App.Views.Home = Backbone.View.extend({
        el: '#main',
        template: Template,
        curSlide: 1,
        
        destroy_view: function() {	
        	var self = this;      
		    this.tlReveal = null;
		    clearTimeout(this.t);
		    console.log("DESTROY");
	    },
        
        slider: function(){
		  	
		  	var self = this;
		  	var $boxes = self.$(".slides");
		  	var $im1 = self.$(".img1");
		  	var $im2 = self.$(".img2");
		  	
		  	self.tlReveal && self.tlReveal.pause(); 		
 			self.curSlide = (self.curSlide < self.collection.length - 1) ? ++self.curSlide : 0;
            
            var secondImg = $('.img2').css("background-image");
            var newSrc = self.collection[self.curSlide].src;
                
            self.tlReveal = new TimelineMax({
            	autoRemoveChildren: false, 
            	onComplete: function(){
                	
                	$im1.css({
	                	'background-image': secondImg,
	                	 transform: 'translateX(0)'
                	});
        	       	
                	$boxes.add($im1).css("left",0);
              	           	
                	$im2.css('background-image', 'url(' + absurl+"img/home/"+newSrc + ')');
                	
                	/*
TweenMax.to($im2, 0, {
		                x: '1400px'
		            })  
*/
                	
                	self.t = setTimeout(function(){
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
            	ease:"Quart.easeOut"
            }, .08);
            
            self.tlReveal2.staggerTo($im1, .8, {
            	x: 500,
            	ease:"Quart.easeOut",
            	delay: 0
            }, .04);
            
          /*
  self.tlReveal3.staggerTo($im2, .4, {
            	x: '0',
            	ease:"Quart.easeOut"
            }, .04);
*/
            
		  	  
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
            }, 5200); 
        	
        },

        initialize: function() {
            var self = this;
            _.bindAll(this, 'render');
        }

    });

}); 