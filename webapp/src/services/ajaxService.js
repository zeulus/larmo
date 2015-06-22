"use strict";

app.service("AjaxService", ajaxService);

ajaxService.$inject = ["$http"];

function ajaxService($http) {
    var self = {
        get: get,
        post: post
    };

    return self;

    function executeCallback(callback, data) {
        if (callback) {
            callback(data);
        }
    }

    function get(url, successCallback, errorCallback) {
        console.log("[AjaxService] Sent request GET " + url);

        return $http.get(url).success(function (response) {
            console.log("[AjaxService] Response GET " + url, response);
            executeCallback(successCallback, response);
        }).error(function (response) {
            executeCallback(errorCallback, response);
        });
    }

    function post(url, data, successCallback, errorCallback) {
        console.log("[AjaxService] Sent request POST " + url, data);

        return $http.post(url, data).success(function (response) {
            console.log("[AjaxService] Response POST " + url, response);
            executeCallback(successCallback, response);
        }).error(function (response) {
            executeCallback(errorCallback, response);
        });
    }
}