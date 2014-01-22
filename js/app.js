define(['jquery', 'underscore', 'backbone', 'handlebars'], function ($, _, Backbone) {

    var App = {
        Views: {},
        firstLoad: true,
        baseurl: absurl
    };

    App.vent = _.extend({}, Backbone.Events);

    return App;
});