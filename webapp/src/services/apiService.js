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

    function getLatestMessages(limit) {
        var url = useMocksData
            ? "data/getLatestMessages.json?limit=" + limit + "&t="
            : "api/messages?limit=" + limit + "&t=";

        return AjaxService.get(url + new Date().getTime());
    }

    function getAvailableSources() {
        var url = useMocksData
            ? "data/getAvailableSources.json?t="
            : "api/getAvailableSources?t=";

        return AjaxService.get(url + new Date().getTime());
    }
}