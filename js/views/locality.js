/*
Dock Page
Author: Filip Arneric
*/

define(['app', 'text!templates/locality.html', 'async!http://maps.google.com/maps/api/js?sensor=false'], function(App, Template) {

    App.Views.Locality = Backbone.View.extend({
        el: '#main',
        template: Template,
        firstInit: true,
        markersData: {},
        markers: [],
        map: {},
        iterator: 0,
        events: {
            "click #filters div": "filterMarkers"
        },
                                        
        render: function() {
        	
        	var self = this;
        	
        	//compile template
            var template = Handlebars.compile(self.template);
            self.content = template({
                data: self.model
            }); 
        	self.$el.html(self.content);  

            self.getData();
        },

        getData: function() {
            var self = this;

            // get data of markers
            $.getJSON(App.baseurl + "js/data/markers.json", function(data) {
                self.markersData = data;

                self.initMap();
                self.displayFilters();
            });
        },

        closeInfoWindow: function() {
            if(this.infowindow) {
                this.infowindow.close();
            }
        },

        displayFilters: function() {
            // get the different types
            var types = [];

            for(var i=0; i<this.markersData.length; i++) {
                types.push(this.markersData[i].type);
            }

            types = _.uniq(types);
            
            // display filters
            for(var j=0; j<types.length; j++) {
                $("#filters").append("<div class='active' data-type='" + types[j] + "'>" + types[j] + "</div>");
            }
        },

        filterMarkers: function(e) {
            $(e.target).toggleClass("active");

            this.closeInfoWindow();

            var filtersActive = [];
            $(".active").each(function() {
                filtersActive.push($(this).attr("data-type"));
            });

            /*$("#map img").each(function() {
                if($(this).width() == 22) {
                    $(this).fadeOut(200);
                }
            });*/

            // filter the markers
            for(var i=0; i<this.markers.length; i++) {
                this.markers[i].setVisible(false);
                for(var j=0; j<filtersActive.length; j++) {
                    if(this.markers[i].type == filtersActive[j]) {

                        this.markers[i].setVisible(true);

                        /*$("img[usemap='#gmimap" + this.markersData[i].id + "']").fadeIn(200);
                        
                        var allImages = $('#map img');

                        var icons = allImages.filter(function(){
                          return ($(this).width() == 22);
                        });

                        for(var k=1; k<=icons.length; k++) {
                            if(k == App.Views.locality.markersData[i].id) {
                                $(icons[k]).fadeIn();
                            }
                        }*/
                    }
                }
            }
        },

        initMap: function() {
            var self = this;

            // custom style for the map
            var styles = [
                {
                    featureType: 'water',
                    elementType: 'geometry',
                    stylers: [
                        { hue: '#ffffff' },
                        { saturation: -100 },
                        { lightness: 100 },
                        { visibility: 'on' }
                    ]
                },{
                    featureType: 'landscape',
                    elementType: 'all',
                    stylers: [
                        { hue: '#dedede' },
                        { saturation: -100 },
                        { lightness: -2 },
                        { visibility: 'on' }
                    ]
                },{
                    featureType: 'road',
                    elementType: 'all',
                    stylers: [
                        { hue: '#999999' },
                        { saturation: -100 },
                        { lightness: -6 },
                        { visibility: 'on' }
                    ]
                },{
                    featureType: 'road.highway',
                    elementType: 'all',
                    stylers: [
                        { hue: '#888888' },
                        { saturation: -100 },
                        { lightness: -17 },
                        { visibility: 'on' }
                    ]
                },{
                    featureType: 'poi.park',
                    elementType: 'all',
                    stylers: [
                        { hue: '#cccccc' },
                        { saturation: -100 },
                        { lightness: 9 },
                        { visibility: 'on' }
                    ]
                }
            ];

            // map options
            var mapOptions = {
                center: new google.maps.LatLng(50.075577, 14.43781),
                zoom: 14,
                mapTypeId: 'Styled',
                mapTypeControlOptions: {
                  mapTypeIds: []
                }
            };

            // different icons for types
            self.icons = {
              restaurant: {
                icon: App.baseurl + 'img/locality/marker.png'
              },
              testtype: {
                icon: App.baseurl + 'img/locality/marker_2.png'
              },
              lorem: {
                icon: App.baseurl + 'img/locality/marker_3.png'
              }
            };

            // create the map
            self.map = new google.maps.Map(document.getElementById("map"), mapOptions);
            var styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });
            self.map.mapTypes.set('Styled', styledMapType);

            // close info window on click on map
            google.maps.event.addListener(self.map, "click", function () {
                self.closeInfoWindow();
            }); 

            // add markers
            for(var i=0; i<self.markersData.length; i++) {
                setTimeout(function() {
                  self.addMarker();
                }, i * 200);
            }
        },

        addMarker: function() {
            var self = this;

            var marker = self.markersData[self.iterator];

            // create the marker with options
            self.markers.push(new google.maps.Marker({
                position: new google.maps.LatLng(marker.lat, marker.lng),
                animation: google.maps.Animation.DROP,
                optimized: false,
                icon: self.icons[marker.type].icon
            }));

            var m = self.markers[self.iterator];

            // add the markers to the map
            m.type = marker.type;
            m.setMap(self.map);

            // open info window on click
            google.maps.event.addListener(m, 'click', function() {
                // close previous one
                self.closeInfoWindow();

                // open new one
                self.infowindow = new google.maps.InfoWindow({content: marker.title});
                self.infowindow.open(self.map, m);
            });

            self.iterator++;
        },

        initialize: function() {
            var self = this;
            _.bindAll(this, 'render');
        }

    });

}); 