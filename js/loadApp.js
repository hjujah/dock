define([
    'app',
    'views/home',
    'views/navigator',
    'views/main',
    'views/locality',
    'router'
], function (App) {

	//fetch the data
	App.Collections = Backbone.Collection.extend({
        url: App.baseurl + 'data'
    });    
    App.CollData = new App.Collections;
    
    App.CollData.fetch().then(function() {
	    App.Data = App.CollData.toJSON()[0];
	    	    
	    //init views
	    App.Views.home = new App.Views.Home;
	    App.Views.navigator = new App.Views.Navigator;
	    App.Views.locality = new App.Views.Locality;
	    
	    //setup pages
	    App.Pages = {
		    home: {
			    collection: App.Data.home,
			    view: App.Views.home
		    },
		    navigator: {
			    collection: App.Data.references,
			    view: App.Views.navigator
		    },
		    locality: {
			    collection: App.Data.references,
			    view: App.Views.locality
		    }
	    }
	
	    //init main and router
	    App.Main = new App.Views.Main;
	    App.Router = new App.Router;
	
	    
    })
        

});