<?php

require('bootstrap.php');
require('backendfunctions.php');

$f3=require('src/fatfree/base.php');
$f3->route('GET /',
    function($f3) {
        // $f3->reroute('/player.html');
        echo "hello world";
    }
);

$f3->route('GET /@action', '@action');
$f3->route('GET /@action/@param1', '@action');
$f3->route('GET /@action/@param1/@param2', '@action');
$f3->route('GET /getEvents/@action/@param1', '@action');

$f3->run();

?>