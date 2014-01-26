/*
Dock - Main View
Copyright Kitchen S.R.O. May 2013. 
Author: Filip Arneric
*/

define(['app','tweenmax','smartresize','imgLiquid'], function(App) {
	
	 App.Views.Main = Backbone.View.extend({   
	    el: 'body',
	   
	    events: {
	        'click .links' : 'changeRoute'
	    },  
	    
	    setSizes: function(){
			App.width = $(window).width();
			this.setCubeSizes(true);
		}, 
	    
	    setCubeSizes: function(resizing){
	      	var self = this;
	      	
	      	$(".cube-wrap").each(function(key,index){
		    	var	_this = $(index);
		    		w = _this.width(),
		    		z = w/2,
		    		angle = (resizing) ? 0 : '90deg',
		    		$cube = _this.find('.cube'),
		    		$back = $cube.find('.back-pane'),
		    		$right = $cube.find('.right-pane'),
		    		$left = $cube.find('.left-pane'),
		    		$front = $cube.find('.front-pane');
	    		
	    		$cube.add($back, $right, $left, $front).removeAttr("style");
	    		    		
	    		$cube.css({transform: 'translateZ(' + -z + 'px) rotateY('+ angle +')'});
	    		$front.css({transform: 'translateZ(' + z + 'px)'});
	    		$back.css({transform: 'translateZ(' + -z + 'px) rotateY(180deg)'});
	    		$right.css({transform: 'translateX(' + z + 'px) rotateY(-270deg)'});
	    		$left.css({transform: 'translateZ(' + -z + 'px) rotateY(270deg)'});
	      	});      	 
        },
        
        rotateCube:function(angle, callback){
        	var self = this,
        		$boxes = $(".cube");
        		
        	self.tlRotate && self.tlRotate.pause(); 	
        		
        	self.tlRotate = new TimelineMax({
            	autoRemoveChildren: true, 
            	onComplete: function(){
            		callback && callback();
                }
            })       
            
            self.tlRotate.staggerTo($boxes, 1, {
            	rotationY: angle,
            	ease:"Quart.easeOut",
            	delay: .5,
            }, .2);

        },  
        
        destroy_view: function() {     	
		    this.view.undelegateEvents();
		    this.view.$el.removeData().unbind();	    
		    this.view.destroy_view && this.view.destroy_view();	    		    
	    },
	    
	    renderPage: function(){
		  	var self = this;
		  	
		  	self.view.render(); 
		  	self.setCubeSizes();
		  	self.rotateCube(0);
		  	
		  	self.$(".liquid").imgLiquid({
                fadeInTime: 200,
                responsive: true,
                fill: true,
                horizontalAlign: "center",
                verticalAlign: "center"
            });  
	    },
		    
	  	render: function(){  		
	  		var self = this;
	  		
	  		//destroy the previous view
	  		this.view && this.destroy_view();
	  		
	  		//define view and collection  	
	  		this.page = App.Pages[App.activepage];	  		
		  	this.view = this.page.view[App.paramsNo] || this.page.view;			  	
		  	this.view.collection = (App.param) ? (this.page.collection[App.paramsNo][App.param] || this.page.collection) //there is a param
		  						 : (this.page.collection[App.paramsNo] || this.page.collection); //without the param
		  		  	
		  	//change the content of #main	  	          	  	
		  	if(App.firstInit){
		  		self.renderPage();
		  	}else{
			  	self.rotateCube(-90, function(){
				  	self.renderPage();
			  	});
		  	}
		  	
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
	    	
	    	self.setSizes();
	    	
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
            	self.setSizes();
            	setTimeout(function(){
            	},10)
            });
	  
	    }
	
	});		
	
})