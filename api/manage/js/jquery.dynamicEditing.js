/* 

CUSTOM FUNCTIONS for Acceess resource DB
----- Author:  Daniel Choudhury ----------

Requires: jQuery, jQuery.jEditable, jQuery.Validate

*/


$(document).ready(function() {

      $('.edit').editable(function(value, settings) { 
                               $Key = $(this).attr("id");
                               $Column = $(this).attr("col");
                               $Table = $("#TableName").html().toLowerCase();
                               //console.log($Table);
                               //console.log($Column);


                              $.post(
                                'save.php',
                                {Key: $Key, Value: value, Column:$Column, Table:$Table}

                                )

                               return(value);
                             },

                              { event : 'dblclick'} 

                         )
  

            $.validator.addMethod("no_sc", function(value, element) {
            return this.optional(element) || /^[a-z0-9\_\-]+$/i.test(value);
            }, "No spaces or punctutation please");

            $("#addtableform").validate({
                          errorClass:'error help-inline',
                          validClass:'success',
                          errorElement:'small',
                          highlight: function (element, errorClass, validClass) { 
                            $(element).parents("div.control-group").addClass(errorClass).removeClass(validClass); 
                            $(element).css("border-color", "rgba(255,48,48,0.8)");
                            $(element).css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 48, 48, 0.6)");
                            $("#addtablesubmit").attr("disabled","disabled");
                          }, 
                          unhighlight: function (element, errorClass, validClass) { 
                                  $(element).parents(".error").removeClass(errorClass).addClass(validClass); 
                                  $(element).removeAttr("style");
                                  $("#addtablesubmit").removeAttr("disabled");
                          }
                        });

              $("#addcolumnform").validate({
                          errorClass:'error',
                          validClass:'success',
                          errorElement:'small',
                          highlight: function (element, errorClass, validClass) { 
                            $(element).parents("div.control-group").addClass(errorClass).removeClass(validClass); 
                            $(element).css("border-color", "rgba(255,48,48,0.8)");
                            $(element).css("box-shadow", "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 48, 48, 0.6)");
                            $("#addcolumnform #commit").attr("disabled","disabled");
                          }, 
                          unhighlight: function (element, errorClass, validClass) { 
                                  $(element).parents(".error").removeClass(errorClass).addClass(validClass); 
                                  $(element).removeAttr("style");
                                  $("#addcolumnform #commit").removeAttr("disabled");
                          },
                           errorPlacement: function(error, element) {
                          error.insertAfter(element.next());
                          }

                        });



    $("#addcolumnform").keypress(submitNewColumn);
    


 });


    function addRow(){
      $.post("ajax.php", {call: 'addRow', table:$("#TableName").html().toLowerCase()}, function() {
      location.reload();
})
    }


function removeRow($id){
        //console.log($id);
       $.post("ajax.php", {call: 'removeRow', table: $("#TableName").html().toLowerCase(), id: $id},
                function(){ location.reload(); 
                })
        }

    function addColumn(){
      $.post("ajax.php", {call: 'addColumn', table:$("#TableName").html().toLowerCase()}, function() {
    //location.reload();
})
    }

function addMoreColumns($form){

    if ($form == 'addcolumnform'){
     $("#addcolumnform .columnsection").prepend("<input id=\"newColumn[]\" class=\"no_sc\" \"style=\"margin-bottom: 15px;\" type=\"text\" name=\"column[]\" size=\"15\" /> <br>");
    }
    else
    {
     $("#addtableform .columnsection").append("<input id=\"newColumn[]\" class=\"no_sc\" \"style=\"margin-bottom: 15px; width: 50%;\" type=\"text\" name=\"column[]\"  /> <br>");
   }
}

function removeColumn($column){
       $.post("ajax.php", {call: 'removeColumn', table: $("#TableName").html().toLowerCase(), column: $column},
                function(){ location.reload(); })
        }


function modifyTable(){
      if($('#columnRemove').length == 0){

      //Display crosses next to column headers
      $('.columnHeader').append('<img style=\"margin-left:5px\" onclick=\"areYouSure(\'removeColumn\',($(this).parent().text()))\" class=\"icon-remove-circle\" id=\"columnRemove\"></img>');
      
      //Display crosses next to first cell of each row
      $("#db-output tr td:first-child").prepend('<img style=\"margin-right:5px\" onclick=\"removeRow($(this).parent().attr(\'id\'))\" \
        class=\"icon-remove-circle\ rowRemove"></img>');

      //Display remove table link
      // $("#TableEdits").append('<div class=\"btn btn-mini btn-danger\" onClick=\"areYouSure(\'removeTable\')\"> Delete Table </div> \
      //                          <div class=\"btn btn-mini btn-warning\"> Rename Table </div>\
      //                          <div class=\"btn btn-mini btn-inverse\"> Export Table </div>');

      }

      else{
          $('.columnHeader').children("img").remove();
          $(".rowRemove").remove();
          $("#TableEdits").empty();

      }
}


function removeTable(){

$.post("ajax.php", {call: 'removeTable', table: $("#TableName").html().toLowerCase()},
                function(){ location.href= location.href.substring(0,location.href.indexOf("?")); 
                })

}

function areYouSure(action, data){

  switch (action){
    case 'removeTable':
    message = "You're about to permanently delete this table from the database. Data can <strong> not </strong> be retrieved!"
    action='removeTable()';

    break;

    case 'removeColumn':
    message = "You're about to remove the column, along with its data."
    action='removeColumn("'+data+'")';

    break;
  }

  $('#AlertPlaceholder').html('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>\
                                <h3 style="margin-bottom: -5px;"> Are you sure? </h3> <span>'+message+'</span><br> \
                                <div class="btn btn-danger" onClick=' +action+ '>Just do it!</div>\
                                <div class="btn" data-dismiss="alert">Cancel</div>\
                                </div>').hide();


  $('#AlertPlaceholder').fadeIn();

}


  $(function highlight(){
    //Highlight columns
    $(".columnHeader").hover(function(){
      if($('#columnRemove').length >= 1){
       $colName = $(this).text();
       //console.log($colName);
       $('td[col='+ "$colName" +']').addClass("greyout");
      }
  },
  function(){
         $colName = $(this).text();
       $('td[col='+ $colName +']').removeClass("greyout");
  }
  )

  $("#db-output tr").not(':first').hover(function(){
    if($('#columnRemove').length >=1){
      $(this).addClass("greyout");

    }
  },

  function(){
          $(this).removeClass("greyout");
  })

  })

$(function preventDropdownCollapse() {
  // Setup drop down menu
  $('.dropdown-toggle').dropdown();
 
  // Fix input element click problem
  $('.dropdown input, .dropdown label').click(function(e) {
    e.stopPropagation();
  });
});

$(function submitForm(){



  $('#addcolumnform #commit').click(function(event){
    var table = $("#TableName").html().toLowerCase();
    $.post( "ajax.php", $("#addcolumnform").serialize()+ "&table=" + table + "&call=addColumn", function() {
      location.reload();
      });
    });

 $('#addtablesubmit').click(function(event){
    $("#addtableform").submit();

  });

})


$(function uploadCSV(){
  $("#addtableform #uploadCSV").click(function(){

    if($("input:checked[name='uploadCSV']").length==1){ //When checked
      $("#addtableform input[name='column[]']").attr("disabled","disabled");
      $("#addtableform .columnsection").slideUp();
      $("#addtableform #csv").removeAttr("disabled");
      $("#csvwarn").slideDown();

    }
    else{     //When unchecked
      $("#addtableform input[name='column[]']").removeAttr("disabled");
      $("#addtableform .columnsection").slideDown();
      $("#addtableform #csv").attr("disabled","disabled");
      $("#csvwarn").slideUp();

    }
    


  })


})

var submitNewColumn= function (event) {
        if(event.keyCode == 13) {
            event.preventDefault();
            //event.stopPropagation();
            // if (form=='column')
              $("#addcolumnform #commit").click();
            // else if (form=='table')
            //   $('#addtablesubmit').click();
        }
    }

