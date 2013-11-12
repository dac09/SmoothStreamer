'use strict';

/* Controllers */

angular.module('myApp.controllers', []).
  controller('MainCtrl', ['$scope', 'Session', function($scope, Session, $cookies) {

	  Session.getInstances().then(function(promise){
	  	$scope.instances = promise.data;
	  });

	  $scope.reset = function(){Session.resetInstance();}
	  $scope.changeInstance = function(rowid){Session.changeInstance(rowid);}
	  $scope.errors = [];

  }])
  .controller('SinglePlayerCtrl', ['Session', '$scope', 'Adr', function(Session, $scope, Adr) {
  		 
  		 if ($.cookie('rowid')==undefined){
			$.cookie('rowid', 1);
		 }

		 var rowid = $.cookie('rowid');
  		 

  		 $scope.currentInstance = '';

		Session.initInstance(rowid).then(function(promise){
			  	$scope.currentInstance = promise.data;
			  })

		Adr.getChannels().then(function(promise){
			$scope.channels = promise.data.Channels.Channel;
		}) 
		
		$scope.changeChannel = function(channelid){
			$scope.channelId = channelid;
		}
  }])
  .controller('MultiPlayerCtrl', ['$scope','Adr', function($scope, Adr) {
	Adr.getChannels().then(function(promise){
			var data = promise.data.Channels.Channel;
			$scope.pages = new Array();
			
			for (var i = 0; i < data.length; i=i+8) {
			$scope.pages.push(data.slice(i,i+8));
			$scope.currentPage = 0;
			};
		}) 

	$scope.setCurrentPage = function(index){
	// console.log(index);
	$scope.currentPage = index;
	}

	$scope.nextPage= function(){
		$scope.currentPage++
	}

	$scope.lastPage = function(){
		$scope.currentPage--;
	}

  }]);