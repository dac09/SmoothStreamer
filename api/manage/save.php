<?php

    //Creating variables for use in SQL statement
    $Key =$_REQUEST['Key'];
    $NewValue = $_REQUEST['Value'];
    $Column = $_REQUEST['Column'];
    $Table = $_REQUEST['Table'];
    $KeyCol = 'rowid';

// Now write to database

    $conn = new PDO("sqlite:db/session.db");
    $conn ->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );  

    $sql = "UPDATE $Table
	        SET $Column=?
	        WHERE $KeyCol=?";

	$q = $conn->prepare($sql);
	$q->execute(array($NewValue,$Key));


?>