$(document).ready(function(){
    $("#tgrid1").tableScroll({height:300, width:1000});

    $("#id").keypress(function(e){
    if(e.keyCode == 13){
        $(this).blur();
        load_data($(this).val());
        $("#qno").val($('#id').val());
    }
  });

    $(".quns").click(function(){
      if($('#store_from_id').val()!=""){
             set_cid($(this).attr("id"));
      check_item_batch($('#5_'+scid).val(),$('#store_from_id').val());
      $("#serch_pop15").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search15').focus()", 100);  
    }else{
    set_msg("Please Select Stores")
  }
    });
   
    $("#btnDelete").click(function(){
        set_delete();
    });

    $("#btnResett").click(function(){
        location.href="";
    });

    $("#btnPrint").click(function(){
        $("#print_pdf").submit();
       
    });
    $("#root_id").keypress(function(e){
        if(e.keyCode == 112){
            $("#pop_search2").val($("#root_id").val());
            load_route();
            $("#serch_pop2").center();
            $("#blocker").css("display", "block");
            setTimeout("$('#pop_search2').focus()", 100);
        }
        $("#pop_search2").keyup(function(e){
            if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
                 load_route();
            }
        }); 
        if(e.keyCode == 46){
            $("#root_id").val("");
            $("#root_name").val("");
        }
    });  

    $("#store_from_id").keypress(function(e){ 
        if(e.keyCode==112){
          $("#pop_search10").val($("#store_from_id").val());
          load_from();
          $("#serch_pop10").center();
          $("#blocker10").css("display", "block");
          setTimeout("$('#pop_search10').focus()", 100);   
        }
        $("#pop_search10").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_from();
          }
        });
        if(e.keyCode==46){
           $("#store_from_id").val("");
           $("#store_from_name").val(""); 
        }  
  }); 

  load_def_sales(); 

  $("#store_to_id").keypress(function(e){ 
        if(e.keyCode==112){
          $("#pop_search11").val($("#store_to_id").val());
          load_to();
          $("#serch_pop11").center();
          $("#blocker11").css("display", "block");
          setTimeout("$('#pop_search11').focus()", 100);   
        }
        $("#pop_search11").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_to();
          }
        });
        if(e.keyCode==46){
           $("#store_to_id").val("");
           $("#store_to_name").val(""); 
        }  
  }); 

  $(".fo").keypress(function(e){ 
    set_cid($(this).attr("id"));
        if(e.keyCode==112){
         
          load_reason();
          $("#serch_pop12").center();
          $("#blocker").css("display", "block");
          setTimeout("$('#pop_search12').focus()", 100);   
        }
        $("#pop_search12").keyup(function(e){
          if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
            load_reason();
          }
        });
        if(e.keyCode==46){
           $("#7_"+scid).val("");
           $("#reason_"+scid).val(""); 
        }  
  }); 

  $(".chk").click(function(){
      chk_items();
     
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


$("#helper_id").keypress(function(e){
    if(e.keyCode==112){
      $("#pop_search13").val($("#helper_id").val());
      load_helper();
      $("#serch_pop13").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search13').focus()", 100);   
    }
    $("#pop_search13").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_helper();
      }
    });
    if(e.keyCode==46){
       $("#helper_id").val("");
       $("#helper_name").val("");
      }  
   });

});

function load_driver(){
  $.post("index.php/main/load_data/t_settu_loading/f1_load_driver", {
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

function load_helper(){
  $.post("index.php/main/load_data/utility/f1_selection_list_emp", {
            filter_emp_cat:"helper",
            search : $("#pop_search13").val() 
        }, function(r){
            $("#sr13").html("");
            $("#sr13").html(r);
            settings_helper();             
        }, "text");   
}

function settings_helper(){
    $("#item_list .cl").click(function(){        
        $("#helper_id").val($(this).children().eq(0).html());
        $("#helper_name").val($(this).children().eq(1).html()); 
        $("#pop_close13").click();                
    })    
}

function validate(){
var v=true;
var c=true;
for(var y=0; y<25; y++){
  if($("#n_"+y).val()!=""){
    if($("#check_"+y).is(":checked") && $("#reason_"+y).val()!=""){
      v=false;
    }
    if(!$("#check_"+y).is(":checked")&& $("#reason_"+y).val()==""){
      c=false;
    }
  }
}
//alert(c);

    if($("#store_from_id").val()==""){
       set_msg("Please Select Store From.");
        $("#store_from_id").focus();
        return false;
    }else if($("#store_to_id").val() == ""){
        set_msg("Please Select to Store.");
        $("#store_to_id").focus();
        return false;
    }else if(v==false){
        set_msg("Please Remove Select Item return Reason.");
        return false;
    }else if(c==false){
        set_msg("Please Select return Reason.");
        return false;
    }else if($("#driver_id").val()==""){
        set_msg("Please Select Driver.");
        return false;
    }else if($("#salesman_id").val()==""){
        set_msg("Please Select Salesman.");
        return false;
    }else{
        return true;
      }
    
}

function load_route(){
    $.post("index.php/main/load_data/t_settu_loading/load_route", {
        search : $("#pop_search2").val() 
    }, function(r){
        $("#sr2").html(r);
        settings_route();            
    }, "text");
}

function settings_route(){
    $("#item_list .cl").click(function(){        
        $("#root_id").val($(this).children().eq(0).html());
        $("#root_name").val($(this).children().eq(1).html()); 
        $("#pop_close2").click();                
    })    
}

function load_from(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_stores",
      field:"code",
      field2:"description",
      preview2:"Supplier Name",
      search : $("#pop_search10").val() 
  }, function(r){
      $("#sr10").html(r);
      settings_from();     
 }, "text");
}

function settings_from(){
    $("#item_list .cl").click(function(){        
        $("#store_from_id").val($(this).children().eq(0).html());
        $("#store_from_name").val($(this).children().eq(1).html());
        load_grid($("#seettu_no").val()); 
        $("#pop_close10").click();                
    })    
}

function load_to(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_stores",
      field:"code",
      field2:"description",
      preview2:"Supplier Name",
      search : $("#pop_search11").val() 
  }, function(r){
      $("#sr11").html(r);
      settings_to();     
 }, "text");
}

function settings_to(){
    $("#item_list .cl").click(function(){        
        $("#store_to_id").val($(this).children().eq(0).html());
        $("#store_to_name").val($(this).children().eq(1).html());
        $("#pop_close11").click();                
    })    
}

function load_reason(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"r_settu_reason",
      field:"code",
      field2:"description",
      preview2:"Reason",
      search : $("#pop_search12").val() 
  }, function(r){
      $("#sr12").html(r);
      settings_reason();     
 }, "text");
}

function settings_reason(){
    $("#item_list .cl").click(function(){        
        $("#reason_"+scid).val($(this).children().eq(0).html());
        $("#7_"+scid).val($(this).children().eq(1).html());
        $("#pop_close12").click();                
    })    
}

function load_grid(settu_no){
	$.post("index.php/main/load_data/t_settu_loading/load_grid", {
        settu_no : settu_no,

    }, function(r){
            if(r=="2"){
            set_msg("No records");
        }else{
         
			for(var x=0; x<r.det.length; x++){
	      $("#n_"+x).val(r.det[x].organizer);
        $("#org_"+x).val(r.det[x].org);
        $("#1_"+x).val(r.det[x].settu_no);
        $("#2_"+x).val(r.det[x].req_no);
        $("#3_"+x).val(r.det[x].req_date);
        $("#4_"+x).val(r.det[x].code);
        $("#refno_"+x).val(r.det[x].ref_code);
        $("#5_"+x).val(r.det[x].item);
        $("#6_"+x).val(r.det[x].name);                
        //$("#check_"+x).css("display","block");
        $("#btn_"+x).css("display","block");
        stock_check(r.det[x].item);
      }

      setTimeout('total_items()', 500);

        }
    }, "json");  
}

function stock_check(itemz){
  $.post("index.php/main/load_data/t_settu_loading/item_chk", {
      item:itemz,
      store:$("#store_from_id").val(),
      search : $("#pop_search15").val() 
    }, function(r){
      if(r=="2"){
        for(var x=0; x<25; x++){
          if($("#5_"+x).val()!=""){
          $("#btn_"+x).attr("disabled",true);
          $("#5_"+x).closest('td').css("background-color", "#FF6347");
        }
        }
      }
 }, "json");
}


function total_items(){
  var y=z=0;
  for(var x=0; x<25; x++){
    if($("#1_"+x).val()!=""){
      y++;
    }  
  }
  for(var a=0; a<25; a++){
    var settu1=$("#1_"+a).val();
    if(settu1!=""){
      var len=settu1.length;
    }
    for(var b=0; b<len; b++){
      var settu2=$("#1_"+(b+1)).val();
      if(settu1!=settu2 ){
          z++;
       
     }
     }
    
    }
  $("#no_of_items").val(y);
  $("#no_of_settu").val(z);
}

function chk_items(){
  v=0;
  for(var x=0; x<25; x++){
    if($("#check_"+x).is(":checked")){
      v++;
    }
  }
  $("#select_items").val(v);
}

function save(){
   $("#qno").val($('#id').val());
    var frm = $('#form_');
    loding();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (pid){   
            if(pid == 1){
                $("#btnSave").attr("disabled",true);
                if(confirm("Save Completed, Do You Want A print?")){
                    if($("#is_prnt").val()==1){
                        $("#print_pdf").submit();
                    }
                    reload_form();
                }else{
                    location.href="";
                }
                $("#btnSave").css("display","none");
                $("#btnSavee").css("display","inline");          
            }else if(pid == 2){
                set_msg("No permission to add data.");
            }else if(pid == 3){
                set_msg("No permission to edit data.");
            }else{
                set_msg(pid,"error");
            }
            loding();
        }
    });
}

function reload_form(){
  setTimeout(function(){
    location.href = '';
  },100); 
}

function load_data(id){
/*empty_grid();*/
loding();
var g=[];
$.post("index.php/main/get_data/t_settu_loading/", {
    no: id
}, function(r){
        if(r=="2"){
           set_msg("No records","error");
        }else{
          $("#hid").val(id);    
          $("#qno").val(id);    
          $("#id").attr("readonly","readonly")            
          $("#root_id").val(r.sum[0].root);
          $("#root_name").val(r.sum[0].root_name);
          $("#store_from_id").val(r.sum[0].store_from);
          $("#store_from_name").val(r.sum[0].store_from_name);
          $("#store_to_id").val(r.sum[0].store_to);
          $("#store_to_name").val(r.sum[0].store_to_name);
          $("#date").val(r.sum[0].ddate);
          $("#ref_no").val(r.sum[0].ref_no);
          $("#driver_id").val(r.sum[0].driver);
          $("#driver_name").val(r.sum[0].dri_name);
          $("#salesman_id").val(r.sum[0].salesman);
          $("#salesman_name").val(r.sum[0].salesman_name);
          $("#helper_id").val(r.sum[0].helper);
          $("#helper_name").val(r.sum[0].helper_name);

     for(var i=0; i<r.det.length; i++){

        $("#n_"+i).val(r.det[i].name);
        $("#org_"+i).val(r.det[i].organizer);
        $("#1_"+i).val(r.det[i].settu_no);
        $("#2_"+i).val(r.det[i].req_no);
        $("#3_"+i).val(r.det[i].req_date);
        $("#4_"+i).val(r.det[i].code);
        $("#refno_"+i).val(r.det[i].ref_code);
        $("#5_"+i).val(r.det[i].item);
        $("#6_"+i).val(r.det[i].des);
        $("#7_"+i).val(r.det[i].reason);
        $("#reason_"+i).val(r.det[i].ret_id);
        //$("#check_"+i).css("display","block");
        if((r.det[i].status)=="1"){  
        $("#check_"+i).attr("checked",true);
        setTimeout('total_items()', 500);
        chk_items();
    }
            if(r.sum[0].is_cancel==1){
                $("#btnDelete").attr("disabled", "disabled");
                $("#btnSave").attr("disabled", "disabled");
                $("#mframe").css("background-image", "url('img/cancel.png')");
            }

    }
  }
  
      loding();
    }, "json");
}

function set_delete(){
    var id = $("#hid").val();
    if(id != 0){
        if(confirm("Are you sure to delete this settu loading request no ["+$("#hid").val()+"]? ")){
            $.post("index.php/main/delete/t_settu_loading", {
            nno:id,
        },function(r){
          if(r != 1){
            set_msg(r);
          }else{
            delete_msg();
          }
        }, "text");
    }
  }else{
    set_msg("Please load record","error");
  }
}

function check_item_batch(item,store){
$.post("index.php/main/load_data/t_settu_loading/f1_batch_item", {
      items:item,
      stores:store,
      search : $("#pop_search15").val() 
    }, function(r){
      $("#sr15").html(""); 
      $('#sr15').html(r);
 }, "text");
}

$("#pop_close15").click(function(){
   x=0;
   var item_det="";
 $(".chkck").each(function(x){
  if($("#checki_"+x).is(":checked")){


  item_det+=($("#batch_"+x).html()+'-'+$("#code_"+x).html()+'-'+$("#qty_"+x).html()+'-'+$("#stqty_"+x).html()+',');
 
$("#itemdet_"+scid).val(item_det);
  }
 });
  
});


function load_def_sales(){
 $.post("index.php/main/load_data/t_settu_loading/load_sales_stores/", {
  }, function(r){
     //alert(r);
    if(r!=3){
      $("#store_to_id").val(r[0].def_sales_store_code);
      $("#store_to_name").val(r[0].description);
    }
    
  }, "json");
}

/*function settings_item_batch(){
    $("#pop_close12").click(function(){ 
    for(var x=0; x<25; x++){     
        $("#items_"+x).val($(this).children().eq(0).html());
        alert($(this).children().eq(2).html());
       
        }              
    })    
}*/