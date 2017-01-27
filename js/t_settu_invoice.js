$(document).ready(function(e){


$("#btnResett").click(function(){
    location.href="?action=t_settu_invoice";

 });

$("#btnCancel").click(function(){
  if($("#hid").val()!=0) {
    set_cancel($("#hid").val());
  }else{
     set_msg("Please Load Data");
        return false;
  }
  });
$("#btnDelete").click(function(){
           set_delete();   
    });

$("#btnseettu_vehicle").click(function(){

  window.open("?action=m_vehicle_setup","_blank");
    });



$("#seettu_vehicle").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search").val($("#seettu_vehicle").val());
      load_vehicle();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search').focus()", 100);   
    }
    $("#pop_search").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_vehicle();
      }
    });
    if(e.keyCode==46){
       $("#seettu_vehicle").val("");
       $("#seettu_vehicle_name").val("");
       $("#tbl_tbdy").html("");
      }  
   });

$("#driver_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search2").val($("#driver_id").val());
      load_driver();
      $("#serch_pop2").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search2').focus()", 100);   
    }
    $("#pop_search2").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_driver();
      }
    });
    if(e.keyCode==46){
       $("#driver_id").val("");
       $("#driver_name").val("");
      }  
   });

$("#salesman_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search10").val($("#salesman_id").val());
      load_salesman();
      $("#serch_pop10").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search10').focus()", 100);   
    }
    $("#pop_search10").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_salesman();
      }
    });
    if(e.keyCode==46){
       $("#salesman_id").val("");
       $("#salesman_name").val("");
      }  
   });

$("#c_officer_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search11").val($("#c_officer_id").val());
      load_c_off();
      $("#serch_pop11").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search11').focus()", 100);   
    }
    $("#pop_search11").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_c_off();
      }
    });
    if(e.keyCode==46){
       $("#c_officer_id").val("");
       $("#c_officer").val("");
      }  
   });

$("#route_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search12").val($("#route_id").val());
      load_route();
      $("#serch_pop12").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search12').focus()", 100);   
    }
    $("#pop_search12").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_route();
      }
    });
    if(e.keyCode==46){
       $("#route_id").val("");
       $("#route_name").val("");
      }  
   });



$("#seettu_no").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search13").val($("#seettu_no").val());
      load_seettu_no();
      $("#serch_pop13").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search13').focus()", 100);   
    }
    $("#pop_search13").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_seettu_no();
      }
    });
    if(e.keyCode==46){
       $("#seettu_no").val("");
       $("#organizer").val("");
       $("#organizer_name").val("");
      }  
   });


$("#seettu_item").keypress(function(e){
  if($("#seettu_no").val()==""){
        set_msg("Please Enter Seettu No");
        return false;
    }else{
    if(e.keyCode==112){
      $("#pop_search14").val($("#seettu_item").val());
      load_item();
      $("#serch_pop14").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search14').focus()", 100);   
    }
  }
    $("#pop_search14").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_item();
      }
    });
    if(e.keyCode==46){
       $("#seettu_item").val("");
       $("#item_name").val("");
       $("#price").val("");
       $("#amount").val("");
      }  
   });

$("#id_no").keypress(function(e){
        if(e.keyCode == 13){
            $(this).blur();
            load_data($(this).val());
            $(this).attr("readonly","readonly");
            
        }
    });



});



function load_vehicle(){
  $.post("index.php/main/load_data/t_settu_invoice/f1_load_vehicle", {
      search : $("#pop_search").val(),
    }, function(r){
        $("#sr").html(r);
        settings_vehicle();   
    }, "text");
}

function settings_vehicle(){
    $("#item_list .cl").click(function(){        
        $("#seettu_vehicle").val($(this).children().eq(0).html());
        $("#seettu_vehicle_name").val($(this).children().eq(1).html()); 
        $("#driver_id").val($(this).children().eq(2).html());
        $("#driver_name").val($(this).children().eq(3).html()); 
        load_grid();
        $("#pop_close").click();                
    })    
}

function load_driver(){
  $.post("index.php/main/load_data/t_settu_invoice/f1_load_driver", {
      search : $("#pop_search2").val(),
    }, function(r){
        $("#sr2").html(r);
        settings_load_driver();   
    }, "text");
}

function settings_load_driver(){
    $("#item_list .cl").click(function(){        
        $("#driver_id").val($(this).children().eq(0).html());
        $("#driver_name").val($(this).children().eq(1).html()); 
        $("#pop_close2").click();                
    })    
}

function load_salesman(){
  $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
            filter_emp_cat:"salesman",
            search : $("#pop_search10").val() 
        }, function(r){
            $("#sr10").html("");
            $("#sr10").html(r);
            settings_load_salesman();             
        }, "text");   
}

function settings_load_salesman(){
    $("#item_list .cl").click(function(){        
        $("#salesman_id").val($(this).children().eq(0).html());
        $("#salesman_name").val($(this).children().eq(1).html()); 
        $("#pop_close10").click();                
    })    
}

function load_c_off(){
  $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
            filter_emp_cat:"c_officer",
            search : $("#pop_search11").val() 
        }, function(r){
            $("#sr11").html("");
            $("#sr11").html(r);
            settings_load_c_off();             
        }, "text");   
}

function settings_load_c_off(){
    $("#item_list .cl").click(function(){        
        $("#c_officer_id").val($(this).children().eq(0).html());
        $("#c_officer").val($(this).children().eq(1).html()); 
        $("#pop_close11").click();                
    })    
}

function load_route(){
  $.post("index.php/main/load_data/t_settu_invoice/f1_load_route", {
      search : $("#pop_search12").val(),
    }, function(r){
        $("#sr12").html(r);
        settings_load_route();   
    }, "text");
}

function settings_load_route(){
    $("#item_list .cl").click(function(){        
        $("#route_id").val($(this).children().eq(0).html());
        $("#route_name").val($(this).children().eq(1).html()); 
        $("#pop_close12").click();                
    })    
}

function load_seettu_no(){
  $.post("index.php/main/load_data/t_settu_invoice/f1_seettu_no", {
      search : $("#pop_search13").val(),
    }, function(r){
        $("#sr13").html(r);
        settings_seettu_no();   
    }, "text");
}

function settings_seettu_no(){
    $("#item_list .cl").click(function(){        
        $("#seettu_no").val($(this).children().eq(0).html());
        $("#organizer").val($(this).children().eq(1).html());
        $("#organizer_name").val($(this).children().eq(2).html());
        $("#book_no").val($(this).children().eq(3).html());
        $("#pop_close13").click();                
    })    
}


function load_item(){
  $.post("index.php/main/load_data/t_settu_invoice/f1_seettu_item", {
      search : $("#pop_search14").val(),
      seettu_no:$("#seettu_no").val(),
    }, function(r){
        $("#sr14").html(r);
        settings_seettu_item();   
    }, "text");
}

function settings_seettu_item(){
    $("#item_list .cl").click(function(){        
        $("#seettu_item").val($(this).children().eq(0).html());
        $("#item_name").val($(this).children().eq(1).html()); 
        $("#price").val($(this).children().eq(2).html()); 
        $("#amount").val($(this).children().eq(3).html());
        $("#no_of_ins").val($(this).children().eq(4).html()); 
        $("#pop_close14").click();                
    })    
}

function load_details(){
  $.post("index.php/main/load_data/t_settu_invoice/load_details", {
    }, 
    function(r){
                   
        $("#seettu_vehicle").val(r.vehicle_no);
        $("#seettu_vehicle_name").val(r.vehicle);
        $("#driver_id").val(r.driver);
        $("#driver_name").val(r.dri_name);
        $("#salesman_id").val(r.salesman);
        $("#salesman_name").val(r.salesmn);
        $("#route_id").val(r.route);
        $("#route_name").val(r.route);
        load_grid();
    }, "json");
}


function validate() {
    if($("#seettu_vehicle").val()==""){
        set_msg("Please Select Vehicle");
        return false;
    }
    if($("#driver_id").val()==""){
        set_msg("Please Select Driver");
        return false;
    }
    if($("#salesman_id").val()==""){
        set_msg("Please Select Salesman");
        return false;
    }
    if($("#route_id").val()==""){
        set_msg("Please Select Route");
        return false;
    }
    else if($("#seettu_no").val()==""){
        set_msg("Please Enter Seettu No");
        return false;
    }
    else if($("#organizer").val()==""){
        set_msg("Please Select Organizer");
        return false;
    }
    
    else if($("#seettu_item").val()==""){
        set_msg("Please Select Item");
        return false;
    }
    else if($("#price").val()==""){
        set_msg("Please Enter Price");
        return false;
    }
    else if($("#amount").val()==""){
        set_msg("Please Enter Amount");
        return false;
    }
    else if($("#additional").val()==""){
        set_msg("Please Enter Additional Paid");
        return false;
    }
    else if($("#paid").val()==""){
        set_msg("Please Enter Paid Amount");
        return false;
    }
    else if($("#card_no").val()==""){
        set_msg("Please Enter Card No");
        return false;
    }
    else if($("#reciept_no").val()==""){
        set_msg("Please Enter Reciept No");
        return false;
    }
    else if($("#c_officer_id").val()==""){
        set_msg("Please Enter Collection Officer");
        return false;
    }
    else{
      return true;
    }
  }

function save(){
        var frm = $('#form_');
        loding();
        $.ajax({
      type: frm.attr('method'),
      url: frm.attr('action'),
      data: frm.serialize(),
      success: function (pid){
                if(pid == 1){               
                    $("#btnSave").attr("disabled",true);
                    loding();
                      /*reload_form();*/
                      reset_det();
                      load_details();
                }else if(pid == 2){
                    set_msg("No permission to add data.");
                }else if(pid == 3){
                    set_msg("No permission to edit data.");
                }else{
                     loding();
                    set_msg(pid);
                }
                            
            }
        });
    }


function reset_det(){

       $("#seettu_no").val("");
       $("#book_no").val("");
       $("#organizer").val("");
       $("#organizer_name").val("");
       $("#seettu_item").val("");
       $("#item_name").val("");
       $("#price").val("");
       $("#amount").val("");
       $("#paid").val("");
       $("#additional").val("");
       $("#ref_no").val("");
       $("#card_no").val("");
       $("#reciept_no").val("");
       $("#note").val("");
       $("#c_officer_id").val("");
       $("#c_officer").val("");
       $("#id_no").val(parseInt($("#id_no").val())+1);
       

}

function load_data(id){  
    loding();
    $.post("index.php/main/get_data/t_settu_invoice/", {
        id: id,

    }, function(r){

        if(r=="2"){
            set_msg("No records");
        }else{
            
            $("#hid").val(id); 
            $("#id_no").val(id); 
            $("#date").val(r.seettu[0].ddate);
            $("#ref_no").val(r.seettu[0].ref_no);
            $("#card_no").val(r.seettu[0].card_no);
            $("#reciept_no").val(r.seettu[0].reciept_no);
            $("#seettu_vehicle").val(r.seettu[0].vehicle_no);
            $("#seettu_vehicle_name").val(r.seettu[0].vehicle);
            $("#driver_id").val(r.seettu[0].driver); 
            $("#driver_name").val(r.seettu[0].dri_name); 
            $("#salesman_id").val(r.seettu[0].salesman); 
            $("#salesman_name").val(r.seettu[0].salesman_name); 
            $("#route_id").val(r.seettu[0].route); 
            $("#route_name").val(r.seettu[0].route_name);  
            $("#c_officer_id").val(r.seettu[0].c_officer); 
            $("#c_officer").val(r.seettu[0].c_officer_name);  
            $("#note").val(r.seettu[0].note); 
            $("#seettu_no").val(r.seettu[0].seettu_no); 
            $("#organizer").val(r.seettu[0].organizer_no); 
            $("#organizer_name").val(r.seettu[0].name);
            $("#book_no").val(r.seettu[0].book_no);
            $("#seettu_item").val(r.seettu[0].item);
            $("#item_name").val(r.seettu[0].item_name); 
            $("#price").val(r.seettu[0].price); 
            $("#amount").val(r.seettu[0].amount); 
            $("#additional").val(r.seettu[0].addit_charge); 
            $("#paid").val(r.seettu[0].paid);
            load_grid();

              if(r.seettu[0].is_cancel==1){
                $("#r_group_sb").css("background-image","url('img/cancel.png')")
                $("#btnSave").attr("disabled","disabled")
                $("#btnDelete").attr("disabled","disabled")
                $("#btnCancel").attr("disabled","disabled")
              }

        }
        loding();
    }, "json");  

}

function load_grid(){ 

    loding();
    $.post("index.php/main/load_data/t_settu_invoice/load_grid", {
        ddate:$("#date").val(),
        seettu_vehicle:$("#seettu_vehicle").val(),

    }, function(r){

        if(r=="2"){
            set_msg("No records");
        }else{

        var tbl="";
            for(var x=0; x<r.det.length; x++){
             
                tbl+="<tr>";
                tbl+="<td>";
                tbl+="<input type='hidden' title='0' />";
                tbl+="<input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:left;' value='"+r.det[x].seettu_no+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:left;' readonly='readonly'value='"+r.det[x].organizer_no+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:left;' readonly='readonly'value='"+r.det[x].no_of_ins+"'/></td>";
                tbl+="<td><input type='text' class='input_txt g_col_fixed' style='width : 100%;text-align:left;' readonly='readonly'value='"+r.det[x].item_name+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:right;' readonly='readonly' value='"+r.det[x].price+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:right;' readonly='readonly'value='"+r.det[x].installement+"'/></td>";                                   
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:right;' readonly='readonly' value='"+r.det[x].addit_charge+"'/></td>";
                tbl+="<td><input type='text' class='g_input_amo amount g_col_fixed' style='width : 100%;text-align:right;' readonly='readonly' value='"+r.det[x].paid+"'/></td>";
                if(r.det[x].is_cancel=='1'){
                tbl+="<td style='text-align:center;'> <img src='img/no.png' style='width:15px;height:15px;margin-left:15px;'/></td>";
                }else{
                tbl+="<td style='text-align:center;'><img src='img/tick.png' style='width:15px;height:15px;margin-left:15px;'/></td>";
                }
                tbl+="</tr>";

                
            }

            $("#tbl_tbdy").append(tbl);

        }
        loding();
    }, "json");  

}


function set_cancel(id){
    if(confirm("Are you sure cancel "+id+"?")){
        loding();
        $.post("index.php/main/load_data/t_settu_invoice/cancel", {
            id : id
        }, function(res){
            if(res == 1){
                loding();
                delete_msg();
            }else if(res == 2){
                set_msg("No permission to delete data.");
            }else{
                set_msg(res);
            }
        }, "text");
    }
}

 function set_delete(){
       var id=$("#hid").val();
        if(id=="0"){
            set_msg("Please Load Data");
        return false;
        }else{      
        var id=$("#hid").val();
    if(confirm("Are you sure delete "+id+"?")){
        loding();
        $.post("index.php/main/delete/t_settu_invoice", {
            id : id
        }, function(res){
            if(res == 1){
                loding();
                delete_msg();
            }else if(res == 2){
                set_msg("No permission to delete data.");
            }else{
                set_msg(res);
            }
        }, "text");
    }
}
}