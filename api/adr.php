<?php

function getChannels() {
  /*
      Example: getChannels
      Arguments: None
      Response: All available channels with logos and names. No events listed.
     */
  
  $instanceId = $_COOKIE['rowid'];
  $adr = getInstance($instanceId);
  echo file_get_contents('channels.json');
}

function getChannel() {
  /*
      Example: getChannel
      Arguments: Channel ID
      Response: Returns Name, Pictures, Event count and currently playing and following event for requested channel. Event details present.
     */

}


function getStream() {
  /*
 Example: getStream/channel/16235 OR getStream/ondemand/crid:~~2F~~2Fbds.tv~~2F342705214
 Arguments: Type of stream & ID of requested stream
 Response: Creates a session with TRAXIS 5J interface (and closes immediately for simplicity's sake). Returns url for stream manifest.
*/
  
}

function closeSession( $adr, $session_id ) {

}

function getNowNext() {
  /*
      Example: getNowNext/17744
      Arguments: Channel ID passed from EPGview
      Response: Current event, and next event details, along with their associated title for requested channelid
     */

}



?>
