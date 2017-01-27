$(document).ready(function () {

  $("#btn_open_customer").click(function(){
   window.open("?action=m_stores","_blank");  
 });

  $("#tgrid2").tableScroll({height:200});

  //$(".quns").css("display","none");
  $("#btnSavee").css("display","none");
  $("#btnApprove").attr("disabled", "disabled");

  $("#btnDelete5").click(function(){
    set_delete();
  });


  $("#btnPrint").click(function(){
    if($("#hid").val()=="0"){
      set_msg ("Please load data before print");
      return false;
    }else{
      $("#print_pdf").submit();
    }
  });

  $("#agr_no").keypress(function(e){ 
    if(e.keyCode==112){
      $("#pop_search").val('');
      load_agr_no();
      $("#serch_pop").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search').focus()", 100);   
    }
    $("#pop_search").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_agr_no();
      }
    });
    if(e.keyCode==46){
     $("#agr_no").val("");
     $("#inv_no").val("");
     $("#ref_bill").val("");
     empty_data();
   }  
 });

  $("#inv_no").keypress(function(e){
    if(e.keyCode==13){
      $("#agr_no").val("");
      $("#ref_bill").val("");
      load_invoice_no($("#inv_no").val());
    }
    if(e.keyCode==46){
     empty_data();
   }
 });

  $("#ref_bill").keypress(function(e){
    if(e.keyCode==13){
      $("#agr_no").val("");
      $("#inv_no").val("");
      load_ref_bill_no($("#ref_bill").val());
    }
    if(e.keyCode==46){
     empty_data();
   }
 });

  $("#btnApprove").click(function(){
    $("#app_status").val("2");
    if(validate()){
      save();    
    }
  });

  $("#id").keypress(function(e){
    if(e.keyCode == 13){
      $(this).blur();
      load_data($(this).val());
    }
  });
  $("#btnExit1").click(function(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';  
    $("#1_"+get_id).focus();
  });

});

function validate() {

  if($("#agr_no").val()==""){
    set_msg("Please Enter Agreement No");
    return false;
  }
  if($("#paid_amount").val()==""){
    set_msg("Please Enter Paid Amount");
    return false;
  }
  if($("#description").val()==""){
    set_msg("Please Enter Description");
    return false;
  }
  return true;
}

function load_agr_no() {
  $.post("index.php/main/load_data/t_hp_return/f1_selection_agr_no", {
    search : $("#pop_search").val() 
  }, function(r){
    $("#sr").html(r);
    settings_agr_no();      
  }, "text");
}

function settings_agr_no(){
  $("#item_list .cl").click(function(){        
    load_summary_detail($(this).children().eq(0).html());
    $("#pop_close").click();                
  })    

  function load_summary_detail(agr_no) {
    $.post("index.php/main/load_data/t_hp_return/sum_details", {
      agr: agr_no,
      type:'1'   
    }, 
    function(r){
      $("#inv_no").val(r.nno);
      $("#agr_no").val(r.agreement_no);
      $("#ref_bill").val(r.ref_no);
      $("#customer_id").val(r.cus_id);
      $("#customer_des").val(r.name);
      $("#salesman_id").val(r.rep);
      $("#salesman_des").val(r.salesman);
      $("#store_id").val(r.store_id);
      $("#store_des").val(r.store);
      load_crn_amount(r.agreement_no,r.nno);
      load_grid_data(r.agreement_no,r.nno);
    },"json");
  }
}


function load_invoice_no(inv_no){
  $.post("index.php/main/load_data/t_hp_return/sum_details", {
    inv_no: inv_no,
    type:'2'   
  }, 
  function(r){
    $("#inv_no").val(r.nno);
    $("#agr_no").val(r.agreement_no);
    $("#ref_bill").val(r.ref_no);
    $("#customer_id").val(r.cus_id);
    $("#customer_des").val(r.name);
    $("#salesman_id").val(r.rep);
    $("#salesman_des").val(r.salesman);
    $("#store_id").val(r.store_id);
    $("#store_des").val(r.store);
    load_crn_amount(r.agreement_no,r.nno);
    load_grid_data(r.agreement_no,r.nno);

  },"json");
}

function load_ref_bill_no(bill_no){
  $.post("index.php/main/load_data/t_hp_return/sum_details", {
    bill_no: bill_no,
    type:'3'   
  }, 
  function(r){
    $("#inv_no").val(r.nno);
    $("#agr_no").val(r.agreement_no);
    $("#ref_bill").val(r.ref_no);
    $("#customer_id").val(r.cus_id);
    $("#customer_des").val(r.name);
    $("#salesman_id").val(r.rep);
    $("#salesman_des").val(r.salesman);
    $("#store_id").val(r.store_id);
    $("#store_des").val(r.store);
    load_crn_amount(r.agreement_no,r.nno);
    load_grid_data(r.agreement_no,r.nno);

  },"json");
}



function load_grid_data(agr_no,nno){
 var g=[];
 $.post("index.php/main/load_data/t_hp_return/load_grid_data", {
  agr_no: agr_no,
  id:nno
}, 
function(r){
 for(x=0;x<r.a.length;x++){
  $("#0_"+x).val(r.a[x].item_code);
  $("#n_"+x).val(r.a[x].description);
  $("#m_"+x).val(r.a[x].model);
  $("#bt_"+x).val(r.a[x].batch_no);
  $("#1_"+x).val(r.a[x].qty);
  $("#foc_"+x).val(r.a[x].foc);
  $("#2_"+x).val(r.a[x].sales_price);
  $("#3_"+x).val(r.a[x].discount_pre);
  $("#4_"+x).val(r.a[x].discount);
  $("#5_"+x).val(r.a[x].amount);


  if($("#df_is_serial").val()=='1'){
    check_is_serial_item2(r.a[x].item_code,x);
    $("#numofserial_"+x).val(r.a[x].qty);
    for(var a=0;a<r.serial.length;a++){
      if(r.a[x].item_code==r.serial[a].item){
        g.push(r.serial[a].serial_no);
        $("#all_serial_"+x).val(g);
      }   
    }
    g=[];                 
  } 

  check_is_batch_item2(r.a[x].item_code,x);
  check_is_sub_item2(r.a[x].item_code,x); 
  is_sub_item(x);                          

}
$("#gross_amount").val(r.b[0].gross_amount);
$("#free_amount").val(r.b[0].foc_tot);
$("#dis_amount").val(r.b[0].discount);
$("#net_amount").val(r.b[0].net_amount);
},"json");
}

function check_is_batch_item2(x,scid){
  var store=$("#stores").val();
  $.post("index.php/main/load_data/t_cash_sales_sum/is_batch_item",{
    code:x,
    store:store
  },function(res){
   $("#btnb_"+scid).css("display","none"); 
   if(res==1){
     $("#btnb_"+scid).css("display","block");
   }
 },'text');
}

function check_is_sub_item2(x,scid){
  var store=$("#stores").val();
  $.post("index.php/main/load_data/utility/is_sub_item",{
    code:x          
  },function(res){
    $("#sub_"+scid).css("display","none");    
    if(res==1){
      $("#sub_"+scid).css("display","block");
    }
  },'text');
}


function is_sub_item(x){
  sub_items=[];
  
  $("#subcode_"+x).val("");
  $.post("index.php/main/load_data/utility/is_sub_items", {
    code:$("#0_"+x).val(),
    qty:$("#1_"+x).val(),
    batch:$("#bt_"+x).val()
  }, function(r){
    if(r!=2){
      for(var i=0; i<r.sub.length;i++){
        add(x,r.sub[i].sub_item,r.sub[i].qty);
      }  
      $("#subcode_"+x).attr("data-is_click","1");
    }
  },"json");
}

function empty_data(){
  $("#inv_no").val('');
  $("#agr_no").val('');
  $("#ref_bill").val('');
  $("#customer_id").val('');
  $("#customer_des").val('');
  $("#salesman_id").val('');
  $("#salesman_des").val('');
  $("#store_id").val('');
  $("#store_des").val('');

  for(x=0;x<25;x++){
    $("#0_"+x).val('');
    $("#n_"+x).val('');
    $("#m_"+x).val('');
    $("#bt_"+x).val('');
    $("#1_"+x).val('');
    $("#foc_"+x).val('');
    $("#2_"+x).val('');
    $("#3_"+x).val('');
    $("#4_"+x).val('');
    $("#5_"+x).val('');
  }
  $("#gross_amount").val('');
  $("#free_amount").val('');
  $("#dis_amount").val('');
  $("#net_amount").val('');
  $("#crn_amount").val('');
}

function save(){

 $("#dt").val($("#date").val());
 $("#qno").val($("#id").val());
 $("#cus_id").val($("#customer_id").val());
 $("#salesp_id").val($("#salesman_id").val());
 $("#store").val($("#store_id").val());
 $("#agrmnt_no").val($("#agr_no").val());
 var frm = $('#form_');
 loding();
 $.ajax({
  type: frm.attr('method'),
  url: frm.attr('action'),
  data: frm.serialize(),
  success: function (pid){
    if(pid == 1){
      input_active();
      reload_form();
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
  var g=[];

  loding();
  $.post("index.php/main/get_data/t_hp_return/", {
    id: id
  }, function(r){

    if(r=="2"){
     set_msg("No records");
   }else{
    $("#hid").val(id);   
    $("#id").val(id); 
    $("#agr_no").val(r.sum[0].agr_no);
    $("#inv_no").val(r.sum[0].inv_no);
    $("#ref_bill").val(r.sum[0].ref_bill_no);
    $("#customer_id").val(r.sum[0].cus_id);
    $("#customer_des").val(r.sum[0].name);
    $("#salesman_id").val(r.sum[0].salesman_id);
    $("#salesman_des").val(r.sum[0].salsman_name);
    $("#store_id").val(r.sum[0].store);
    $("#store_des").val(r.sum[0].store_name);
    $("#date").val(r.sum[0].ddate); 
    $("#ref_no").val(r.sum[0].ref_no);
    $("#crn_no").val(r.sum[0].crn_no);
    $("#crn_amount").val(r.sum[0].crn_amount); 
    $("#description").val(r.sum[0].memo);
    $("#paid_amount").val(r.sum[0].paid_amount);
    $("#gross_amount").val(r.sum[0].gross_amount);
    $("#free_amount").val(r.sum[0].free_tot);
    $("#dis_amount").val(r.sum[0].discount);
    $("#net_amount").val(r.sum[0].net_amount);
    $("#agr_no").attr("readonly", "readonly");
    $("#inv_no").attr("readonly", "readonly");
    $("#ref_bill").attr("readonly", "readonly");

    $("#dt").val(r.sum[0].ddate);
    $("#qno").val(id);
    $("#cus_id").val(r.sum[0].cus_id);
    $("#salesp_id").val(r.sum[0].salesman_id);
    $("#store").val(r.sum[0].store);
    $("#agrmnt_no").val(r.sum[0].agr_no);


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

      $("#h_"+i).val(r.det[i].code);
      $("#0_"+i).val(r.det[i].code);
      $("#n_"+i).val(r.det[i].description);
      $("#m_"+i).val(r.det[i].model);
      $("#1_"+i).val(r.det[i].qty);
      $("#bt_"+i).val(r.det[i].batch_no);
      $("#2_"+i).val(r.det[i].price);
      $("#3_"+i).val(r.det[i].discountp);
      $("#4_"+i).val(r.det[i].discount);
      $("#5_"+i).val(r.det[i].amount);
      $("#foc_"+i).val(r.det[i].foc);
      $("#is_free_"+i).val(r.det[i].is_free);
      $("#qno").val(id);

      is_sub_item(i);

    }

    $("#btnApprove").attr("disabled", false);  

    if(r.sum[0].is_approve==1){
      $("#btnDelete5").attr("disabled", "disabled");
      $("#btnSave").attr("disabled", "disabled");
      $("#btnApprove").attr("disabled", "disabled");
      $("#mframe").css("background-image", "url('img/approved1.png')");
    }  

    if(r.sum[0].is_cancel==1){
      $("#btnDelete5").attr("disabled", "disabled");
      $("#btnSave").attr("disabled", "disabled");
      $("#btnApprove").attr("disabled", "disabled");
      $("#mframe").css("background-image", "url('img/cancel.png')");
    }


    input_active();
  }
  loding();            
}, "json");
  
}

function set_delete(){
  var id = $("#hid").val();
  if(id != 0){
    if(confirm("Are you sure to delete this Hp return ["+$("#hid").val()+"]? ")){
      $.post("index.php/main/delete/t_hp_return", {
        trans_no:id,
        inv_no:$("#inv_no").val(),

      },function(r){
        if(r != 1){
          set_msg(r);
        }else{
          delete_msg();
        }
      }, "text");
    }
  }else{
    set_msg
    ("Please load record");
  }
}


function load_crn_amount(agr_no,nno){
  $.post("index.php/main/load_data/t_hp_return/load_crn_data", {
    agr_no: agr_no,
    id:nno
  }, 
  function(r){

    $("#crn_amount").val(r.crn_amount);
  },"json");
}