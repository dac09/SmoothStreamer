<?php

include 'adr.php';

/* ==================== TRAXIS CONFIG ========================== */

class adr {
  public $user;
  public $device;
  public $userAgent;
  public $serverurl;
  public $instanceName;
};

/* ==================== UTILITY FUNCTIONS ========================== */

function url_exists( $url ) {

  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_URL, $url );
  // don't download content
  curl_setopt( $ch, CURLOPT_NOBODY, 1 );
  curl_setopt( $ch, CURLOPT_FAILONERROR, 1 );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  if ( curl_exec( $ch ) !== FALSE ) {
    return true;
  } else {
    return false;
  }
}

function getHTTP( $url, $adr ) {
  $response = \Httpful\Request::get( $adr->serverurl . $url . "?Output=Json" )->addHeader( "User-Agent", $adr->userAgent )
    ->timeout(5)
    ->send();

  http_response_code($response->code); //pass through response code
  return $response;
}

function putHTTP( $url, $body, $adr ) {

    $response = \Httpful\Request::put( $adr->serverurl . $url . "?Output=Json" )
    ->addHeader( "User-Agent", $adr->userAgent )
    ->sendsXML()
    ->body( $body )
    ->timeout(5)
    ->send();

  return $response;
  //var_dump($response);
}

function test() {
  echo "<h2>Routing seems to be working</h2>";
}

function proxyTest() {
  $response = \Httpful\Request::get( "http://ip.jsontest.com/?callback=showMyIP" )->send();
  echo $response;
}


//==================== SESSION CALLS ==========================

function initInstance() {
  global $f3;
  $rowid = $f3->get( 'PARAMS.param1' );


  if ( $rowid!="" ) {
    echo json_encode( getInstance( $rowid ) );
  }
  else
    echo json_encode( getInstance( 1 ) );
}

function getInstance( $rowid ) {
  //Open database
  $db_name = 'session.db';
  $db = new PDO( "sqlite:manage/db/$db_name" );

  //Get details
  $sth = $db->prepare( "SELECT * FROM session WHERE rowid=={$rowid}" );
  $sth->execute();
  $row = $sth->fetch();

  //Populate object properties
  $adr = new Adr;
  $adr->instanceName= $row['instance'];
  $adr->serverurl= $row['serverurl'];
  $adr->user = $row['user'];;
  $adr->device = $row['device'];
  $adr->userAgent = $row['useragent'];
  
  return $adr;
}

function getInstances() {
  //Open database
  $db_name = 'session.db';
  $db = new PDO( "sqlite:manage/db/$db_name" );

  //Get details
  $sth = $db->prepare( "SELECT instance,rowid FROM session" );
  $sth->execute();
  $result = $sth->fetchAll();


  echo json_encode( $result );
}

function generateError( $code, $message, $info = '' ) {
  $error = array( "code" => $code,
    "message" => $message,
    "info" => $info );

  return json_encode( $error );
}

?>
