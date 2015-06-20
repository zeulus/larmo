"use strict";

app.controller("MainController", MainController);

MainController.$inject = ["$scope"];

function MainController($scope) {
    $scope.messages = getLatestMessages();

    function getLatestMessages() {
        return [];
    }
}