<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Backend Service Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Daniel Choudhury">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 110px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">

      <div class="navbar-inner">
        <div class="row">
                  <div class="span6" id="AlertPlaceholder"></div>
                </div>

        <div class="container">

          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar">          <a class="brand" href="index.php"><img class="logo" src="img/vm-logo.png"></a></span>
            <span class="icon-bar"></span>
          </a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Home</a></li>
            </ul>

          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container wrapper">
    <div class="row">

      <div class="page-header" style="text-align:center"><h1>Adrenaline Instance Management</h1></div>
      <?php
      include('class/class.ResourceDatabase.php');
      $CurrentDB = new ResourceDatabase();
      ?>

    <div class="span1"></div>

    <div class="span2 btn-group">
      <a class="btn btn-large btn-block btn-primary dropdown-toggle disabled" data-toggle="dropdown">
        Choose Table   <b class="caret"></b></a>
    <ul id="choosetable" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
      <?php
      $CurrentDB->printTables();            //Get list of tables from database
      ?>
    </ul>
</div>


<div class="span2 btn-group">
      <a class="btn btn-large btn-block btn-info disabled" data-toggle="modal" href="#addTable">
      Add Table <img class="icon-plus icon-white"></img>  </a>
</div>

<div class="span2 btn-group">

      <a class="btn btn-block btn-large btn-danger" id="modifytable" onClick="modifyTable()">
        Modify Table <img class="icon-edit icon-white"></img>  </a>
      </div>

   <div class="span2 btn-group dropdown">

      <a id="addcolumn" class="btn btn-large  btn-block btn-success dropdown-toggle disabled" data-toggle="dropdown">
        Add Column <img class="icon-plus-sign icon-white"></img></a>

      <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
      <form id="addcolumnform" autocomplete="off">
        <div class="muted"><strong>Enter new column name(s)</strong></div>
            <div class="columnsection">
            <input id="newColumn[]" style="margin-bottom: 15px;" class="no_sc required" type="text" name="column[]" size="15" /> <br>
            </div>
            <span class="error_area"></span>
        <div onClick="addMoreColumns('addcolumnform')" class="btn btn-warning"><img class="icon-plus-sign icon-white"></img></div>
        <input class="btn btn-primary" style="clear: left; width:80%; height: 32px; font-size: 13px;" type="button" value="Done" id="commit"/>
      </form>
      </div>
  </div>

    <div class="span2 btn-group">

      <a id="addrow" class="btn btn-large  btn-block btn-warning" onclick="addRow()">
        Add Row <img class="icon-plus-sign icon-white"></img></a>
      </div>

 <div class="span1"></div>


      
</div>
</br> 
<table class="table table-striped" id="db-output">

<?php
      // ---------- Assign table ------------------
        if (empty($_GET)){
          $SelectedTable = $CurrentDB->defaultTable();  
          }
        else {  
          $SelectedTable = $_GET['table'];
          }
        $TableName = ucwords($SelectedTable);
      //    ------------ Print table name ----------
      echo "<h1 id=\"TableName\">$TableName</h1>";
?>
      
       <div id=\"TableEdits\">
       <div class="btn btn-mini btn-danger" onClick="areYouSure('removeTable')"> Delete Table </div> 
<!--        <div class="btn btn-mini btn-warning"> Rename Table </div>
        <a class="btn btn-mini btn-inverse" href="export.php"> Export Table </a> -->
        <?php echo "<a class=\"btn btn-mini btn-inverse\" href=\"export.php?table=".$SelectedTable."\"> Export Table </a>" ?>

      </div></br>

<?php

  include('class/class.ResourceTable.php');
  

  $table = new ResourceTable();
  $table->setTable($SelectedTable);
  $table->printColumns();
  $table->printRows();
?>

</table>

<!-- ================ ADD NEW TABLE MODAL WINDOW ============== -->

<div id="addTable" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header" style="background-color:#252525; color:#FFF;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel" style="color:#EEE">Add new table to database</h3>
  </div>
  <div class="modal-body" style="padding: 30px; background-color:#EFEFEF;">
    <form id="addtableform" action="addTable.php" autocomplete="off">
      <h4 style="margin-bottom: 5px;" >Table Name:</h4>
      <input name="newtable" class="required no_sc" type="text" style="margin-bottom: 15px; font-size:16x;"></input>
      <div class="columnsection">
      <h4 style="margin-bottom: 8px;" ><strong>Enter new column name(s)</strong></h4>
      <input id="newColumn[]" class="no_sc" style="margin-bottom: 15px;" type="text" name="column[]" width="70" style="font-size: 30px"/>
      <span class="btn btn-warning" id="addmorecolumns" onClick="addMoreColumns('addtableform')" style="margin-left:15px; margin-top: -15px;">Add more columns  <img class="icon-plus-sign icon-white"></img></span>
      <br>
      <br>
      </div>
      <h4 style="margin-bottom: 8px;" ><strong>Upload CSV file</strong><input id="uploadCSV" name="uploadCSV" style="margin-top:-5px" type="checkbox"/></h4>
      <input id="csv" name="csv" type="file" disabled="disabled"/><br><br>
      <input type="submit" class="hide">
      <div id="csvwarn" class="alert hide"><small>Please ensure there are no additional lines (e.g. titles, comments) or symbols on column headers on the CSV.</small></div>
      </div>

    </form>

  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button id="addtablesubmit" class="btn btn-primary">Save changes</button>
  </div>
</div></div>
<!-- ================ ///////////////////////// ============== -->
  </div> <!-- /container -->
         
           <footer class="footer navbar navbar-fixed-bottom">
           <div class="muted"><small>Please be aware that all data is being live edited. For best experience use Chrome or Firefox. </a></small></div>          
           </footer>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-min-182.js"></script>
    <script src="js/bootstrap.min.touchfix.js"></script>
    <script src="js/jquery.jeditable.modified.min.js"></script>
    <script src="js/jquery.dynamicEditing.js"></script>
    <script src="js/jquery.validate.js"></script>
     <script src="js/jquery.form.js"></script>

<script> 
        // wait for the DOM to be loaded 
        $(document).ready(function() { 

            var options = {
              success: refreshPage
            };
            // bind 'myForm' and provide a simple callback function 
            $('#addtableform').ajaxForm(options); 

            function refreshPage(responseText, statusText, xhr, $form){
                   location.href = location.href.substring(0,location.href.indexOf("?")) + '?table=' + responseText ;
            };

        }); 
    </script> 
  

</body></html>