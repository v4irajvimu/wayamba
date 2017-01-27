var sub_items=[];
var is_cancel;

$(document).ready(function(){
  $("#tgrid").tableScroll({height:200, width:1025});
  $("#tgrid1").tableScroll({height:200, width:1025});
  $("#btnApprove").attr("disabled", "disabled");

  $("#agr_no").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search").val($("#agr_no").val());
      load_agr();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search').focus()", 100);
    }
    $("#pop_search").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_agr();
      }
    }); 
    if(e.keyCode == 46){
      $("#agr_no").val("");
      $("#f_store_code").val("");
      $("#f_store_des").val("");
      $("#cus_id").val("");
      $("#cus_name").val("");
      $("#hp_no").val("");
      empty_grid();
    }
  });

  $("#dr_acc").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search12").val($("#dr_acc").val());
      load_acc();
      $("#serch_pop12").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search12').focus()", 100);
    }
    $("#pop_search12").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_acc();
      }
    }); 
    if(e.keyCode == 46){
      $("#dr_acc").val("");
      $("#acc_des").val("");
    }
  });

  $("#to_store").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search14").val($("#to_store").val());
      load_stores();
      $("#serch_pop14").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search14').focus()", 100);
    }
    $("#pop_search14").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_stores();
      }
    }); 
    if(e.keyCode == 46){
      $("#to_store").val("");
      $("#t_store_des").val("");
    }
  });

  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#sqty_"+get_id).focus();
  });

  $(".qty").blur(function() {
    total_calc();
  });

  $("#btnPrint").click(function() {
    $("#print_pdf").submit();
  });

  $("#btnDelete5").click(function(){
    set_delete();
  });

  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
    }
  });

  $("#btnApprove").click(function(){
    $("#is_approve").val("1");

    if(validate()){
      save();    
    }
  });

  $(".cl1").dblclick(function() {
    settings_down_grid(this);
  });

  $(".fo").keypress(function(e) {
    set_cid($(this).attr("id"));
    if(e.keyCode==46){
      delete_row(scid);
    }
  });

});

function load_agr(){
  $.post("index.php/main/load_data/t_hp_seized_main_store/load_agr", {
    search : $("#pop_search").val() 
  }, function(r){
    $("#sr").html(r);
    settings_agr();            
  }, "text");
}

function settings_agr(){
  $("#item_list .cl").click(function(){        
    $("#agr_no").val($(this).children().eq(0).html());
    $("#f_store_code").val($(this).children().eq(5).html());
    $("#f_store_des").val($(this).children().eq(6).html());
    $("#cus_id").val($(this).children().eq(3).html());
    $("#cus_name").val($(this).children().eq(4).html());
    $("#hp_no").val($(this).children().eq(2).html());
    load_seize_items($(this).children().eq(0).html());
    $("#pop_close").click();                
  })    
}

function load_acc(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_account",
    field:"code",
    field2:"description",
    preview2:"Account Description",
    search : $("#pop_search12").val() 
  }, function(r){
    $("#sr12").html(r);
    settings_acc();      
  }, "text");
}

function settings_acc(){
  $("#item_list .cl").click(function(){        
    $("#dr_acc").val($(this).children().eq(0).html());
    $("#acc_des").val($(this).children().eq(1).html());
    $("#pop_close12").click();                
  })    
}


function load_stores(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_stores",
    field:"code",
    field2:"description",
    preview2:"Description",
    add_query:" AND cl='"+$('#cl').val()+"' AND bc='"+$('#bc').val()+"' AND transfer_location='0' ",
    search : $("#pop_search14").val() 
  }, function(r){
    $("#sr14").html(r);
    settings_stores();      
  }, "text");
}

function settings_stores(){
  $("#item_list .cl").click(function(){        
    $("#to_store").val($(this).children().eq(0).html());
    $("#t_store_des").val($(this).children().eq(1).html());
    $("#pop_close14").click();                
  })    
}





function load_seize_items(agr_no){
  $.post("index.php/main/load_data/t_hp_seized_main_store/load_items", {
    agr_no : agr_no 
  }, function(r){
    if(r!=2){
      empty_grid();
      $("#agr_amount").val(m_round(r.sum[0].net_amount));
      $("#ar_amount").val(m_round(r.sum[0].arr));
      $("#paid_amount").val(m_round(r.sum[0].paid));
      for(var x=0; x<r.det.length; x++){
        $("#sno_"+x).val(r.det[x].nno);
        $("#icode_"+x).val(r.det[x].item_code);
        $("#iname_"+x).val(r.det[x].item_des);
        $("#cost_"+x).val(r.det[x].purchase_price);
        $("#lprice_"+x).val(r.det[x].min_price);
        $("#mprice_"+x).val(r.det[x].max_price);
        $("#btt_"+x).val(r.det[x].batch_no);
        $("#qty_"+x).val(r.det[x].qty);
      }         
    }else{
      set_msg("No pending items");
    }
  }, "json");
}

function empty_grid(){
  for(var x=0; x<25; x++){
    $("#sno_"+x).val("");
    $("#icode_"+x).val("");
    $("#iname_"+x).val("");
    $("#cost_"+x).val("");
    $("#lprice_"+x).val("");
    $("#mprice_"+x).val("");
    $("#btt_"+x).val("");
    $("#qty_"+x).val("");

    $("#0_"+x).val("");
    $("#siname_"+x).val("");
    $("#bt_"+x).val("");
    $("#sqty_"+x).val("");
    $("#scost_"+x).val("");
    $("#slprice_"+x).val("");
    $("#smprice_"+x).val("");
    $("#maxqty_"+x).val("");
    $("#bt1_"+x).val("");
    $("#samount_"+x).val("");
    $("#btn_"+x).css("display","none");
  }
  total_calc();    
}

function settings_down_grid(row){
  var seize_no=$(row).children().eq(0).find('input').val();
  var item=$(row).children().eq(1).find('input').val();
  var item_des=$(row).children().eq(2).find('input').val();
  var qty=$(row).children().eq(3).find('input').val();
  var cost=$(row).children().eq(4).find('input').val();
  var min=$(row).children().eq(5).find('input').val();
  var max=$(row).children().eq(6).find('input').val();
  var batch=$(row).children().eq(7).find('input').val();
  
  $("#seize_no").val(seize_no);

  for(var i=0; i<25 ;i++){          
    if(item == "0" || item ==""){
    }else{
     if($("#0_"+i).val()==item){
      return false;
    }else if($("#0_"+i).val()==""){ 
      check_is_serial_item2(item,i);
      $("#0_"+i).val(item);
      $("#siname_"+i).val(item_des);
      $("#bt_"+i).val(batch);
      $("#sqty_"+i).val(qty);
      $("#scost_"+i).val(cost);
      $("#slprice_"+i).val(min);
      $("#smprice_"+i).val(max);
      $("#maxqty_"+i).val(max);
      $("#bt1_"+i).val(batch);
      total_calc();
      break;    
    }
  }
}
}

function delete_row(row_id){
  $("#0_"+row_id).val("");
  $("#siname_"+row_id).val("");
  $("#bt_"+row_id).val("");
  $("#sqty_"+row_id).val("");
  $("#scost_"+row_id).val("");
  $("#slprice_"+row_id).val("");
  $("#smprice_"+row_id).val("");
  $("#maxqty_"+row_id).val("");
}

function total_calc(){
  var tot = parseFloat(0);
  for(var x=0; x<25; x++){
    if($("#0_"+x).val()!="" && $("#sqty_"+x).val()>0){
      var qty = parseFloat($("#sqty_"+x).val());
      var prc = parseFloat($("#smprice_"+x).val());
      var amt = parseFloat(0);

      if(isNaN(qty)){qty=0}
      if(isNaN(prc)){prc=0}
      if(isNaN(amt)){amt=0}

      amt = qty*prc;

      $("#samount_"+x).val(m_round(amt));
      tot += amt;
    }
  }
  $("#gross_amount").val(m_round(tot));
}


function validate(){
  if($("#agr_no").val() == "" ){
    set_msg("Please select agreement no.","error");
    $("#agr_no").focus();
    return false;
  }else if($("#f_store_code").val() == ""){
    set_msg("Please select from store.","error");
    $("#f_store_code").focus();
    return false;
  }else if($("#to_store").val() == ""){
    set_msg("Please select to store.","error");
    $("#to_store").focus();
    return false;
  }else if($("#cus_id").val() == ""){
    set_msg("Please select customer.","error");
    $("#cus_id").focus();
    return false;
  }else if($("#dr_acc").val() == "") {
    set_msg("Please select DR account.","error");
    $("#dr_acc").focus();
    return false;
  }else if($("#gross_amount").val() == "0") {
    set_msg("Net amount cann't be zero","error");
    $("#gross_amount").focus();
    return false;
  }else{
    return true;
  } 
}

function save(){
  if($("#df_is_serial").val()=='1'){
    serial_items.sort();
    $("#srls").attr("title",serial_items);
    $("#srls").val(serial_items);
  }
  $("#is_duplicate").val("1");
  $("#qno").val($("#id").val());
  var frm = $('#form_');
  loding();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: frm.serialize(),
    success: function (pid){
      loding();
      var sid=pid.split('@');
      if(sid[0]==1){
        $("#btnSave").attr("disabled",true);
        if(confirm("Save Completed, Do You Want A print?")){
          if($("#is_prnt").val()==1){
            $("#print_pdf").submit();
          }
          reload_form();
        }else{
          location.href="";
        }
      }else{
        set_msg(pid,'error');
      }
    }
  });
}

function reload_form(){
  setTimeout(function(){
  location.href = '';
  },100); 
}

function load_data(id){
  var g=[];
  empty_grid();
  loding();
  $.post("index.php/main/get_data/t_hp_seized_main_store/", {
    id: id
  }, function(r){
    loding();  
    if(r=="2"){
     set_msg("No records");
    }else{
      $("#hid").val(id);   
      $("#id").val(id);
      $("#qno").val(id);
      $("#id").attr("readonly",true); 
      $("#date").val(r.sum[0].ddate);
      $("#ref_no").val(r.sum[0].ref_no);
      $("#agr_no").val(r.sum[0].agr_no);
      $("#hp_no").val(r.sum[0].hp_no);
      $("#f_store_code").val(r.sum[0].from_store);
      $("#f_store_des").val(r.sum[0].f_store_des);
      $("#to_store").val(r.sum[0].to_store);
      $("#t_store_des").val(r.sum[0].t_store_des);
      $("#agr_amount").val(r.sum[0].hp_amount);
      $("#ar_amount").val(r.sum[0].arr_amount);
      $("#paid_amount").val(r.sum[0].paid_amount);
      $("#cus_id").val(r.sum[0].customer);
      $("#cus_name").val(r.sum[0].cus_name);
      $("#dr_acc").val(r.sum[0].dr_acc);
      $("#acc_des").val(r.sum[0].acc_des);
      $("#cn_no").val(r.sum[0].crn_no);
      $("#amt").val(r.sum[0].crn_amount);
      $("#seize_no").val(r.sum[0].seize_no);
      

      for(var i=0; i<r.det.length;i++){
        $("#itemcode_"+i).val(r.det[i].code);
        if($("#df_is_serial").val()=='1'){
          check_is_serial_item2(r.det[i].code,i);
          $("#numofserial_"+i).val(r.det[i].qty);
          for(var a=0;a<r.serial.length;a++){
            if(r.det[i].code==r.serial[a].item){
              g.push(r.serial[a].serial_no);
              $("#all_serial_"+i).val(g);
            }   
          }
          g=[];                 
        }

        $("#0_"+i).val(r.det[i].code);
        $("#siname_"+i).val(r.det[i].description);
        $("#bt1_"+i).val(r.det[i].batch_no);
        $("#sqty_"+i).val(r.det[i].qty);
        $("#scost_"+i).val(r.det[i].cost);
        $("#slprice_"+i).val(r.det[i].min);
        $("#smprice_"+i).val(r.det[i].max);
      }
      $("#btnApprove").attr("disabled", false);
      if(r.sum[0].is_approve==1){
        $("#btnDelete5").attr("disabled", "disabled");
        $("#btnSave").attr("disabled", "disabled");
        $("#btnApprove").attr("disabled", "disabled");
        $("#mframe").css("background-image", "url('img/approved1.png')");
      }  

      if(r.sum[0].is_cancel==1){
        $("#btnApprove").attr("disabled", "disabled");
        $("#btnDelete5").attr("disabled", "disabled");
        $("#btnSave").attr("disabled", "disabled");
        $("#mframe").css("background-image", "url('img/cancel.png')");
      }
      total_calc();
    }
  }, "json");
}

function set_delete(){
  var id = $("#hid").val();
  if(id != 0){
    if(confirm("Are you sure to delete this record ["+$("#id").val()+"]? ")){
      $.post("index.php/main/delete/t_hp_seized_main_store", {
        trans_no:id,
      },function(r){
        if(r != 1){
          set_msg(r);
        }else{
          delete_msg();
        }
      }, "text");
    }
  }else{
    set_msg("Please load record");
  }
}