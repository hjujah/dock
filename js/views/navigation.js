/*
Aida Navigation
Author: Filip Arneric
*/

define(['jquery', 'backbone', 'text!templates/navigation.html', 'text!templates/subNavigation.html', 'handlebars'], function($, Backbone, Template, Subtemplate) {	
	
	//Navigation View
	var Navigation = Backbone.View.extend({
		el: $("#navigation"),
		template: Handlebars.compile(Template),
		subtemplate: Handlebars.compile(Subtemplate),
		submodel: [],
		rotated: false,
		
		events: {
	        "click #showMainNav" : "showMainNav",
	        "click #showSubNav" : "showSubNav",
	        'mouseover' : 'rotateLogo',
	        'mouseleave' : 'stopRotate'
        },
        
        rotateLogo: function(){
        	var self = this;
        	if (!$.browser.mobile && !ie8) {   
        		if(!self.tl){
	        		self.tl = new TimelineMax({repeat:-1});
		        	var deg = (self.$("#rotateLogo").getRotationDegrees() + 360) + "deg";
			      	self.tl.to(self.$("#rotateLogo"),12, {rotation: deg ,ease:Linear.easeNone} );
        		}  	
		      	self.tl.play();
	      	}
        },
        
        stopRotate: function(){
        	var self = this;
			
			function closest (num, arr) {
                var curr = arr[0];
                var diff = Math.abs (num - curr);
                for (var val = 0; val < arr.length; val++) {
                    var newdiff = Math.abs (num - arr[val]);
                    if (newdiff < diff) {
                        diff = newdiff;
                        curr = arr[val];
                    }
                }
                return curr;
            }
            
            if (!$.browser.mobile && !ie8) {
            
            	var curangle = self.$("#rotateLogo").getRotationDegrees(),       
            		angles = [ 0, 90, 180, 270, 360, 450, 540, 630, 720 ],
            		closest = closest (curangle, angles);
            	
            	self.tl.pause();        	 
	        	//self.tl.repeat(0);        	
	        	//self.tl.reverse();
	        	
	        	//TweenMax.killTweensOf(self.$("#rotateLogo"));
	        	
/*
	        	console.log(closest);
	        	
	        	self.tl.to(self.$("#rotateLogo"),1, {
	        		rotation: closest,
	        		ease:Linear.easeNone,    
	        		onComplete: function(){
		        		
	        		}   		
	        	});
	        	
	        	self.tl.play();
*/
	   /*
     	TweenMax.to(self.$("#rotateLogo"), 1, {
		      	 	rotation: closest,
		      	 	onComplete: function(){		      	 	
		      	 	}
		      	});
*/
	      	}
        },
				
		render: function(){
	    	var self = this;
	    	
	    	self.markup = self.template({
                lang: myApp.lang,
                data: self.model               
            }); 
					
			self.$el.html(self.markup); 
			
			self.subEl = $("#subNav");
			self.subElHolder = $("#subNavHolder");
			self.holder = $("#desktopNav");
			self.main = $("#mainNav");
			
			myApp.page.setActiveNav();		
/* 			self.renderSub(); */
	    },
	    
	    renderSub: function(){
		  	var self = this;  
		  	
		  	self.prevRotated = self.rotated;
		  	self.rotated = window.myApp.pages[myApp.page.activepage]['rotatedMenu'];
		  	self.submodel = [];	
		  	
		  	if(myApp.page.activepage == "products" && myApp.page.subparam){
		  				  			
				var	allNext =  _.filter(myApp.page.model.products, function(data){ return data.product_order > myApp.page.model.product[0].product_order });
					allPrev = _.filter(myApp.page.model.products, function(data){ return data.product_order < myApp.page.model.product[0].product_order }),
				
				self.submodel.prev = (allPrev.length > 0) ? allPrev[allPrev.length-1] : allNext[allNext.length-1];
				self.submodel.next = (allNext.length > 0) ? allNext[0] : allPrev[0];
		  	}
		  	
		  	else if(myApp.page.activepage == "products" && myApp.page.param){
		    	var brands = [];
		    	
		    	$.each( myApp.page.model.products, function( key, value ) {
			    	brands.push(value.brand_name);
				});
				
		    	self.submodel.brands = _.uniq(brands);
		    	self.submodel.categories = null;
		    	
		    } else if(myApp.page.activepage == "products"){	    	
		    	self.submodel.brands = null;
		    	self.submodel.categories = myApp.collection.categories;			    
		    }
		  	
		  	
		  	self.oldMarkup = self.submarkup || null;	  	
		  	self.submarkup = self.subtemplate({
                lang: myApp.lang,
                data: self.submodel
            }); 
            
            
            if(self.rotated && self.oldMarkup!=self.submarkup){
		        TweenMax.to( self.holder, 0.5, {
	                opacity: 0,
	                rotationY: '30deg',
	                onComplete: function() {
	                		self.main.hide();
	                		self.subElHolder.show();
	                		self.subEl.html(self.submarkup);           	
							TweenMax.to( self.holder, 0.5, {
								opacity: 1,
								rotationY: 0,
								delay: .3
							})  
	                	
	                }
	            })
            }else if(!self.rotated && self.prevRotated /* && self.rotated */){
                  self.showMainNav();   
		  	}
	    },
	    
	    showMainNav: function(){
	    	var self = this;
		    TweenMax.to( self.holder, 0.5, {
		        opacity: 0,
		        rotationY: '30deg',
		        onComplete: function() {
	        		self.main.show();
	        		self.subElHolder.hide();        
	        		self.rotated = false;	
					TweenMax.to( self.holder, 0.5, {
						opacity: 1,
						rotationY: 0,
						delay: .3
					})
				}
			})
	    },
	    
	    showSubNav: function(){
	    	var self = this;
		    TweenMax.to( self.holder, 0.5, {
		        opacity: 0,
		        rotationY: '30deg',
		        onComplete: function() {
	        		self.main.hide();
	        		self.subElHolder.show();        	
					TweenMax.to( self.holder, 0.5, {
						opacity: 1,
						rotationY: 0,
						delay: .3
					})
				}
			});
	    },
	    
	    adapt: function(){
	    
	    	if(myApp.page.activepage == "products" && myApp.page.param){
		    	var brands = [];
		    	
		    	$.each( myApp.page.model.products, function( key, value ) {
			    	brands.push(value.brand_name);
				});
		    	self.submodel = _.uniq(brands);
	    	}else{
		    	self.submodel = null;
	    	}
	    },
	    
	    initialize: function(){
	    	var self = this;	 

	    	self.model = myApp.pages.navigation.collection;
	    		    	
	    	//register menu helpers
	    	Handlebars.registerHelper('menuText', function(items) {
			  var text = myApp.page.lang == 'cz' ? items.text.cz : items.text.en;
			  return new Handlebars.SafeString(text);
			});	

	    	//handle resize
			$(window).on('resize', function(){

			});		
	    	 					
	    }
	    
	});
	
	return Navigation;
	
});