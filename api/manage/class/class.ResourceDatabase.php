<?php

class ResourceDatabase{
	
	public $DBTables;


	function __construct(){
		//echo "<h1>$this->TableName</h1>";
	}

	function printTables(){
		// $dbh = new PDO("sqlite:db/session.db");
		// $sql = "SHOW TABLES FROM resources";											//REMEMBER to use double quotes when using a $var
		// $query = $dbh->prepare($sql);
		// $query->execute();
		// $TableArray = $query->fetchAll(PDO::FETCH_NUM);
		// $i=0;

	 //    foreach ($TableArray as $tables) {
	 //    	echo "<li> <a href=\"?table=$tables[0]\"> ",ucwords($tables[0]),"</a></li>";
	 //    	$this->DBTables[$i]=$tables[0];
	 //    	$i++;
		//     }
	
	$this->DBTables[0]='session';


	}



	function defaultTable(){
		return $this->DBTables[0];
	}
}


?>