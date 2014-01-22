define([
    'app',
    'views/home',
    'views/navigator',
    'views/main',
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
	    
	    //setup pages
	    App.Pages = {
		    home: {
			    collection: App.Data.home,
			    view: App.Views.home
		    },
		    navigator: {
			    collection: App.Data.references,
			    view: App.Views.navigator
		    }
	    }
	
	    //init main and router
	    App.Main = new App.Views.Main;
	    App.Router = new App.Router;
	
	    
    })
        

});