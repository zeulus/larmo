"use strict";

app.service("APIService", apiService);

apiService.$inject = ["AjaxService"];

function apiService(AjaxService) {
    var useMocksData = true;

    var self = {
        getLatestMessages: getLatestMessages,
    };

    return self;

    function getLatestMessages(limit) {
        var url = useMocksData
            ? "/data/getLatestMessages?limit=" + limit + "&t="
            : "/api/messages?limit=" + limit + "&t=";

        return AjaxService.get(url + new Date().getTime());
    };
}