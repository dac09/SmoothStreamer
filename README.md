SmoothStreamer
===============

A Silverlight/MS Smooth Streaming player, meant to be hooked up to a backend service. Written in AngularJS.

Technologies used:
- OVP Silverlight player
- AngularJ5
- Twitter Bootstrap 2.3 (modified)
- jQuery
- Fat Free Framework (PHP)

If you're trying to use this, make sure you checkout Fat Free's setup procedure - you have to enable a couple of 
PHP modules and use the included .htaccess file.

##Why?

No particular reason - maybe someone will find this helpful. It was meant to be a test player to 
create sessions with the backend webservice, and play PlayReady encrypted videos.

Right now its pretty hardcoded, as I had to take a lot of code out which I'm not sure could be publicly released.

##Why not HTML5 video?
At the time of development (and writing this), PlayReady wasn't officially supported on HTML5 video, on the PC/Mac atleast.
MS have demonstrated it, and hope it'll be on its way soon.

##What does it do?
- Gets list of channels from backend RESTFul API (currently hardcoded), displays and allows you to filter
- Plays SmoothStreaming + PlayReady encrypted videos (there's a custom data field if you wish to use)
- Creates a mosaic view with all the channels served by the service, to allow monitoring of channel status
- Has a management UI http://{site}/api/manage/ , that lets you set the server and parameters for speaking to the server.

### The good parts
- Follows MV* convention
- Silverlight player is a directive (!)
- Lets you manage the backend services (and switch between them) (http://{site}/api/manage)
- Services manager uses an sqlite db, so no setup, just pull and run on any web server. Do setup permissions though.
- Responsive webdesign (minus Silverlight)

### The bad parts
- Management interface code is some old stuff I wrote a long time ago, its not MV* or well written. It does work though
- Had to hardcode due to some proprietary bits

