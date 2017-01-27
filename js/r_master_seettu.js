$(document).ready(function(){

    $("#book_edition").keypress(function(e){
        if(e.keyCode == 112){
          $("#pop_search13").val($("#book_edition").val());
          load_book();
          $("#serch_pop13").center();
          $("#blocker").css("display", "block");
          setTimeout("$('#pop_search13').focus()", 100);
        }
        $("#pop_search13").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_book();
          }
        }); 
        if(e.keyCode == 46){
          $("#book_edition").val("");
          $("#book_des").val("");
        }
    });


    $("#settu_item_category").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search2").val($("#settu_item_category").val());
            load_data9();
            $("#serch_pop2").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search2').focus()", 100);
        }

       $("#pop_search2").keyup(function(e){
            
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_data9();
            }
        }); 

        if(e.keyCode == 46){
            $("#settu_item_category").val("");
            $("#category_name").val("");
        }
    });

    $("#btnPrint").click(function(){

      if($("input[type='radio']:checked").length == 0)
      {
        set_msg("Please select report");
        return false;
      }
      else{  
          $("#print_pdf").submit();
        } 

    });  
});
    
function load_data9(){

       
        $.post("index.php/main/load_data/utility/f1_selection_list", {
            data_tbl:"m_settu_item_category",
            field:"code",
            field2:"name",
            preview1:"Code",
            preview2:"Name",
            add_query:"AND book_edition='"+$("#book_edition").val()+"'",

            search : $("#pop_search2").val() 
        }, function(r){
            $("#sr2").html("");
            $("#sr2").html(r);
            settings9();            
        }, "text");
    }

function settings9(){
    $("#item_list .cl").click(function(){        
        $("#settu_item_category").val($(this).children().eq(0).html());
        $("#category_name").val($(this).children().eq(1).html());
        
         var price=$(this).children().eq(1).html();
          var a="  Rs."+price.split('=')[1]+"=";
        
        $("#pop_close2").click();
        $("#price_value").html("");
         $("#price_value").css("display", "block");

        $("#price_value").append(a);               
    })    
}

function validate(){

    var category = $("#settu_item_category").val();
   
   if (category==""||category==null){
      set_msg("Please add category");
      $("#settu_item_category").focus();
      return false;
   }
   else{
    //alert("aa1");
      return true;
   }    

}

function load_book(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_settu_book_edition",
      field:"code",
      field2:"description",
      preview2:"Edition Name",
      add_query:"AND is_active='1'",
      search : $("#pop_search13").val() 
  }, 
  function(r){
      $("#sr13").html(r);
      settings_book();        
  }, "text");
}

function settings_book(){
  $("#item_list .cl").click(function(){        
    $("#book_edition").val($(this).children().eq(0).html());
    $("#book_des").val($(this).children().eq(1).html());
    $("#pop_close13").click();                
  })    
}
    
