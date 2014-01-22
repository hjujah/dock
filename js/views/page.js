/*
Aida Page
Author: Filip Arneric
*/

define(['jquery', 'backbone', 'handlebars', 'imgLiquid', 'smartresize', 'backstretch', 'nicescroll', 'royal', 'master' , 'fittext' ], function($, Backbone) {

    var Page = Backbone.View.extend({
        el: '#main',
        firstInit: true,
        dragging: false,
        av: false,
        hideState: true,
        absurl: absurl,
        events: {
	        "click .articleNav" : "setActiveArticle",
	        'mousemove' : 'mousemove',
			'mouseup' : 'mouseup',
			'mousedown .rotateMe' : 'mousedown',
	        'mousemove': 'showMenu',
	        "mouseenter #thumbnails" : "alwaysVisible",
	        "mouseleave #thumbnails" : "alwaysVisibleEnd"
        },
        
       alwaysVisible: function(){
	     	this.av = true;  
       },
       
       alwaysVisibleEnd: function(){
	     	this.av = false;
       },
        
       showMenu: function() {
            var self = this;
            self.hideState = false;
            clearInterval(self.interval);
            self.interval = setInterval(function() {
                self.hideState = true;
            }, 640);
        },

        hideMenu: function() {
            var self = this;
            self.showMenu();
            (function animloop() {
                requestAnimationFrame(animloop);
                if (1==1) {
                    var op = (self.hideState && !self.av) ? 0 : 1;
                    TweenMax.to(self.$("#thumbnails"), 0.5, {
                        opacity: op
                    });
                }
            })();
        },
        
        setActiveArticle: function(e){
	      	  var self = this,
	      	  	  target = $(e.currentTarget);
	      	  self.$(".articleNav").removeClass("active");
	      	  target.addClass("active");
        },
        
        setSizes: function(){
        	var self = this; 
        	myApp.perRow = 3;
	        myApp.width = $('body').innerWidth();
            myApp.height = $(window).height();
            myApp.menuWidth = $("#navigation").width();
            myApp.contentBox = $(".contentHolder").outerHeight();
            myApp.containerWidth = myApp.width - myApp.menuWidth;
            
            if (!Modernizr.csscalc) {
	            self.$el.css("width",myApp.containerWidth);
	            myApp.width < 1200 && self.$el.css("height",myApp.width - 51);
            }
            
            var ostatak = (self.$el.width()%3);
            if(myApp.width>1199){
	            self.$el.width(myApp.containerWidth - ostatak);
	            $("#navigation").width(myApp.menuWidth + ostatak);
            }else{
	            self.$el.removeAttr("style");
	            $("#navigation").removeAttr("style");
            }
            
            
            myApp.mainWidth = self.$el.width();
            myApp.boxHeight = myApp.mainWidth / myApp.perRow;  
            myApp.boxHeight2 = (myApp.width>1199) ? myApp.height / 2 : myApp.height / 2;        
            myApp.newsBarWidth = (myApp.width > 767) ? myApp.mainWidth / 4 : myApp.mainWidth;
            
        },
        
        setBoxHeight: function(){
	      	var self = this;  
	      	myApp.boxWidth = self.$(".box").width();
	      	self.$(".resize").css("height",myApp.height/2);
	      	self.$("#newsList").css("width",myApp.newsBarWidth);
	      	self.$(".box1").css("height",myApp.contentBox);
	      	self.$(".titleHolder").width(myApp.mainWidth);
        },
        
        gridLayout: function(){
	        //backstretch slideshows
            $(".slideshow").each(function(key, index) {
                var bg = $(index).data("bg"),
                    myarr = bg.split(","),
                    time = Math.floor((Math.random() * 1600) + 4000);
                myarr.pop();
                if (myarr.length > 0) {
                    $(index).backstretch(myarr, {
                        duration: 1000,
                        fade: 850
                    })
                }
            });
            
            $(".slideshow").backstretch("pause");
            
        	//parallax
	        var $object = self.$('.parallax'), 
	       		speed = $object.data('speed'),
	       		$window = $(window),
	       		coords = '0px';
	       	
	       	if (!$.browser.mobile && !ie8) {
		        $window.scroll(function() {					
		            var yPos = ($window.scrollTop() * speed);
		            coords = -yPos;     
		        });
		        
		        (function drawloop() {
	                requestAnimationFrame(drawloop)     
	                if (Modernizr.csstransforms) {
	                
			            $object.css({
			                '-webkit-transform': 'translateY(' + coords + 'px) translateZ(0)',
		                    '-moz-transform': 'translateY(' + coords + 'px translateZ(0))',
		                    '-o-transform': 'translateY(' + coords + 'px translateZ(0))',
		                    '-ms-transform': 'translateY(' + coords + 'px translateZ(0))'
			            });
	                } else{
		                $object.css({
			              	top: coords + 'px'
			            });
	                }  
	                
	            })();	
            }
            
            var t = setTimeout(function(){
	             
	            $("#carousel-gallery").touchCarousel({
	                itemsPerPage: 1,
	                scrollbar: true,
	                scrollbarAutoHide: true,
	                snapToItems: true,
	                scrollbarTheme: "dark",
	                pagingNav: false,
	                scrollToLast: false,
	                itemsPerMove: 2,
	                useWebkit3d: false,
	                loopItems: true
	            });

            },100)
            
        },
        
        news: function(){
	      	var self = this;
	      	
			//if (!$.browser.mobile) {
				$("#newsList").niceScroll({
				    cursorborder: "none",
				    mousescrollstep: 30,
				    scrollspeed: 50,
				    autohidemode: false,
				    zindex: 9999999999,
				    hwacceleration: true,
				    enabletranslate3d: true,
				    directionlockdeadzone: 100,
				    railalign: "left"
				});
				
				$(".height45").css("height", myApp.height * 0.45);
				
				var minHeight = (myApp.width>1200) ? myApp.height * 0.4766 : myApp.height * 0.4766 - 50;
				$(".minheight55").css("min-height", minHeight);
				
			//}
			
			self.gridLayout();
	      	  
        },
        
        home: function(){
        
	        var slider = new MasterSlider();
	        
			slider.setup('masterslider' , {
				//space:100,
				width:myApp.mainWidth,
				height:myApp.height,
				fillMode: "fill",
				fullWidth: true,
				autoHeight: false,
				view:'flow',
				loop: true
			});
			//slider.control('arrows');	
			
			slider.control('bullets' ,{autohide:false});
	        
        },
        
        staticPage: function(){
        	var self = this;
	      	$(".box1").css("height",myApp.contentBox);
	      	self.gridLayout();
        },
        
        contact: function(){
			var self = this;
			self.gridLayout();
	      	
	      	var stylesArray = [ { featureType: "poi", stylers: [ { visibility: "off" } ] },{ featureType: "landscape.man_made", elementType: "geometry.fill", stylers: [ { visibility: "on" }, { lightness: -4 }, { saturation: -60 } ] },{ featureType: "road", elementType: "labels.text.stroke", stylers: [ { visibility: "on" }, { saturation: -4 }, { lightness: 100 } ] },{ featureType: "landscape.natural", stylers: [ { saturation: -48 }, { lightness: -4 } ] },{ featureType: "water", stylers: [ { saturation: -65 }, { lightness: -6 } ] },{ featureType: "road", elementType: "geometry.fill", stylers: [ { lightness: 100 } ] },{ featureType: "road", elementType: "geometry.stroke", stylers: [ { saturation: -100 } ] } ]  
	      	
	      	
	      	var mapOptions = {
                center: new google.maps.LatLng(50.077799,14.438555),
                zoom: 17,
                disableDefaultUI: true,
                zoomControl: false,
                scaleControl: false,
                scrollwheel: true,
                disableDoubleClickZoom: true,
                styles: stylesArray
            };

			var gmap = $("#gmap"),
				map = (gmap.length > 0) ? new google.maps.Map(document.getElementById("gmap"), mapOptions) : null,
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(50.077799,14.438555),
					map: map,
					icon: absurl + 'img/pin.png',
				});
        },
        
        flipBoxes: function(out,callback){
        	
        	var self = this,
                boxes = self.container.find('.box'),
                opacity = (out) ? 0 : 1,
                z = (out) ? "-200px" : 0,
                rotate = (out) ? '30deg' : 0,
                rotateX = (out) ? '6deg' : 0,
                dl = (self.activepage == "home" && out) ? 1 : .1,
                dur = (myApp.stillPreview && out) ? 1 : 1;
                            
            self.tlReveal && self.tlReveal.pause(); 
                
            self.tlReveal = new TimelineMax({
            	autoRemoveChildren: false, 
            	onComplete: function(){
                	callback && callback();
                	self.tlReveal.invalidate();
                }
            })
            
            out && (boxes = boxes.reverse());
            
            TweenMax.to($("html, body"), $("html").scrollTop() / 600, {
                scrollTop: 0,
                onComplete: function(){
			        self.tlReveal.staggerTo(boxes, dur, {
		            	opacity: opacity,
		               	rotationY: rotate,
		               	delay: dl
		            }, .3);
                }
            })  
                     
            //self.tlReveal.play();
        
        },
        
        fitText: function (container) {
            var self = this;
            container = container || self.$el;
            var elems = container.find(".fittext");
            elems.each(function (key, index) {
                var text = $(index),
                    datafit = text.data('fit'),
                    max = text.data('max') + 'px',
                    min = text.data('min') + 'px' || "10px",
                    val = /* Math.round */ (0.16 * datafit);
                text.fitText(val, {
                    minFontSize: min,
                    maxFontSize: max,
                    resize: true
                });
            });
        },
        
             
        defineStuff: function(){
        	var self = this;
        	
        	//define model
        	self.model = $.extend(true, {}, myApp.pages[self.activepage]['collection']);
        	
        	
        	//filter model
	      	self.model.products = 
	        (self.activepage == "products" && self.param) ?  _.filter(self.model.products, function(data) { return data.cat_name_en == self.param }) 
	      	: (self.activepage == "news" && self.param) ?  _.filter(self.model.news, function(data) { return data.id == self.param })[0]
	      	: self.model.products;  
	      	
	      	self.model.product = (self.activepage == "products" && self.subparam) ?  _.filter(self.model.products, function(data) { return data.id == self.subparam })  : null;
	      	
	      	self.model.article = (self.activepage == "news" && self.param) ? _.filter(self.model.news, function(data) { return data.id == self.param })[0] : self.model.article; 
	      	
	      	if(myApp.page.activepage == "products" && myApp.page.subparam){
		  			
				var	allNext =  _.filter(self.model.products, function(data){ return data.product_order > self.model.product[0].product_order });
					allPrev = _.filter(self.model.products, function(data){ return data.product_order < self.model.product[0].product_order }),
				
				self.prev = (allPrev.length > 0) ? allPrev[allPrev.length-1] : allNext[allNext.length-1];
				self.next = (allNext.length > 0) ? allNext[0] : allPrev[0];
		  	}
		  	
		  	if(self.activepage == "products" && self.param){
			  	self.model.categoryImage = _.filter(self.model.categories, function(data){ return data.cat_name_en == self.param })[0].objects[0].img;
		  	} 
	      	
	      	//split into 3 cols
	      	if(self.activepage == "products" && !self.param){
			    self.splitColumns(self.model.categories);
	      	}else if(self.activepage == "references"){
		      	self.splitColumns(self.model.references);
	      	}        
	      	
	      	self.container = (self.activepage == "news" && self.oldPage == "news" && self.param) ? self.$('#articlePreview') : self.$el;
	      		      													   
	      	//define/compile template
	      	var template = window.myApp.pages[self.activepage]['template'];
            self.template = (self.activepage == "news" && self.oldPage != "news") ? Handlebars.compile(template.primary) 
            				: (self.subparam) ? Handlebars.compile(template.preview) 
            				: (self.param) ? Handlebars.compile(template.secondary) 
            				: Handlebars.compile(template.primary);
	      	
        },
        
        splitColumns: function(model){
	      	var self = this,
	      		mod = $.extend(true, {}, model),
	            counter = 0,
	            cnt = 1,
	            tmp = [];
	
            $.each(model, function(index, value) {
                if (!isNaN(index)) {
                    tmp[counter] = tmp[counter] || [];
                    tmp[counter].push(value);
                    if (counter == 2) {
                        counter = 0;
                    } else {
                        counter += 1;
                    }
                }
            });           
            self.model.col1 = tmp[0];
            self.model.col2 = tmp[1];
            self.model.col3 = tmp[2];  
        },
        
        showPage: function(){
	        var self = this;
	        self.container.html(self.markup);
	        
	        setTimeout(function(){
	        	self.setSizes();
	        	self[window.myApp.pages[self.activepage].scripts]();
	        },0);  
        	
        	self.fitText();	        	        
	        
		    self.flipBoxes(false,function(){
			    //when page is loaded and shown
			    self.pageReady = true;
			    //self.$(".backstretch").css("opacity",0.6);
		    });
        },
        
                           
        render: function() {
            var self = this;
            
            self.setActiveNav();
            self.pageReady = false;
            self.defineStuff();
             
            $('body').attr('class', self.activepage); 
            
            console.log("model",self.model);
            
            
            
            self.markup = self.template({
                data: self.model,
                lang: myApp.lang,
                boxHeight: myApp.boxHeight2,
                newsBarWidth: myApp.newsBarWidth,
                mainWidth: myApp.mainWidth
            }); 
            
            //transformation begins
            if(self.firstInit){
            	self.showPage();
            	if (!$.browser.mobile) {
                    $("html").niceScroll({
                        cursorborder: "none",
                        mousescrollstep: 30,
                        scrollspeed: 50,
                        zindex: 9999999999,
                        hwacceleration: true,
                        enabletranslate3d: true,
                        directionlockdeadzone: 100,
                    });
                }
            	
            }else{
	            self.flipBoxes(true,function(){
		            self.showPage();
	            });
            }
            
        },

        setActiveNav: function(){
	       	var self = this,
	        	$link = $('.linkHolder').filter('[data-page="'+self.activepage+'"]'),   
	        	$mobileLink = $('.mobileLinks').filter('[data-page="'+self.activepage+'"]'),  
	        	$img = $link.find(".activeMenuBg"),
	        	$navbar = $(".navbar-collapse");
	        	
	        $(".activeMenuBg").removeAttr("style");
	        $img.css("opacity",1);        
	        
	        $(".menuLink").removeClass("active");
	        
	        $mobileLink.addClass("active");
			$link.find('.menuLink').addClass("active");
					
            $navbar.hasClass("in") && $navbar.collapse('hide');
	        
        },


        initialize: function() {
            var self = this;

            _.bindAll(this, 'render');
            
            self.setSizes();
            self.hideMenu();
            
            Handlebars.registerHelper('if_eq', function(context, options) {
                if (context == options.hash.compare) return options.fn(this);
                return options.inverse(this);
            });


            Handlebars.registerHelper('unless_eq', function(context, options) {
                if (context == options.hash.compare) return options.inverse(this);
                console.log("op",options);
                return options.fn(this);
            });
            
            Handlebars.registerHelper('unless_eq_cat', function(context, options) {
                if (context == self.param) return options.inverse(this);
                return options.fn(this);
            });

            Handlebars.registerHelper('times', function(n, block) {
                var accum = '';
                for (var i = 1; i <= n; ++i)
                accum += block.fn(i);
                return accum;
            });


            Handlebars.registerHelper('sanitizeUrl', function(url) {
            	var contains = (url.indexOf('http://') > -1); //true
            	url = (!contains) ? "http://" + url : url;
			    return url;
			});
           

            Handlebars.registerHelper('getProp', function(context, options){
                return context[options + '_' + myApp.lang];
            });
            
            Handlebars.registerHelper('getCategory', function(context, options){
            	return context[0]['cat_name_' + myApp.lang];
            });

            Handlebars.registerHelper('baseUrl', function() {
                return absurl
            });

            //handle resize
            $(window).on('smartresize', function() {
             	self.setSizes();	
             	self.setBoxHeight(); 
             	$(".slideshow").backstretch("resize");
             	$("html").getNiceScroll().resize();
             	
            });
        }

    });

    return Page;

}); 