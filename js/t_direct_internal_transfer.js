$(document).ready(function(){

  $(".qunsb").css("display","none");

  $(".fo").blur(function(){
    var id=$(this).attr("id").split("_")[1];
    if($(this).val()=="" || $(this).val()=="0"){
    }else if($(this).val()!=$("#itemcode_"+id).val()){
      if($("#df_is_serial").val()=='1'){
        deleteSerial(id);
      }
    }
  });

  $('#tgrid').find('input').blur(function(){
    amount();
  });

  $(".ky").keyup(function(){
    set_cid($(this).attr("id"));
    var aqty = parseFloat($("#qtyh_"+scid).val());
    var tqty = parseFloat($("#3_"+scid).val());    
    if(aqty<tqty){
      set_msg("Maximum available quantity is "+aqty);
      $("#3_"+scid).val(0);
      return false;
    }  
  });

  $("#officer").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search11").val($("#officer").val());
      load_data_emp();
      $("#serch_pop11").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search11').focus()", 100);
    }

    $("#pop_search11").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_data_emp();
      }
    }); 

    if(e.keyCode == 46){
      $("#officer").val("");
      $("#officer_id").val("");
    }
  });

  $("#frm_cluster").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search10").val($("#frm_cluster").val());
      load_frm_cluster();
      $("#serch_pop10").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search10').focus()", 100);
    }
    $("#pop_search10").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_frm_cluster();
      }
    }); 
    if(e.keyCode == 46){
      /*$("#frm_cluster").val("");
      $("#from_cluster_name").val("");
      $("#frm_branch").val("");
      $("#from_branch_name").val("");
      $("#frm_stores").val("");
      $("#from_stores_name").val("");
      empty_grid();*/
    }
  });

  $("#to_cluster").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search10").val($("#to_cluster").val());
      load_to_cluster();
      $("#serch_pop14").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search14').focus()", 100);
    }
    $("#pop_search14").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_to_cluster();
      }
    }); 
    if(e.keyCode == 46){
      $("#to_cluster").val("");
      $("#to_cluster_name").val("");
      $("#to_branch").val("");
      $("#to_branch_name").val("");
      $("#to_stores").val("");
      $("#to_stores_name").val("");
    }
  });

  $("#frm_branch").keypress(function(e){
    if($("#frm_cluster").val()!=""){
      if(e.keyCode == 112){
        $("#pop_search12").val($("#frm_branch").val());
        load_frm_branch();
        $("#serch_pop12").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search12').focus()", 100);
      }
      $("#pop_search12").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
          load_frm_branch();
        }
      }); 
      if(e.keyCode == 46){
        /*$("#frm_branch").val("");
        $("#from_branch_name").val("");
        $("#frm_stores").val("");
        $("#from_stores_name").val("");
        empty_grid();*/
      }
    }else{
      set_msg("Please select from cluster first");
      $("#frm_cluster").focus();
    }
  });

  $("#to_branch").keypress(function(e){
    if($("#to_cluster").val()!=""){
      if(e.keyCode == 112){
        $("#pop_search15").val($("#to_branch").val());
        load_to_branch();
        $("#serch_pop15").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search15').focus()", 100);
      }
      $("#pop_search15").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
          load_to_branch();
        }
      }); 
      if(e.keyCode == 46){
        $("#to_branch").val("");
        $("#to_branch_name").val("");
        $("#to_stores").val("");
        $("#to_stores_name").val("");
      }
    }else{
      set_msg("Please select to cluster first");
      $("#to_cluster").focus();
    }
  });

  $("#frm_stores").keypress(function(e){
    if($("#frm_branch").val()!=""){
      if(e.keyCode == 112){
        $("#pop_search13").val($("#frm_stores").val());
        load_frm_stores();
        $("#serch_pop13").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search13').focus()", 100);
      }
      $("#pop_search13").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
          load_frm_stores();
        }
      }); 
      if(e.keyCode == 46){
        $("#frm_stores").val("");
        $("#from_stores_name").val("");
        empty_grid();
      }
    }else{
      set_msg("Please select from branch first");
      $("#frm_branch").focus();
    }
  });

  $("#to_stores").keypress(function(e){
    if($("#to_branch").val()!=""){
      if(e.keyCode == 112){
        $("#pop_search6").val($("#to_stores").val());
        load_to_stores();
        $("#serch_pop6").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search6').focus()", 100);
      }
      $("#pop_search6").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
          load_to_stores();
        }
      }); 
      if(e.keyCode == 46){
        $("#to_stores").val("");
        $("#to_stores_name").val("");
      }
    }else{
      set_msg("Please select to branch first");
      $("#to_branch").focus();
    }
  });






  $(".qunsb").click(function(){
    set_cid($(this).attr("id"));
    check_is_batch_item(scid);
  });


  $("#btnDelete").click(function(){
    set_delete();
  });


  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#3_"+get_id).focus();
  });


  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#3_"+scid).focus();
  });


  $("#gen").click(function(){
    var free_fix=$("#free_fix").val();
    var post_fix=$("#pst").val();
    var start_no=parseInt($("#abc").val());
    var quantity=parseInt($("#quantity").val());

    for(x=0;x<quantity;x++){
      start_no=start_no+1;
      var code_gen=free_fix+start_no.toString()+post_fix;
      $("#srl_"+x).val(code_gen);
    }
  });


  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $("#id").attr('readonly','readonly');
      load_data($(this).val());
    }
  });


  $("#btnPrint").click(function(){
    $("#print_pdf").submit();
  });

  $("#grid").tableScroll({height:355});
  $("#tgrid").tableScroll({height:300});

  $(".fo").keypress(function(e){
    set_cid($(this).attr("id"));
    if($("#frm_stores").val()!=""){
      if(e.keyCode==112){
        $("#pop_search").val($("#0_"+scid).val());
        load_items();
        $("#serch_pop").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search').focus();", 100);
      }
    }else{
      set_msg("please select from store first");      
    }

    if(e.keyCode==46){
      if($("#df_is_serial").val()=='1'){
        $("#all_serial_"+scid).val(""); 
      }
      $("#0_"+scid).val("");
      $("#1_"+scid).val(""); 
      $("#2_"+scid).val(""); 
      $("#3_"+scid).val("");
      $("#min_"+scid).val(""); 
      $("#m_"+scid).val("");
      $("#max_"+scid).val(""); 
      $("#cost_"+scid).val(""); 
      $("#amount_"+scid).val(""); 
      $("#qtyh_"+scid).val(""); 
      $("#3_"+scid).attr("placeholder",""); 
      $("#btn_"+scid).css("display","none");
      $("#btnb_"+scid).css("display","none");
      $("#t_"+scid).html("&nbsp;");
      $("#subcode_"+scid).val("");
      $("#subcode_"+scid).removeAttr("data-is_click"); 
    }  
    amount();
  });

  $("#pop_search").keyup(function(e){
    if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 ) { load_items();
    }
  });  

  $("#pop_search").gselect();
});

function set_delete(){
  var id = $("#hid").val();
  if(id != 0){
    if(confirm("Are you sure to delete this direct transfer no ["+$("#hid").val()+"]? ")){
      $.post("index.php/main/delete/t_direct_internal_transfer", {
        no:id,
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

function load_frm_cluster(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_cluster",
    field:"code",
    field2:"description",
    preview2:"Cluster Name",
    add_query:" AND code !='"+$("#to_cluster").val()+"'",
    search : $("#pop_search10").val() 
  }, function(r){
    $("#sr10").html(r);
    settings_frm_cluster();            
  }, "text");
}

function settings_frm_cluster(){
  $("#item_list .cl").click(function(){        
    $("#frm_cluster").val($(this).children().eq(0).html());
    $("#from_cluster_name").val($(this).children().eq(1).html());
    $("#pop_close10").click();                
  })    
}

function load_to_cluster(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_cluster",
    field:"code",
    field2:"description",
    preview2:"Cluster Name",
    search : $("#pop_search14").val() 
  }, function(r){
    $("#sr14").html(r);
    settings_to_cluster();            
  }, "text");
}

function settings_to_cluster(){
  $("#item_list .cl").click(function(){        
    $("#to_cluster").val($(this).children().eq(0).html());
    $("#to_cluster_name").val($(this).children().eq(1).html());
    $("#pop_close14").click();                
  })    
}


function load_to_branch(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_branch",
    field:"bc",
    field2:"name",
    preview2:"Branch Name",
    add_query:" AND cl='"+$("#to_cluster").val()+"' AND bc !='"+$("#frm_branch").val()+"'  ",
    search : $("#pop_search15").val() 
  }, function(r){
    $("#sr15").html(r);
    settings_to_branch();            
  }, "text");
}

function settings_to_branch(){
  $("#item_list .cl").click(function(){        
    $("#to_branch").val($(this).children().eq(0).html());
    $("#to_branch_name").val($(this).children().eq(1).html());
    $("#pop_close15").click();                
  })    
}


function load_frm_branch(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_branch",
    field:"bc",
    field2:"name",
    preview2:"Branch Name",
    add_query:" AND cl='"+$("#frm_cluster").val()+"'",
    search : $("#pop_search12").val() 
  }, function(r){
    $("#sr12").html(r);
    settings_frm_branch();            
  }, "text");
}

function settings_frm_branch(){
  $("#item_list .cl").click(function(){        
    $("#frm_branch").val($(this).children().eq(0).html());
    $("#from_branch_name").val($(this).children().eq(1).html());
    $("#pop_close12").click();                
  })    
}

function load_frm_stores(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_stores",
    field:"code",
    field2:"description",
    preview2:"Store Name",
    add_query:" AND bc='"+$("#frm_branch").val()+"'",
    search : $("#pop_search13").val() 
  }, function(r){
    $("#sr13").html(r);
    settings_frm_stores();            
  }, "text");
}

function settings_frm_stores(){
  $("#item_list .cl").click(function(){        
    $("#frm_stores").val($(this).children().eq(0).html());
    $("#from_stores_name").val($(this).children().eq(1).html());
    $("#pop_close13").click();                
  })    
}

function load_to_stores(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_stores",
    field:"code",
    field2:"description",
    preview2:"Store Name",
    add_query:" AND bc='"+$("#frm_branch").val()+"' AND transfer_location='1'",
    search : $("#pop_search6").val() 
  }, function(r){
    $("#sr6").html(r);
    settings_to_stores();            
  }, "text");
}

function settings_to_stores(){
  $("#item_list .cl").click(function(){        
    $("#to_stores").val($(this).children().eq(0).html());
    $("#to_stores_name").val($(this).children().eq(1).html());
    $("#pop_close6").click();                
  })    
}

function load_data_emp(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_employee",
    field:"code",
    field2:"name",
    preview2:"Employee Name",
    search : $("#pop_search11").val() 
  }, function(r){
    $("#sr11").html(r);
    settings_emp();            
  }, "text");
}

function settings_emp(){
  $("#item_list .cl").click(function(){        
    $("#officer").val($(this).children().eq(0).html());
    $("#officer_id").val($(this).children().eq(1).html());
    $("#pop_close11").click();                
  })    
}

function is_sub_item(x){
  sub_items=[];
  $("#subcode_"+x).val("");
  $.post("index.php/main/load_data/utility/is_sub_items", {
    code:$("#0_"+x).val(),
    qty:$("#3_"+x).val(),
    batch:$("#2_"+x).val()
  }, function(r){
    if(r!=2){
      for(var i=0; i<r.sub.length;i++){
        add(x,r.sub[i].sub_item,r.sub[i].qty);
      }  
      $("#subcode_"+x).attr("data-is_click","1");
    }
  },"json");
}

function add(x,items,qty){
  $.post("index.php/main/load_data/utility/is_sub_items_available", {
    code:items,
    qty:qty,
    grid_qty:$("#3_"+x).val(),
    batch:$("#2_"+x).val(),
    hid:$("#hid").val(),
    store:$("#from_store").val(),
    trans_type:"13"
  }, function(res){ 
    if(res!=2){
      sub_items.push(res.sub[0].sub_item+"-"+res.sub[0].qty);
      $("#subcode_"+x).val(sub_items);         
    }else{
      set_msg("Not enough quantity in this sub item ("+items+")","error");
      $("#subcode_"+x).val("");
    }
  },"json");
}

function empty_grid(){
  for(var i=0; i<25; i++){       
    $("#0_"+i).val("");       
    $("#1_"+i).val("");
    $("#2_"+i).val("");
    $("#3_"+i).val(""); 
    $("#m_"+i).val(""); 
    $("#cost_"+i).val(""); 
    $("#min_"+i).val(""); 
    $("#max_"+i).val(""); 
    $("#amount_"+i).val(""); 
    $("#qtyh_"+i).val(""); 
    $("#all_serial_"+i).val(""); 
    $("#3_"+i).attr("placeholder","");  
    $("#subcode_"+i).val("");
    $("#subcode_"+i).removeAttr("data-is_click");      
  }
  $(".quns").css("display","none");
  $(".qunsb").css("display","none");
  amount();
}

function save(){
  if($("#df_is_serial").val()=='1'){
    serial_items.sort();
    $("#srls").attr("title",serial_items);
    $("#srls").val(serial_items);
  }
  var frm = $('#form_');
  loding();
  $.ajax({
   type: frm.attr('method'),
   url: frm.attr('action'),
   data: frm.serialize(),
   success: function (pid){
    var sid=pid.split('@');
    loding();
    if(pid==5){
      set_msg('Please check the serial numbers');
    }else if(sid[0]==1){
      $("#btnSave").attr("disabled",true);
      if(confirm("Save Completed, Do You Want A print?")){
        if($("#is_prnt").val()==1){
          $("#qno").val(sid[1]);
          $("#print_pdf").submit();
        }
        location.href="";
      }else{
        location.href="";
      }
    }else{
      set_msg(pid);
    }
  }
});
  if($("#df_is_serial").val()=='1'){
    serial_items.splice(0);
  }
}


function load_items(){
  $.post("index.php/main/load_data/t_direct_internal_transfer/item_list_all", {
    search : $("#pop_search").val(),
    cl:$("#frm_cluster").val(),
    bc:$("#frm_branch").val(),
    stores: $("#frm_stores").val()
  }, function(r){
    $("#sr").html(r);
    settings();
  }, "text");
}


function settings(){                                                                                                
  $("#item_list .cl").click(function(){
    if($(this).children().eq(0).html() != "&nbsp;"){   
      if($("#df_is_serial").val()=='1'){
        check_is_serial_item2($(this).children().eq(0).html(),scid);
      }
      check_is_batch_item2($(this).children().eq(0).html(),scid);

      $("#0_"+scid).val($(this).children().eq(0).html());
      $("#1_"+scid).val($(this).children().eq(1).html());
      $("#m_"+scid).val($(this).children().eq(2).html());
      $("#2_"+scid).val($(this).children().eq(3).html());

      $("#cost_"+scid).val($(this).children().eq(4).html());
      $("#min_"+scid).val($(this).children().eq(5).html());

      $("#max_"+scid).val($(this).children().eq(6).html());    

      $("#qtyh_"+scid).val($(this).children().eq(7).html());
      $("#pop_close").click();
      $("#3_"+scid).focus();
      check_is_batch_item(scid); 
    }else{
      $("#pop_close").click();
      $("#3_"+scid).focus();
    }     
  });
}


function validate(){
  if ($("#to_cluster").val()==""){
    set_msg("Please select transfer to cluster");
    $("#to_cluster").focus();
    return false;
  }else if($("#to_branch").val()==""){
    set_msg("Please select transfer to branch");
    $("#to_branch").focus();
    return false;
  }else if($("#to_stores").val()==""){
    set_msg("Please select transfer to store");
    $("#to_stores").focus();
    return false;
  }else if($("#officer").val()==""){
    set_msg("Please select officer");
    $("#officer").focus();
    return false;
  }else{
    return true;
  }         
}  


function load_data(id){
  var g=[];
  loding();
  $.post("index.php/main/get_data/t_direct_internal_transfer/", {
    id: id,
  }, function(r){
    loding();
    if(r=="2"){
      set_msg("No records");
    }else{
      empty_grid();
      $("#id").val(id);
      $("#hid").val(id);
      $("#qno").val(id);
      $("#frm_stores").val(r.sum[0].from_store);
      $("#from_stores_name").val(r.sum[0].from_store_des);
      $("#to_cluster").val(r.sum[0].to_cl);
      $("#to_cluster_name").val(r.sum[0].t_cl_des);
      $("#to_branch").val(r.sum[0].to_bc);
      $("#to_branch_name").val(r.sum[0].t_bc_des);
      $("#to_stores").val(r.sum[0].to_store);
      $("#to_stores_name").val(r.sum[0].t_store_des);
      $("#memo").val(r.sum[0].memo);
      $("#date").val(r.sum[0].ddate);
      $("#ref_no").val(r.sum[0].ref_no);
      $("#officer").val(r.sum[0].officer);
      $("#officer_id").val(r.sum[0].e_des);
      $("#net_amount").val(r.sum[0].net_amount);
      $("#btnSave").attr("disabled", true);
     

      for(var i=0; i<r.det.length;i++){
        $("#0_"+i).val(r.det[i].code);
        $("#h_"+i).val(r.det[i].code);
        $("#1_"+i).val(r.det[i].item_name);
        $("#m_"+i).val(r.det[i].model);
        $("#2_"+i).val(r.det[i].batch_no);
        $("#cost_"+i).val(r.det[i].cost);
        $("#min_"+i).val(r.det[i].min);
        $("#max_"+i).val(r.det[i].max);
        $("#3_"+i).val(r.det[i].qty);
        $("#amount_"+i).val(r.det[i].amount);


        if($("#df_is_serial").val()=='1'){
          $("#numofserial_"+i).val(r.det[i].qty);
          check_is_serial_item2(r.det[i].code,i); 
          for(var a=0;a<r.serial.length;a++){
            //if(r.det[i].code==r.serial[a].item){
            	if(r.det[i].code==r.serial[a].item && r.det[i].batch_no == r.serial[a].batch_no){
              g.push(r.serial[a].serial_no);
              $("#all_serial_"+i).val(g);
            }   
          }
          g=[]; 
        }
        check_is_batch_item2(r.det[i].code,i);               
        is_sub_item(i);  
      }
    }  
    amount();  
  }, "json");
}


function check_item_exist3(id){
  var v = true;
  return v;
}

function settings3(){
  $("#batch_item_list .cl").click(function(){
    if($(this).children().eq(0).html() != "&nbsp;"){
      if(check_item_exist3($(this).children().eq(0).html())){
        $("#2_"+scid).val($(this).children().eq(0).html());
        //$("#3_"+scid).val($(this).children().eq(1).html());
        $("#qtyh_"+scid).val($(this).children().eq(1).html());
        $("#min_"+scid).val($(this).children().eq(3).html());
        $("#max_"+scid).val($(this).children().eq(4).html());
        $("#cost_"+scid).val($(this).children().eq(2).html());
        $("#1_"+scid).attr("readonly","readonly");
        $("#3_"+scid).focus();
        $("#pop_close3").click();
      }else{
        set_msg("Item "+$(this).children().eq(1).html()+" is already added.");
      }
    }else{
      $("#2_"+scid).val("");
      $("#3_"+scid).val("");
      $("#pop_close3").click();
    }
  });
}


function load_items3(x){
  $.post("index.php/main/load_data/t_direct_internal_transfer/batch_item", {
    search : x,
    stores : $("#frm_stores").val()
  }, function(r){
    $("#sr3").html(r);
    settings3();
  }, "text");
}

function select_search3(){
  $("#pop_search3").focus();
}

function check_is_batch_item(scid){
  var store=$("#frm_stores").val();
  $.post("index.php/main/load_data/t_direct_internal_transfer/is_batch_item",{
    code:$("#0_"+scid).val(),
    store:store
  },function(res){
    if(res==1){
      $("#serch_pop3").center();
      $("#blocker3").css("display", "block");
      setTimeout("select_search3()", 100);
      load_items3($("#0_"+scid).val());
    } else if(res=='0'){
      $("#2_"+scid).val("0");
      $("#2_"+scid).attr("readonly","readonly");
    } else {
      $("#2_"+scid).val(res.split("-")[0]);
      $("#5_"+scid).val(res.split("-")[1]);
      $("#qtyh_"+scid).val(res.split("-")[1]);
      $("#min_"+scid).val(res.split("-")[3]);
      $("#max_"+scid).val(res.split("-")[4]);
      $("#cost_"+scid).val(res.split("-")[2]);
      $("#2_"+scid).attr("readonly","readonly");
    }
  },'text');
}

function check_is_batch_item2(x,scid){
  var store=$("#frm_stores").val();
  $.post("index.php/main/load_data/t_direct_internal_transfer/is_batch_item",{
    code:x,
    store:store
  },function(res){
    $("#btnb_"+scid).css("display","none");  
    if(res==1){
      $("#btnb_"+scid).css("display","block");
    }
  },'text');
}

function amount(){
  var net_amount=parseFloat(0);
  for(var x=0; x<25; x++){
    if($("#0_"+x).val()!="" && $("#3_"+x).val()>0){
      var qty =parseFloat($("#3_"+x).val());
      var cost =parseFloat($("#cost_"+x).val());
      var amount = parseFloat(0);
      if(isNaN(qty)){qty=0;}
      if(isNaN(cost)){cost=0;}
      amount = qty*cost;
      $("#amount_"+x).val(m_round(amount));
      net_amount+=amount;
    }
    $("#net_amount").val(m_round(net_amount));
  }
}
