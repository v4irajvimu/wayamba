$(document).ready(function () {


$("#btnExit").click(function(){
        return false;
    });

$("#btnprint").click(function(){
        if($("#by").val()=="" ){
            set_msg("Please select report","error");
            return false;
        }else{
           $("#print_pdf").submit(); 
        }
    });    


$("#cluster").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search").val($("#cluster").val());
      load_cluster();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search').focus()", 100);   
    }
    $("#pop_search").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_cluster();
      }
    });
    if(e.keyCode==46){
       $("#cluster").val("");
       $("#cluster_id").val("");
      }  
   });

$("#branch_id").keypress(function(e){
    if(e.keyCode==112){
      $("#serch_pop2").val($("#branch_id").val());
      load_branch();
      $("#serch_pop2").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#serch_pop2').focus()", 100);   
    }
    $("#serch_pop2").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_branch();
      }
    });
    if(e.keyCode==46){
       $("#branch_id").val("");
       $("#branch").val("");
      }  
   });

$("#cus_id").keypress(function(e){
    if(e.keyCode==112){
      $("#serch_pop10").val($("#cus_id").val());
      load_customer();
      $("#serch_pop10").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#serch_pop10').focus()", 100);   
    }
    $("#serch_pop10").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_customer();
      }
    });
    if(e.keyCode==46){
       $("#cus_id").val("");
       $("#customer").val("");
      }  
   });

$("#salesman_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search11").val($("#salesman_id").val());
      load_salesman();
      $("#serch_pop11").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search11').focus()", 100);   
    }
    $("#pop_search11").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
       load_salesman();
      }
    });
    if(e.keyCode==46){
       $("#salesman_id").val("");
       $("#salesman").val("");
      }  
   });

$("#c_officer_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search12").val($("#c_officer_id").val());
      load_c_officer();
      $("#serch_pop12").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search12').focus()", 100);   
    }
    $("#pop_search12").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
       load_c_officer();
      }
    });
    if(e.keyCode==46){
       $("#c_officer_id").val("");
       $("#c_officer").val("");
      }  
   });

$("#route_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search13").val($("#route_id").val());
      load_root();
      $("#serch_pop13").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search13').focus()", 100);   
    }
    $("#pop_search13").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
       load_root();
      }
    });
    if(e.keyCode==46){
       $("#route_id").val("");
       $("#root").val("");
      }  
   });

$("#vehicle_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search14").val($("#vehicle_id").val());
      load_vehicle();
      $("#serch_pop14").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search14').focus()", 100);   
    }
    $("#pop_search14").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_vehicle();
      }
    });
    if(e.keyCode==46){
       $("#vehicle_id").val("");
       $("#vehicle").val("");
      }  
   });





$("#seettu_no").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search15").val($("#seettu_no").val());
      load_seettu();
      $("#serch_pop15").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search15').focus()", 100);   
    }
    $("#pop_search15").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_seettu();
      }
    });
    if(e.keyCode==46){
       $("#seettu_no").val("");
       $("#seettu").val("");
      }  
   });


 $("#seettu_inv").click(function(){
        $("#by").val("r_seettu_invoice");
        $("#type").val("r_seettu_invoice");
        /*$("#vehi").val($("#vehicle_id").val());*/

    });


});


function load_cluster(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_cluster",
        field:"code",
        field2:"description",
        preview2:"Name",
        search : $("#pop_search").val() 
    }, function(r){
        $("#sr").html(r);
        settings_cluster();            
    }, "text");
}

function settings_cluster(){
    $("#item_list .cl").click(function(){        
        $("#cluster").val($(this).children().eq(0).html());
        $("#cluster_id").val($(this).children().eq(1).html());
        $("#pop_close").click();                
    })    
}

function load_branch(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_branch",
        field:"bc",
        field2:"name",
        preview2:"Name",
        search : $("#serch_pop2").val() 
    }, function(r){
        $("#sr2").html(r);
        settings_branch();            
    }, "text");
}

function settings_branch(){
    $("#item_list .cl").click(function(){        
        $("#branch_id").val($(this).children().eq(0).html());
        $("#branch").val($(this).children().eq(1).html());
        $("#pop_close2").click();                
    })    
}

function load_customer(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_customer",
        field:"code",
        field2:"name",
        preview2:"Name",
        search : $("#serch_pop10").val() 
    }, function(r){
        $("#sr10").html(r);
        settings_customer();            
    }, "text");
}

function settings_customer(){
    $("#item_list .cl").click(function(){        
        $("#cus_id").val($(this).children().eq(0).html());
        $("#customer").val($(this).children().eq(1).html());
        $("#pop_close10").click();                
    })    
}


function load_vehicle(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"m_vehicle_setup",
        field:"code",
        field2:"description",
        preview2:"Name",
        search : $("#pop_search14").val() 
    }, function(r){
        $("#sr14").html(r);
        settings_vehicle();            
    }, "text");
}

function settings_vehicle(){
    $("#item_list .cl").click(function(){        
        $("#vehicle_id").val($(this).children().eq(0).html());
        $("#vehicle").val($(this).children().eq(1).html());
        $("#pop_close14").click();                
    })    
}

function load_salesman(){
    $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
        filter_emp_cat:"salesman",
        search : $("#pop_search11").val() 
    }, function(r){
        $("#sr11").html(r);
        settings_salesman();            
    }, "text");
}

function settings_salesman(){
    $("#item_list .cl").click(function(){        
        $("#salesman_id").val($(this).children().eq(0).html());
        $("#salesman").val($(this).children().eq(1).html());
        $("#pop_close11").click();                
    })    
}

function load_c_officer(){
    $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
        filter_emp_cat:"c_officer",
        search : $("#pop_search12").val() 
    }, function(r){
        $("#sr12").html(r);
        settings_c_officer();            
    }, "text");
}

function  settings_c_officer(){
    $("#item_list .cl").click(function(){        
        $("#c_officer_id").val($(this).children().eq(0).html());
        $("#c_officer").val($(this).children().eq(1).html());
        $("#pop_close12").click();                
    })    
}

function load_root(){
    $.post("index.php/main/load_data/utility/f1_selection_list", {
        data_tbl:"r_root",
        field:"code",
        field2:"description",
        preview2:"Name",
        search : $("#serch_pop13").val() 
    }, function(r){
        $("#sr13").html(r);
        settings_root();            
    }, "text");
}

function settings_root(){
    $("#item_list .cl").click(function(){     
        $("#route_id").val($(this).children().eq(0).html());
        $("#route").val($(this).children().eq(1).html());
        $("#pop_close13").click();                
    })    
}

function load_seettu(){
    $.post("index.php/main/load_data/r_transaction_settu/f1_selection_list", {
        search : $("#pop_search15").val() 
    }, function(r){
        $("#sr15").html(r);
        settings_seettu();            
    }, "text");
}

function settings_seettu(){
    $("#item_list .cl").click(function(){        
        $("#seettu_no").val($(this).children().eq(0).html());
        $("#seettu").val($(this).children().eq(1).html());
        $("#pop_close15").click();                
    })    
}
