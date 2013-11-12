<?php
function quote($str) {
    return sprintf("'%s'", $str);
}
?>


<?php

$CSV = $_REQUEST['uploadCSV'];
$newtable_input = $_REQUEST['newtable'];
$newtable = strtolower($newtable_input);


if ($CSV=='on'){
	ini_set('auto_detect_line_endings',true);
	$target_path = "/tmp/";
	$target_path = $target_path . basename( $_FILES['csv']['name']); 

	move_uploaded_file($_FILES['csv']['tmp_name'], $target_path); 

	// if(move_uploaded_file($_FILES['csv']['tmp_name'], $target_path)) {
 //    echo "The file ".  basename( $_FILES['csv']['name']). 
 //    " has been uploaded";
	// } else{
	//    echo "There was an error uploading the file, please try again!";
	// }



	$conn = new PDO("sqlite:db/session.db");

    $sql = "CREATE TABLE `$newtable` 
    		(id int NOT NULL AUTO_INCREMENT,
    		PRIMARY KEY(id) 					)";

	$q = $conn->prepare($sql);
	$q->execute();


	echo $newtable; // For refreshing page

//	Add column headers 
// --------------------------------------------------

	$handle = fopen($target_path,"r");
	$columns = fgetcsv($handle, 0, ",");


	foreach ($columns as $value){

	if ($value!="") {
	$checked_value = preg_replace( '/\s+/', '_', $value );
	$add_column = "ADD COLUMN `$checked_value` varchar(50)";
}

    $sql = "ALTER TABLE `$newtable` 
    		$add_column";
   	
   	// echo $sql;

   	$conn = new PDO("sqlite:db/session.db");
	$q = $conn->prepare($sql);
	$q->execute();
	}


//  Add data into table
// --------------------------------------------------

while (($data =fgetcsv($handle, 0, ","))==TRUE)
{

$conn = new PDO("sqlite:db/session.db");

$data_list = implode(",", array_map('quote',$data));
$columns_list = implode(",", $columns);
$columns_list = preg_replace( '/\s+/', '_', $columns_list );

// echo $data_list;

$writedata_sql = "INSERT INTO $newtable($columns_list) VALUES($data_list)";

 //echo $writedata_sql;

$q = $conn->prepare($writedata_sql);
$q->execute();

}
}

else{


	$columns = $_REQUEST['column'];
	$conn = new PDO("sqlite:db/session.db");

	foreach ($columns as $value){
				if ($value!="") 			//prevent processing blank fields
				$create_columns = $create_columns.", `$value` varchar(30)";
	}

    $sql = "CREATE TABLE `$newtable` 
    		(id int NOT NULL AUTO_INCREMENT
    		$create_columns,
    		PRIMARY KEY(id) 					)";

	$q = $conn->prepare($sql);
	$q->execute();

//	addRow($newtable);


	echo $newtable;	//To display table
}

?>



