/*
Dock Page
Author: Clement Grellier
*/

define(['app', 'text!templates/locality.html', 'async!http://maps.google.com/maps/api/js?sensor=false'], function(App, Template) {

    App.Views.Locality = Backbone.View.extend({
        el: '#main',
        template: Template,
        firstInit: true,
        markersData: {},
        markers: [],
        defaultZoom: 13,
        markerWidth: 19,
        map: {},
        events: {
            "click #filters div": "filterMarkers"
        },
                                        
        render: function() {
        	var self = this;

            self.getData();

            // init iterator
        	self.iterator = 0;

        	//compile template
            var template = Handlebars.compile(self.template);
            self.content = template({
                data: self.model
            });
        	self.$el.html(self.content);  

            self.delegateEvents();
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
            var self = this;

            // get the different types
            var typesArray = [];

            for(var i=0; i<this.markersData.length; i++) {
                typesArray.push(this.markersData[i].type);
            }

            // unique types only
            self.types = _.uniq(typesArray);
            
            // display filters
            // !!! todo : template ?!
            for(var j=0; j<self.types.length; j++) {
                var cleanType = self.types[j].replace(/\s+/g, '')
                var div = "<div data-type='" + cleanType + "' style='background-image:url(" + self.icons[cleanType].icon + ")'>" + self.types[j] + "</div>";
                $("#filters").append(div);
            }

            setTimeout(function() {
                $("#filters div").each(function(i) {
                    $(this).delay(200*i).queue(function(){$(this).addClass('active')});
                });
            }, 500);
        },

        filterMarkers: function(e) {
            var self = App.Views.locality;
            $(e.target).toggleClass("active");

            // close the info window if necessary
            self.closeInfoWindow();

            var icon = self.icons[$(e.target).attr("data-type")].icon;

            if(!$(e.target).hasClass("active")) {
                // hide markers
                $('#map img[src*="' + icon + '"]').animate({
                    'opacity': 0
                }, 300, function() {
                    $(this).css('margin-top', '-30px');
                    $(this).parent().css("overflow", "inherit");
                });
            } else {
                // show markers
                $('#map img[src*="' + icon + '"]').animate({
                    'opacity': 1,
                    'margin-top': '0px'
                }, 200);
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
                zoom: self.defaultZoom,
                mapTypeId: 'Styled',
                mapTypeControlOptions: {
                  mapTypeIds: []
                }
            };

            // different icons for types
            // !!! todo : make it dynamic?

            self.icons = {
              restaurant: {
                icon: App.baseurl + 'img/locality/marker.png'
              },
              testtype: {
                icon: App.baseurl + 'img/locality/marker_2.png'
              },
              lorem: {
                icon: App.baseurl + 'img/locality/marker_3.png'
              },
              loremipsum: {
                icon: App.baseurl + 'img/locality/marker_4.png'
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
                icon: self.icons[marker.type.replace(/\s+/g, '')].icon
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