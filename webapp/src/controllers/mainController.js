"use strict";

app.controller("MainController", MainController);

MainController.$inject = ["$scope", "APIService"];

function MainController($scope, APIService) {
    $scope.messages = [];
    $scope.filters = {source: ""};
    $scope.getLatestMessages = getLatestMessages;

    setupAvailableSources();
    getLatestMessages();

    function setupAvailableSources() {
        APIService.getAvailableSources().then(function(response) {
            $scope.sources = response.data;
        });
    }

    function getLatestMessages() {
        return [];
    }
}