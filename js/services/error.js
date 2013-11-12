'use strict';

/* Error Service */

Services.service('Error', [function () {

	this.comments = ["Oops!", "Umm...", "Oh boy!", "Uhhhhhh"];

	this.add = function(status, description){
		var errorScope = $('#error-area').scope();
		var error = {"Status": status, "Description":description, "Comment": this.comments[Math.floor(Math.random() * this.comments.length)]};
		errorScope.errors.push(error);
	}

	this.comment = function(){

	}
}])