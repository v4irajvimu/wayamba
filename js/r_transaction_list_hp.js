$(document).ready(function(){

$("#btnExit").click(function(){
        return false;
    });

	$("#btnprint").click(function(){

      if($("input[type='radio']:checked").length == 0)
      {
        set_msg("Please select report");
        return false;
      }
      else{  
          $("#print_pdf").submit();
        } 

    });  

 $("#cus_id").keypress(function(e){
    if(e.keyCode==112){
      load_customer();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search').focus()", 100);   
    }
    $("#pop_search").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
       load_customer();
      }
    });
    if(e.keyCode==46){
       $("#cus_id").val("");
       $("#customer").val("");
      }  
  });

  $("#area_code").keypress(function(e){ 
    if(e.keyCode==112){
      load_area();
      $("#serch_pop2").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search2').focus()", 100);   
    }
    $("#pop_search2").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_area();
      }
    });
    if(e.keyCode==46){
       $("#area_code").val("");
       $("#area").val(""); 
    }  
  });

  $("#route_id").keypress(function(e){ 
    if(e.keyCode==112){
      load_route();
      $("#serch_pop15").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search15').focus()", 100);   
    }
    $("#pop_search15").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_route();
      }
    });
    if(e.keyCode==46){
       $("#route_id").val("");
       $("#route_des").val(""); 
    }  
  });

  $("#agreemnt_no").keypress(function(e){ 
        if(e.keyCode==112){
          load_agreement();
          $("#serch_pop10").center();
          $("#blocker").css("display", "block");
          setTimeout("$('#pop_search10').focus()", 100);   
        }
        $("#pop_search10").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_agreement();
          }
        });
        if(e.keyCode==46){
           $("#agreemnt_no").val("");
        }  
  });


  $("#salesman_id").keypress(function(e){
    if(e.keyCode==112){
      load_salesman();
      $("#serch_pop13").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search13').focus()", 100);   
    }
    $("#pop_search13").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_salesman();
      }
    });
    if(e.keyCode==46){
       $("#salesman_id").val("");
       $("#salesman").val("");
      }  
   }); 


$("#col_officer_id").keypress(function(e){
    if(e.keyCode==112){
      load_col_off();
      $("#serch_pop14").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search14').focus()", 100);   
    }
    $("#pop_search14").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_col_off();
      }
    });
    if(e.keyCode==46){
       $("#col_officer_id").val("");
       $("#col_officer").val("");
      } 
       }); 

  $("#guarantor_id").keypress(function(e){
    if(e.keyCode==112){
      load_guarantor();
      $("#serch_pop11").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search11').focus()", 100);   
    }
    $("#pop_search11").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_guarantor();
      }
    });
    if(e.keyCode==46){
       $("#guarantor_id").val("");
       $("#guarantor").val("");
      } 
  });

  opening_hp_ctrl();

});

function opening_hp_ctrl(){
  $.post("index.php/main/load_data/r_transaction_list_hp/opening_hp_ctrl", {

        }, function(r){
          if(r.def_use_opening_hp=="1"){
            $(".op_hp").css("display","block");
          }
        }, "json");   
}



function load_customer(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_customer",
        field:"code",
        field2:"name",
        preview1:"Customer ID",
        preview2:"Customer Name",
        search : $("#pop_search").val() 
    }, function(r){
        $("#sr").html("");
        $("#sr").html(r);
        settings_cus();            
    }, "text");
}

function settings_cus(){
    $("#item_list .cl").click(function(){     
        $("#cus_id").val($(this).children().eq(0).html());
        $("#customer").val($(this).children().eq(1).html());
        $("#pop_close").click();                
    })    
}

function load_area(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"r_area",
        field:"code",
        field2:"description",
        preview1:"Area ID",
        preview2:"Area Name",
        search : $("#pop_search2").val() 
    }, function(r){
        $("#sr2").html("");
        $("#sr2").html(r);
        settings_area();            
    }, "text");
}

function settings_area(){
    $("#item_list .cl").click(function(){     
        $("#area_code").val($(this).children().eq(0).html());
        $("#area").val($(this).children().eq(1).html());
        $("#pop_close2").click();                
    })    
}

function load_route(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"r_root",
        field:"code",
        field2:"description",
        preview1:"Route ID",
        preview2:"Route Name",
        search : $("#pop_search15").val() 
    }, function(r){
        $("#sr15").html(r);
        settings_route();            
    }, "text");
}

function settings_route(){
    $("#item_list .cl").click(function(){     
        $("#route_id").val($(this).children().eq(0).html());
        $("#route_des").val($(this).children().eq(1).html());
        $("#pop_close15").click();                
    })    
}


function load_salesman(){
  $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
            filter_emp_cat:"salesman",
            search : $("#pop_search13").val() 
        }, function(r){
            $("#sr13").html("");
            $("#sr13").html(r);
            settings_load_salesman();             
        }, "text");   
}

function settings_load_salesman(){
    $("#item_list .cl").click(function(){        
        $("#salesman_id").val($(this).children().eq(0).html());
        $("#salesman").val($(this).children().eq(1).html()); 
        $("#pop_close13").click();                
    })    
}

function load_col_off(){
  $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
            filter_emp_cat:"c_officer",
            search : $("#pop_search14").val() 
        }, function(r){
            $("#sr14").html("");
            $("#sr14").html(r);
            settings_load_col_off();             
        }, "text");   
}

function settings_load_col_off(){
    $("#item_list .cl").click(function(){        
        $("#col_officer_id").val($(this).children().eq(0).html());
        $("#col_officer").val($(this).children().eq(1).html()); 
        $("#pop_close14").click();                
    })    
}

function load_agreement(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"t_hp_sales_sum",
      field:"agr_serial_no",
      field2:"agreement_no",
      preview2:"Agreement No",
      search : $("#pop_search10").val() 
  }, function(r){
      $("#sr10").html(r);
      settings_agreement();     
 }, "text");
}

function settings_agreement(){
    $("#item_list .cl").click(function(){        
        $("#agreemnt_no").val($(this).children().eq(1).html());
        $("#pop_close10").click();                
    })    
}

function load_guarantor(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_guarantor",
      field:"code",
      field2:"name",
      preview2:"Name",
      search : $("#pop_search11").val() 
  }, function(r){
      $("#sr11").html(r);
      settings_guarantor();     
 }, "text");
}

function settings_guarantor(){
    $("#item_list .cl").click(function(){        
        $("#guarantor_id").val($(this).children().eq(0).html());
        $("#guarantor").val($(this).children().eq(1).html());
        $("#pop_close11").click();                
    })    
}