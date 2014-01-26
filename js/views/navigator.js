/*
Dock - Navigator Page
Author: Clement Grellier
*/

define(['app', 'raphael', 'text!templates/navigator.html'], function(App, raphael, Template) {

    App.Views.Navigator = Backbone.View.extend({
        el: '#main',
        template: Template,
        firstInit: true,
        flats: {},
        buildings: {},
        els: {},
        svgWidth: 851,
        svgHeight: 349,
        paper: '',
        events: {
            "click #overlay" : "hidePopin"
        },
                                        
        render: function() {
        	var self = this;
        	 
        	//compile template
            var template = Handlebars.compile(self.template);
            self.content = template({
                data: self.model
            }); 
        	self.$el.html(self.content);   

            // init paper
            self.paper = Raphael('svg-container', '100%', '100%');

            // make the Raphael paper fill its container
            self.paper.setViewBox(0, 0, self.svgWidth, self.svgHeight, true);

            self.getData();

            $(window).resize(function() {
                self.fixWindow();
            });
        },

        initialize: function() {
            var self = this;
            _.bindAll(this, 'render');
        },

        getData: function() {
            var self = this;

            // get data of buildings
            $.getJSON(App.baseurl + "js/data/buildings.json", function(data) {
                self.buildings = data;

                 // get data of the flats
                $.getJSON(App.baseurl + "js/data/flats.json", function(dataFlats) {
                    self.flats = dataFlats;

                    // call function based on params (current url)
                    if(App.subparam) {
                        self.drawFloor(App.param, App.subparam);
                    }
                    else if(App.param) {
                        self.drawBuilding(App.param);
                    } else {
                        self.drawScene();
                    }
                });
            });
        },

        drawScene: function() {
            // transition images
            $('.scene').not('#scene').removeClass('showScene');
            $('#scene').addClass('showScene');
            
            // for each building, draw and add data
            for(var i=0; i<this.buildings.length; i++) {
                var b = this.buildings[i];

                this.els[b.id] = this.paper.path(b.path);
                this.els[b.id].data('building', b.id);
            }

            this.styleElements();
            this.fixWindow();

            // add click event handler on each building
            for (var i in this.els) {
                this.els[i].click(this.handleClickBuilding);
            }
        },

        handleClickBuilding: function() {
            var self = App.Views.navigator,
                nbBuilding = this.data('building');

            $('.scene').removeClass("showScene");
            $("#svg-container").addClass("noSelect");

            setTimeout(function() {
                // navigate to the building and draw building
                App.Router.navigate(App.lang + "/navigator/" + nbBuilding, {trigger: true});
            }, 300);
        },

        styleElements: function() {
            // style all current elements
            for (var i in this.els) {
                var el = this.els[i];

                // force cursor pointer
                el[0].style.cursor = 'pointer';

                el.attr({
                    'fill': '#dedede',
                    'stroke': '#dedede',
                    'opacity': 0
                });

                el.hover(this.svg_mouseover, this.svg_mouseout);
            }
        },

        svg_mouseover: function() {
            // if element contains data : display it in caption
            if(this.data("content")) {
                $(".caption").addClass("showCaption").text(this.data("content"));

                // position caption
                $(".caption").css({
                    'left': this.getBBox().x + this.getBBox().width + "px",
                    'top': this.getBBox().y + this.getBBox().height + "px"
                });
            }

            this.animate({opacity: 0.5}, 100);
        },

        svg_mouseout: function() {
            $(".caption").removeClass("showCaption");
            this.animate({opacity: 0}, 100);
        },

        drawBuilding: function(nbBuilding) {
            var self = this;

            // get the floors of the building
            var building = self.getBuilding(nbBuilding);
            var floors = building[0].floors;
            var img = building[0].img;

            self.transitionImages(img);

            // for each floor of the building, draw and add data
            for(var i=0; i<floors.length; i++) {
                var f = floors[i];

                self.els[f.id] = self.paper.path(f.path);
                self.els[f.id].data({
                    'floor': f.id,
                    'building': nbBuilding,
                    'img': f.img
                });
                self.els[f.id].click(self.handleClickFloor);
            }

            self.styleElements();
        },

        handleClickFloor: function() {
            var self = this;

            $('.scene').removeClass("showScene");
            $("#svg-container").addClass("noSelect");

            setTimeout(function() {
                // navigate to floor and draw floor
                App.Router.navigate(App.lang + "/navigator/" + self.data("building") + "/" + self.data("floor"), {trigger: true});
            }, 300);
        },

        // returns the building object based on the number
        getBuilding: function(nb) {
            var self = this;

            var building = jQuery.grep(self.buildings, function(element, index){
              return element.id == nb;
            });
            return building;
        },

        drawFloor: function(nbBuilding, nbFloor) {
            var self = this;

            // get the floors of the building
            var building = self.getBuilding(nbBuilding),
                floors = building[0].floors;

            var floor = jQuery.grep(floors, function(element, index){
              return element.id == nbFloor;
            });

            self.transitionImages(floor[0].img);

            // filter flats
            var flatsFiltered = jQuery.grep(self.flats, function(element, index){
              return element.building == nbBuilding && element.floor == nbFloor;
            });

            // for each flat of the floor, draw and add data
            for(var i=0; i<flatsFiltered.length; i++) {
                var f = flatsFiltered[i];

                self.els[f.id] = self.paper.path(f.path);
                self.els[f.id].data("content", f.code);
                self.els[f.id].data("id", f.id);
                self.els[f.id].click(self.handleClickFlat);
            }

            self.styleElements();

            // check availability of the flats
            for(var i=0; i<flatsFiltered.length; i++) {
                var f = flatsFiltered[i];

                // if it's not available, change style and data
                if(f.rented) {
                    self.els[f.id].attr({
                        'stroke': 'red',
                        'fill': 'red'
                    });
                    self.els[f.id].data('content', 'sold');
                }   
            }
        },

        handleClickFlat: function() {
            var self = App.Views.navigator,
                id = this.data('id');

            var flat = jQuery.grep(self.flats, function(element, index){
              return element.id == id;
            });

            self.showPopin(flat);
        },

        showPopin: function(flat) {
            // temporary code - todo: template
            $("#svg-container").addClass("noSelect");
            $("#flat-popin").empty().append("<h2>Flat code : " + flat[0].code + "</h2>");
            $("#flat-popin").append("<p>Area : " + flat[0].area + "</p>");
            $("#flat-popin").append("<p>Garden : " + flat[0].garden + "</p>");
            $("#flat-popin").append("<p>Price : " + flat[0].price + "KC</p>");

            $("#flat-popin, #overlay").addClass("showPopin");
        },

        hidePopin: function(e) {
            e.preventDefault();
            $("#svg-container").removeClass("noSelect");
            $("#flat-popin, #overlay").removeClass("showPopin");
        },

        transitionImages: function(img) {
            var self = this;

            // create div with new image
            var id = img.split('/').pop().split('.')[0];
            $("#scenes-container").prepend("<div class='scene' id='" + id + "'></div>");
            $('#' + id).css('background-image', 'url(' + App.baseurl + 'img/' + img + ')');

            // show the new div
            setTimeout(function() {
                $('#' + id).addClass("showScene");
                $("#svg-container").removeClass("noSelect");
                self.fixWindow();
            }, 100);
        },

        fixWindow: function() {
            var self = this;

            var h = ($("#svg-container").width() * self.svgHeight) / self.svgWidth;
            var w = ($("#svg-container").height() * self.svgWidth) / self.svgHeight;

            if($(window).height() <= (h + 50)) {
                $("#svg-container, .scene").height(h);
                $("#main").css("overflow", "hidden");
            } else {
                $("#svg-container, .scene").height("100%");
                 $("#main").css("overflow", "inherit");
            }

            if(($(window).width() <= (w/2)) && $(window).width() > 320) {
                $("#svg-container, .scene").addClass("fixWindow").width(w/2);
                $("#svg-container, .scene").css("margin-left", - (w/4));
                $("#main").css("overflow", "hidden");
            } else {
                $("#svg-container, .scene").removeClass("fixWindow").width("100%");
                $("#svg-container, .scene").css("margin-left", 0);
                $("#main").css("overflow", "inherit");
            }
        }

    });

}); 