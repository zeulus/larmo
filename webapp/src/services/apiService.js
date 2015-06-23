"use strict";

app.service("APIService", apiService);

apiService.$inject = ["AjaxService", "config"];

function apiService(AjaxService, config) {
    var self = {
        getLatestMessages: getLatestMessages,
        getAvailableSources: getAvailableSources
    };

    return self;

    function getLatestMessages(filters, limit) {
        var queryString = angular.extend(filters, {
            limit: limit,
            t: new Date().getTime()
        });

        var url = config.api.useMock
            ? "data/getLatestMessages.json"
            : config.api.url + "/messages";

        return AjaxService.get(url, queryString);
    }

    function getAvailableSources() {
        var url = config.api.useMock
            ? "data/getAvailableSources.json"
            : config.api.url + "/sources";

        return AjaxService.get(url, {t : new Date().getTime()});
    }
}