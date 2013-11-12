<?php

class ResourceTable{

	public $TableName;
	public $ColumnHeaders;

	function __construct(){
		//echo "<h1>$this->TableName</h1>";
	}
	
	function setTable($SelectedTable){

 		$this->TableName = $SelectedTable;

	}

	//Methods
	function printRows(){
				try {
		    $dbh = new PDO("sqlite:db/session.db");
		    $sql = "SELECT rowid,* FROM `$this->TableName`";											//REMEMBER to use double quotes when using a $var
		    $query = $dbh->prepare($sql);
		    $query->execute();


		    while($row = $query->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
		        
		        //print_r($row);

		      echo "<tr>";

		      // Iterating through columns

		      for($i=0; $i < $query->columnCount(); $i++){
		      	$column= $this->ColumnHeaders[$i];
		        echo "<td id=$row[0] col=$column class=\"edit\">", $row[$i], "</td>";
		        //print_r($row);
		      }

		      // --------------------------------
		      echo "</tr>";    
		    }

		    $dbh = null;
		} catch (PDOException $e) {
		    showError($e);
		    die();
		}

		echo "</table>";
	}

	function printColumns(){

		try {
		    $dbh = new PDO("sqlite:db/session.db");
		    $sql = "SELECT rowid,* FROM `$this->TableName`";											//REMEMBER to use double quotes when using a $var
		    $query = $dbh->prepare($sql);
		    $query->execute();
		    $row = $query->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);


		    $this->ColumnHeaders = array_keys($row);

		   // print_r ($this->ColumnHeaders);


		      for($i=0; $i < $query->columnCount(); $i++){
		        echo "<th class=\"columnHeader\">", $this->ColumnHeaders[$i], "</th>";
		      }

		    $dbh = null;
		} catch (PDOException $e) {
		    showError($e);
		    die();
		}



	}


	function showError($e){
		echo '<div class="alert"> 
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>"Error: "</strong> . $e->getMessage()</div>';
	}

	function getColumnHeader($i){
		return $this->ColumnHeaders[$i];
	}

	function getName(){
		return $this->TableName;
	}



}



?>