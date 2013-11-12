
Services.service('Adr', ['$http', 'Error', function ($http,Error) {

	this.getChannels = function(){
		var promise = $http.get('api/getChannels/')
			.success(function(data, status, headers, config){})
			.error(function(data,status, headers, config){Error.add(status, data)});
		return promise;
	}

	this.getStream = function(channelid){
		var promise = $http.get('api/getStream/'+channelid)
			.success(function(data, status, headers, config){})
			.error(function(data,status, headers, config){Error.add(status, data)});
		return promise;
	}

	this.createPages = function(data, elementsPerPage){
		var pages = new Array();
		for (var i = 0; i < data.length; i=i+elementsPerPage) {
			pages.push(data.slice(i,i+elementsPerPage));
		};

		return pages;
	}

}])