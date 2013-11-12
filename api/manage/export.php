<?php

    $Table = $_REQUEST['table'];	
	$conn = new PDO("sqlite:db/session.db");
    $sql = "SELECT * FROM $Table";

	$result = $conn->prepare($sql);
	$result->execute();

// Pick a filename and destination directory for the file
// Remember that the folder where you want to write the file has to be writable
	$filename = "/tmp/". $Table . "_export_".time().".csv";
 
// Actually create the file
// The w+ parameter will wipe out and overwrite any existing file with the same name
	$handle = fopen($filename, 'w+');
 	
	$FirstLoop=TRUE;
		
while($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		
		unset($row['id']); 					// Remove id column

		if ($FirstLoop==TRUE){				//  Print Column Headers to csv
			$ColumnHeaders = array_keys($row);
			fputcsv($handle, $ColumnHeaders);
			$FirstLoop=FALSE;
		}

        fputcsv($handle, $row);				// Print rows to csv file. Note $row is an array with multiple values
  }

	// Finish writing the file
	fclose($handle);

	//Export for user to download
	$file_name = $filename;
	header("Content-type: text/x-csv");    
    header("Content-disposition: attachment; filename=\"".$file_name."\""); 
    readfile($filename);



?>