'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', [
  'ngRoute',
  'myApp.filters',
  'myApp.services',
  'myApp.directives',
  'myApp.controllers'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/', {templateUrl: 'partials/singlePlayer.html', controller: 'SinglePlayerCtrl'});
  $routeProvider.when('/multi', {templateUrl: 'partials/multiPlayer.html', controller: 'MultiPlayerCtrl'});
  $routeProvider.when('/report', {templateUrl: 'partials/report.html', controller: 'ReportCtrl'});
  $routeProvider.otherwise({redirectTo: '/'});
}]);

//Register services
var Services = angular.module('myApp.services', []);