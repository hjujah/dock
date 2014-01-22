/*
Aida Page
Author: Filip Arneric
*/

define(['jquery', 'backbone', 'handlebars', 'imgLiquid', 'smartresize'], function($, Backbone) {

    var Page = Backbone.View.extend({
        el: '#main',
        firstInit: true,
        absurl: absurl,
        events: {
	        "mouseover .contentLine" : "playVideo",
	        "mouseleave .contentLine" : "stopVideo"
        },
        
        setSizes: function(){
        	var self = this; 
        	myApp.perRow = 3;
	        myApp.width = $('body').innerWidth();
            myApp.height = $(window).height();
            myApp.menuWidth = $("#navigation").width();
            
            if (!Modernizr.csscalc) {
	            self.$el.css("width",myApp.width - myApp.menuWidth);
            }
            
            myApp.mainWidth = self.$el.width();
            myApp.boxHeight = myApp.mainWidth / myApp.perRow;
        },
        
        setBoxHeight: function(){
	      	var self = this;  
	      	myApp.boxWidth = self.$(".box").width();
	      	self.$(".box").css("height",myApp.boxWidth);
        },
        
        flipBoxes: function(out,callback){
        	
        	var self = this,
                boxes = $('.box'),
                delay = 0,
                opacity = (out) ? 0 : 1,
                z = (out) ? "200deg" : 0,
                rotate = (out) ? '30deg' : 0;
                
            self.tlReveal && self.tlReveal.pause(); 
                
            self.tlReveal = new TimelineLite({
            	autoRemoveChildren: false, 
            	onComplete: function(){
                	callback && callback();
                }
            })
               
            boxes = _.shuffle(boxes);

            self.tlReveal.staggerTo(boxes, 1, {
            	opacity: opacity,
               	rotationY: rotate
            }, 0.1);

            self.tlReveal.play();
        
        },
        
        defineModel: function(){
	    	var self = this;
        },
                                
        render: function() {
            var self = this,
                model = $.extend(true, {}, myApp.pages[self.activepage]['collection']);
            
            self.model = myApp.collection[self.activepage];              
            console.log(self.model);
             
            self.$el.attr('class', self.activepage); 
                            
            //compile template
            var template = Handlebars.compile(window.myApp.pages[self.activepage]['template']);
            self.template = template({
                data: self.model,
                boxHeight: myApp.boxHeight
            }); 
            
            if(self.firstInit){
            	window.myApp.pages[self.activepage]['view'].render();
            	
            	//self.$el.html(self.template);
	            self.flipBoxes(false,function(){});
            }else{
	            self.flipBoxes(true,function(){
	            	window.myApp.pages[self.activepage]['view'].render();
		           /*  self.$el.html(self.template); */
		            self.flipBoxes(false,function(){});
	            });
            }
            
        },


        initialize: function() {
            var self = this;

            _.bindAll(this, 'render');
            self.setSizes();
            
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


            Handlebars.registerHelper('baseUrl', function() {
                return absurl
            });

            //handle resize
            $(window).on('smartresize', function() {
             	self.setSizes();	
             	self.setBoxHeight(); 
            });
        }

    });

    return Page;

}); 