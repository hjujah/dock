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

            // the following line makes the Raphael paper fill its container
            self.paper.setViewBox(0, 0, self.svgWidth, self.svgHeight, true);

            self.getData();
        },

        initialize: function() {
            var self = this;
            _.bindAll(this, 'render');
        },

        getData: function() {
            var self = this;

            // get data of the flats
            $.getJSON(App.baseurl + "js/data/flats.json", function(data) {
                self.flats = data;
            });

            // get data of buildings
            $.getJSON(App.baseurl + "js/data/buildings.json", function(data) {
                self.buildings = data;

                if(App.subparam) {
                    self.drawFloor(App.param, App.subparam);
                }
                else if(App.param) {
                    self.drawBuilding(App.param);
                } else {
                    self.drawScene();
                }
            });
        },

        drawScene: function() {
            this.clearPaper();

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

            // add click event handler on each building
            for (var i in this.els) {
                this.els[i].click(this.handleClickBuilding);
            }
        },

        handleClickBuilding: function() {
            var self = App.Views.navigator;

            self.clearPaper();

            var nbBuilding = this.data('building');

            // show up the building depending on the number
            self.drawBuilding(nbBuilding);
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

        clearPaper: function() {
            // clear all paths of the svg and reset elements object
            this.paper.clear();
            this.els = {};
        },

        svg_mouseover: function() {
            // if element contains data : display it in caption
            if(this.data("content")) {
                $(".caption").text(this.data("content"));
                $(".caption").addClass("showCaption");

                // position caption
                $(".caption").css("left", ((this.getBBox().x + this.getBBox().width) - 70) + "px");
                $(".caption").css("top", ((this.getBBox().y + this.getBBox().height) - 70) + "px");
            }

            this.animate({opacity: 0.5}, 100);
        },

        svg_mouseout: function() {
            $(".caption").removeClass("showCaption");
            this.animate({opacity: 0}, 100);
        },

        drawBuilding: function(nbBuilding) {
            var self = this;

            App.Router.navigate(App.lang + "/navigator/" + nbBuilding, {trigger: true});

            self.clearPaper();

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
                    "floor": f.id,
                    "building": nbBuilding,
                    "img": f.img
                });
                self.els[f.id].click(self.handleClickFloor);
            }

            self.styleElements();
        },

        handleClickFloor: function() {
            var self = App.Views.navigator;

            self.drawFloor(this.data("building"), this.data("floor"));
        },

        getBuilding: function(nb) {
            var self = this;

            var building = jQuery.grep(self.buildings, function(element, index){
              return element.id == nb;
            });
            return building;
        },

        drawFloor: function(nbBuilding, nbFloor) {
            var self = this;
            self.clearPaper();

            App.Router.navigate(App.lang + "/navigator/" + nbBuilding + "/" + nbFloor, {trigger: true});

            // get the floors of the building
            var building = self.getBuilding(nbBuilding);
            var floors = building[0].floors;

            var floor = jQuery.grep(floors, function(element, index){
              return element.id == nbFloor;
            });
            var img = floor[0].img;

            self.transitionImages(img);

            // filter flats, get only those who are from building n°3 and floor n°5
            var flatsFiltered = jQuery.grep(self.flats, function(element, index){
              return element.building == nbBuilding && element.floor == nbFloor;
            });

            // for each flat of the floor, draw and add data
            for(var i=0; i<flatsFiltered.length; i++) {
                var f = flatsFiltered[i];

                self.els[f.id] = self.paper.path(f.path);
                self.els[f.id].data("content", f.code);
                self.els[f.id].click(self.handleClickFlat);
            }

            self.styleElements();

            // check availability of the flats
            for(var i=0; i<flatsFiltered.length; i++) {
                var f = flatsFiltered[i];

                // if it's not available
                if(f.rented) {
                    self.els[f.id].attr("fill", "red");
                    self.els[f.id].data("content", "Sold");
                }   
            }
        },

        handleClickFlat: function() {
            var info = this.data('content');

            alert(info);

            // !!! todo : display flat info
        },

        // !!! todo : remove settimeouts
        transitionImages: function(img) {
            $("#svg-container").addClass("noSelect");
            var id = img.split('/').pop().split('.')[0];

            $("#scenes-container").prepend("<div class='scene' id='" + id + "'></div>");

            $('#' + id).css('background-image', 'url(' + App.baseurl + '/img/' + img + ')');

            setTimeout(function() {
                $('.scene').removeClass("showScene");

                $('#' + id).addClass("showScene");
                $("#svg-container").removeClass("noSelect");

                setTimeout(function() {
                    $(".scene").not('#' + id + ', #scene').remove();
                }, 500);
                
            }, 100);
            
        }

    });

}); 