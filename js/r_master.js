$(document).ready(function(){

 

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
        alert("Please select report");
        return false;
      }
      else

      {  
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
    
