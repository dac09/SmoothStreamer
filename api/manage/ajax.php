<?php



$call = $_REQUEST['call'];
$table = $_REQUEST['table'];
// var_dump($_FILES["csv"]);
// var_dump($table);

switch($call){

	case 'addRow':
		addRow($table);
		break;

	case 'removeRow':
		$id = $_REQUEST['id'];
		removeRow($table, $id);
		break;

	case 'addColumn':
		$columns = $_REQUEST['column'];
		addColumn($table, $columns);
		break;

	case 'removeColumn':
		$column = $_REQUEST['column'];
		removeColumn($table, $column);
		break;

	// case 'addTable':
	// $newtable_input = $_REQUEST['newtable'];
	// $newtable = strtolower($newtable_input);
	// $columns = $_REQUEST['column'];
	// addTable($newtable, $columns);
	// break;

	case 'removeTable':
	removeTable($table);
	break;
} 

function addRow($table){

    $conn = new PDO("sqlite:db/session.db");

    $sql = "INSERT INTO `$table` VALUES('','','','','')";

	$q = $conn->prepare($sql);
	$q->execute();

}


function removeRow($table, $id){

    $conn = new PDO("sqlite:db/session.db");

    $sql = "DELETE FROM `$table`
	        WHERE rowid=?";

	$q = $conn->prepare($sql);
	$q->execute(array($id));

}


function addColumn($table, $columns){

    $conn = new PDO("sqlite:db/session.db");


	foreach ($columns as $value){

		if ($value == end($columns))
			{
				if ($value!="")
				$add_column = $add_column."ADD COLUMN `$value` varchar(30)";
			}
		else
			{		
				if ($value!="")
				$add_column = $add_column."ADD COLUMN `$value` varchar(30), ";
			}
	}

     // $add_column = $add_column."ADD COLUMN `$column`[0] varchar(30), ADD COLUMN `$column`[1] varchar(30)";

    $sql = "ALTER TABLE `$table` 
    		$add_column";

	        //ADD COLUMN `$column` varchar(50)";

	$q = $conn->prepare($sql);
	$q->execute();

}

function removeColumn($table, $column){
    $conn = new PDO("sqlite:db/session.db");

    $sql = "ALTER TABLE `$table`
	        DROP COLUMN `$column`";

	$q = $conn->prepare($sql);
	$q->execute();
}

function removeTable($table){
	$conn = new PDO("sqlite:db/session.db");

    $sql = "DROP TABLE `$table`";

	$q = $conn->prepare($sql);
	$q->execute();
}



?>