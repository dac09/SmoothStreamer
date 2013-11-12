'use strict';

/* Services */


// Demonstrate how to register services

Services.service('Session', ['$http', 'Error', function ($http, Error) {

	var currentInstance;

	this.changeInstance = function(rowid){
		console.log(rowid);
		$.cookie('rowid', rowid);
	}

	this.initInstance = function(rowid){
		console.log('initInstance')
		return $http.get('api/initInstance/'+rowid)
								.success(function(data, status, headers, config){})
								.error(function(data,status, headers, config){Error.add(status, data)});
	}

	this.resetInstance = function(){
		$.cookie('rowid', '1');
		console.log($.cookie('rowid'));
	}

	this.getInstances = function(){
		var promise = $http.get('api/getInstances')
								.success(function(data, status, headers, config){})
								.error(function(data,status, headers, config){Error.add(status, data)});

		return promise;
	}
}])