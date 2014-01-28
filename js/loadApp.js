define([
    'app',
    'views/navigation',
    'views/page',
    'views/home',
    'views/about',
    'views/navigator',
    'views/main',
    'views/locality',
    'views/3dExperience',
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
	    App.Views.navigation = new App.Views.Navigation;
	    App.Views.page = new App.Views.Page;
	    App.Views.home = new App.Views.Home;
	    App.Views.about = new App.Views.About;
	    App.Views.navigator = new App.Views.Navigator;
	    App.Views.locality = new App.Views.Locality;
	    App.Views.flatPreview = new App.Views.FlatPreview;
	    
	    //setup pages
	    App.Pages = {
		    home: {
			    collection:	{
				    0: App.Data.home
			    },
			    view: App.Views.home
		    },
		    
		    about: {
			    collection: {
				    0: "About Page",
				    1: {
					    architects: "Architects",
					    developer: "Developer",
					    project: "Project"
				    }
			    },
			    view: {
				    0: App.Views.about,
				    1: App.Views.page
			    }
		    },
		    
		    navigator: {
			    collection: "Navigator",
			    view: App.Views.navigator
		    },
		    
		    locality: {
			    collection: "Locality",
			    view: App.Views.locality
		    },
		    
		    flatPreview: {
			    collection: "3d Experience",
			    view: App.Views.flatPreview
		    }
	    }
	
	    //init main and router
	    App.Main = new App.Views.Main;
	    App.Router = new App.Router;
	    
    })    

});