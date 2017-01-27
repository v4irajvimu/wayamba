$(document).ready(function(){

  $(".quns").css("display", "none");
  $("#btnSave").attr("disabled","disabled");

  $("#tgrid").tableScroll({height:200});

  $("#showPayments").click(function(){
    payment_opt('t_hp_rivert_item',$("#net").val());
    if($("#hid").val()=="0" && $("#cheque_recieve").val()=="" && $("#credit_card").val()==""){
      $("#cash").val($("#net").val());        
    }
  });  
  $(".qty").keyup(function() {
   cal_qty();
 });

  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#tqty_"+get_id).focus();
  });

  $("#agr_no").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search13").val();
      load_aggreement();
      $("#serch_pop13").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search13').focus()", 100);   

    }
    if(e.keyCode == 46){
      $("#agr_no").val("");
      $("#customer").val("");
      $("#cus_name").val("");
      $("#cus_address").val("");
      $("#nno").val("");
      $("#nno").val("");
      $("#rf_no").val("");
      $("#dt_date").val("");
    }
  });
  $("#pop_search13").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ){ 
      load_aggreement();
    }
  });

  $("#return_person").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search").val();
      return_person();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search13').focus()", 100);   
    }
    if(e.keyCode== 46){
      $("#return_person").val("");
      $("#retur_persondes").val("");
    }
  });

  $("#pop_search").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { 
     return_person();
   }
 });

  $("#s_code").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search2").val();
      load_salesman();
      $("#serch_pop2").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search2').focus()", 100);   
    }
    if(e.keyCode== 46){
      $("#s_code").val("");
      $("#salesman_name").val("");
    }
  });

  $("#pop_search2").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { 
      load_salesman();

    }
  });
  $("#from_store").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search6").val();
      load_store();
      $("#serch_pop6").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search6').focus()", 100);   
    }
    if(e.keyCode== 46){
      $("#from_store").val("");
      $("#retur_persondes").val("");
    }
  });

  $("#pop_search6").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { 
     load_store();
   }
 });



  $("#btnDelete").click(function(){
   if($("#hid").val()!=0) {
    set_delete($("#hid").val());
  }
});

  $("#btnPrint").click(function(){
   if($("#hid").val()=="0"){
    set_msg("Please load data before print");
    return false;
  }else{
    $("#print_pdf").submit();
  }
});


  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
      $(this).attr("readonly","readonly");
    }
  });


});


function save(){
  $('#form_').attr('action',$('#form_id').val()+"t_hp_rivert_item");
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
      if(confirm("Save Completed, Do You Want A print?")){
        if($("#is_prnt").val()==1){
          $("#qno").val($("#id").val());
          $("#print_pdf").submit();
        }
        reload_form();
      }else{
        location.href="";
      }  
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

function reload_form(){
  setTimeout(function(){
    location.href= '';
  },50); 
}


function validate(){
  if($("#from_store").val()==""){
    set_msg("Please Select a store");
    $("#from_store").focus();
    return false
  }else if($("#return_person").val()==""){
    set_msg("Please enter Return Person.");
    $("#return_person").focus();
    return false;
  }else if($("#s_code").val()==""){
    $("#s_code").focus();
    return false;
  }else{
    return true;
  }
}


function set_delete(id){
  if(confirm("Are you sure to cancel the record "+id+"?")){
    loding();
    $.post("index.php/main/delete/t_hp_rivert_item", {
      id : id
    }, function(res){
      if(res == 1){
        loding();
        delete_msg();
      }else if(res == 2){
        set_msg("No permission to cancel the record.");
      }else{
        set_msg(res);
      }

    }, "text");
  }
}




function select_search(){
  $("#pop_search").focus();

}


function load_data(id){
  var g=[];
  empty_grid();
  loding();
  $.post("index.php/main/get_data/t_hp_rivert_item/", {
    id: id
  }, function(r){

    if(r=="2"){
      set_msg("No records");
    }else{
      if(r.sum[0].is_cancel=="1"){
        $("#mframe").css("background-image", "url('img/cancel.png')");
        $("#btnSave").attr('disabled','disabled');
        $("#btnDelete").attr('disabled','disabled');

      }
      $("#hid").val(id);   
      $("#id").val(id); 
      $("#qno").val(id); 
      $("#agr_no").val(r.sum[0].agr_no);
      $("#customer").val(r.sum[0].cus_id);
      $("#cus_name").val(r.sum[0].cus_name);
      $("#cus_address").val(r.sum[0].address1+", "+r.sum[0].address2+", "+r.sum[0].address3);
      $("#nno").val(r.sum[0].hp_nno); 
      $("#rf_no").val(r.sum[0].hpref_no);
      $("#dt_date").val(r.sum[0].hp_ddate);
      $("#from_store").val(r.sum[0].from_store);
      $("#store_des").val(r.sum[0].store_name);
      $("#return_person").val(r.sum[0].return_person);
      $("#retur_persondes").val(r.sum[0].ret_person_name);
      $("#note").val(r.sum[0].note);
      $("#s_code").val(r.sum[0].salesman);
      $("#salesman_name").val("");
      $("#tot_qty").val(r.sum[0].tot_qty);
      $("#date").val(r.sum[0].ddate);
      $("#ref_no").val(r.sum[0].ref_no);
      $("#seize_no").val(r.sum[0].seize_no);
      $("#net").val(r.sum[0].net_amount);

      for(var i=0; i<r.det.length;i++){
        $("#0_"+i).val(r.det[i].item_code);
        $("#item_name_"+i).val(r.det[i].item_name);
        $("#serial_no_"+i).val(r.det[i].serial_no);
        $("#a_qty_"+i).val(r.det[i].a_qty);
        $("#tqty_"+i).val(r.det[i].t_qty);
        $("#bt1_"+i).val(r.det[i].batch_no);
        $("#max_"+i).val(r.det[i].price);

        $("#numofserial_"+i).val(r.det[i].t_qty);
        check_is_serial_item2(r.det[i].item_code,i); 
        for(var a=0;a<r.serial.length;a++){
         if(r.det[i].item_code==r.serial[a].item){
          g.push(r.serial[a].serial_no);
          $("#all_serial_"+i).val(g);
        }   
      }
      g=[];  
    }


  }
  loding();
}, "json");  
}


function empty_grid(){
  for(var i=0; i<=$("#row_count").val(); i++){
    $("#h_"+i).val(0);
    $("#0_"+i).val("");
    $("#n_"+i).val("");
    $("#t_"+i).html("&nbsp;");
    $("#1_"+i).val("");
    $("#2_"+i).val("");
    $("#3_"+i).val("");
    $("#5_"+i).val("");
    $("#4_"+i).val("");
    $("#6_"+i).val("");
    $("#7_"+i).val("");
    $("#8_"+i).val("");
    $("#9_"+i).val("");

  }

}

function load_aggreement(){
 $.post("index.php/main/load_data/t_hp_rivert_item/load_agr_no",{
  search:$("#pop_search13").val()
},function(res){
  $("#sr13").html(res);
  agr_settings();
},"text");
}

function agr_settings(){

  $("#item_list .cl").click(function(){        
    $("#agr_no").val($(this).children().eq(1).html());
    $("#customer").val($(this).children().eq(2).html());
    $("#cus_name").val($(this).children().eq(3).html());
    $("#cus_address").val($(this).children().eq(4).html()+ " , " + $(this).children().eq(5).html()+ " , " +$(this).children().eq(5).html());
    $("#dt_date").val($(this).children().eq(7).html());
    $("#nno").val($(this).children().eq(8).html());
    $("#ref_no").val($(this).children().eq(9).html());
    $("#pop_close13").click(); 
    load_agr_items();              
  })    
}

function return_person(){
  $.post("index.php/main/load_data/utility/f1_selection_list",{
    data_tbl:"m_employee",
    field:"code",
    field2:"name",
    search:$("#pop_search").val()

  },function(r){
    $("#sr").html(r);
    ret_person_settings();
  },"text");
}

function ret_person_settings(){
  $("#item_list .cl").click(function(){        
    $("#return_person").val($(this).children().eq(0).html());
    $("#retur_persondes").val($(this).children().eq(1).html());
    $("#pop_close").click();
  });
}

function load_salesman(){
  $.post("index.php/main/load_data/utility/f1_selection_list",{
    data_tbl:"m_employee",
    field:"code",
    field2:"name",
    search:$("#pop_search2").val()

  },function(r){
    $("#sr2").html(r);
    salesman_settings();
  },"text");
}

function salesman_settings(){
  $("#item_list .cl").click(function(){        
    $("#s_code").val($(this).children().eq(0).html());
    $("#salesman_name").val($(this).children().eq(1).html());
    $("#pop_close2").click();
  });
}

function load_store(){
  $.post("index.php/main/load_data/utility/f1_selection_list",{
    data_tbl:"m_stores",
    field:"code",
    field2:"description",
    add_query:" AND cl='"+$('#cl').val()+"' AND bc='"+$('#bc').val()+"' AND transfer_location='0' ",
    search:$("#pop_search6").val()

  },function(r){
    $("#sr6").html(r);
    store_settings();
  },"text");
}

function store_settings(){
  $("#item_list .cl").click(function(){        
    $("#from_store").val($(this).children().eq(0).html());
    $("#store_des").val($(this).children().eq(1).html());
    $("#pop_close6").click();
  });
}

function load_agr_items(){

  $.post("index.php/main/load_data/t_hp_rivert_item/load_agr_item",{
    agr_no:$("#agr_no").val()
  },function(res){
    for(var i=0;i<res.data.length;i++){

      $("#0_"+i).val(res.data[i].item_code);
      $("#item_name_"+i).val(res.data[i].item_name);
      $("#serial_no_"+i).val(res.data[i].serials);
      $("#a_qty_"+i).val(res.data[i].qty);
      check_is_serial_item2(res.data[i].item_code,i);
      $("#bt1_"+i).val(res.data[i].batch);
      $("#seize_no").val(res.data[i].nno);
      $("#max_"+i).val(res.data[i].price);
    }

  },"json");
}

function cal_qty(){
  var loop=qty1=net_amount=0;
  $(".qty").each(function(){
    set_cid($(this).attr("id"));
    var qty2=parseFloat($("#tqty_"+loop).val());
    var netam=parseFloat($("#max_"+loop).val())*parseFloat($("#tqty_"+loop).val());
    if(isNaN(qty2)){
      qty2=0;
    }
    if(isNaN(netam)){
      netam=0;
    }
    qty1+=qty2;
    net_amount+=netam;
    $("#tot_qty").val(qty1);
    $("#net").val(net_amount);
    loop++;
  });

}


