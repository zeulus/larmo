"use strict";

var config = SITE_CONFIG || {};
app.constant("config", {
    "api" : {
        "useMock": config.useMock ? config.useMock : true,
        "url": config.apiUrl ? config.apiUrl : "http://larmo-hub.herokuapp.com"
    }
});