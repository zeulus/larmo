"use strict";

app.controller("AppController", AppController);
    
AppController.$inject = ["$rootScope"];
    
function AppController($rootScope) {
        $rootScope._ = translation;
}