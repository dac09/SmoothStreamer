'use strict';

/* Directives */


angular.module('myApp.directives', []).
  directive('ovp', ['Adr', function(Adr) {
    return {
	    restrict: 'EA',
	    // templateUrl: "partials/ovp-silverlight.html",
	    link: function(scope, element, attrs) {
	    	scope.$watch('channelId',function(){
	    	var channelId = attrs.channelid;
	    	console.log(channelId);

	    	// Now get stream from Adrenalin

			/*	Adr.getStream(attrs.channelid).then(function(promise){
					$scope.Session = promise.data.Session;
				})
	  		*/

	  		// ====NOTE ==== This is temporary code, needs to go inside the .then() function above
	  		var playURL = 'http://playready.directtaps.net/smoothstreaming/SSWSS720H264/SuperSpeedway_720.ism/Manifest';
	  		var ovp = '  <object data="data:application/x-silverlight-2," type="application/x-silverlight-2" width="100%" height="' +attrs.height+' id="slp" ><param name="source" value="ClientBin/OVP_modified.xap"/><param name="minRuntimeVersion" value="4.0.50401.0" /> <param name="onerror" value="onSilverlightError" /><param name="background" value="black" /> <a href="http://go.microsoft.com/fwlink/?LinkID=124807" style="text-decoration: none;"><img src="http://go.microsoft.com/fwlink/?LinkId=108181" alt="Get Microsoft Silverlight" style="border-style: none"/></a> <param name="initparams" value="showstatistics=true, autoplay=true, muted=false, playlistoverlay=false, loglevel=All, theme=ClientBin/sl4themes/SmoothHD.xaml,smfPlugins=ClientBin/OverlayLogWriter.xap ClientBin/MSSmoothStreamingPlugin.xap, stretchmode=Fit, stretchmodefullscreen=Fit, \
	  		mediasource='+ playURL +', CustomData=<CustomData>><CustomerId></CustomerId></CustomData>" /></object>';

	  		// Reload the player with the new URL
	  		element.html(ovp);
	    })
	    	
	    },

	}
  }]);
