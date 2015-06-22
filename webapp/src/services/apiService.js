"use strict";

app.service("APIService", apiService);

apiService.$inject = ["AjaxService"];

function apiService(AjaxService) {
    var useMocksData = true;

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

        var url = useMocksData
            ? "data/getLatestMessages.json"
            : "api/messages";

        return AjaxService.get(url, queryString);
    }

    function getAvailableSources() {
        var url = useMocksData
            ? "data/getAvailableSources.json"
            : "api/getAvailableSources";

        return AjaxService.get(url, {t : new Date().getTime()});
    }
}