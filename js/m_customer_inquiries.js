$(document).ready(function(){
  $("#btnReset").click(function(){
    location.href="?action=m_customer_inquiries";
  });

  load_customer_history(0)

  $("#cus_id").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search2").val($("#cus_id").val());
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
      $("#cus_id").val("");
      $("#cus_name").val("");
      $("#address").val("");
    }
  });
  
  $("#btnDelete").click(function() {
    if($("#hid").val()!="" && $("#hid").val()!="0"){
      set_delete($("#hid").val());
    }else{
      set_msg("please load data before delete");
    }
  });

  $("#officer").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search6").val();
      load_data8();
      $("#serch_pop6").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search6').focus()", 100);
    }

    $("#pop_search6").keyup(function(e){            
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
       load_data8();
     }
   }); 

    if(e.keyCode == 46){
      $("#officer").val("");
      $("#officer_des").val("");
    }
  });

  $("#act").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search14").val();
      load_data_act();
      $("#serch_pop14").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search14').focus()", 100);
    }

    $("#pop_search14").keyup(function(e){            
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
       load_data_act();
     }
   }); 

    if(e.keyCode == 46){
      $("#act").val("");
      $("#act_des").val("");
    }
  });

});

function load_data_act(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:'r_customer_action',
    field:"code",
    field2:"description",
    preview2:"Description",
    search : $("#pop_search14").val() 
  }, function(r){
    $("#sr14").html("");
    $("#sr14").html(r);
    settings_act();            
  }, "text");
}

function settings_act(){
  $("#item_list .cl").click(function(){        
    $("#act").val($(this).children().eq(0).html());
    $("#act_des").val($(this).children().eq(1).html());
    $("#pop_close14").click();                
  })    
}

function load_data8(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:'m_employee',
    field:"code",
    field2:"name",
    preview2:"Name",
    search : $("#pop_search6").val() 
  }, function(r){
    $("#sr6").html("");
    $("#sr6").html(r);
    settings8();            
  }, "text");
}

function settings8(){
  $("#item_list .cl").click(function(){        
    $("#officer").val($(this).children().eq(0).html());
    $("#officer_des").val($(this).children().eq(1).html());
    $("#pop_close6").click();                
  })    
}

function load_data9(){
  $.post("index.php/main/load_data/utility/f1_selection_list_customer", {
    data_tbl:"m_customer",
    field:"code",
    field2:"name",
    field3:"nic",
    field4:"tp",
    add_query:" AND is_customer='1'",
    preview1:"Customer ID",
    preview2:"Customer Name",
    preview3:"Customer NIC",
    field_address:'1',
    search : $("#pop_search2").val() 
  }, function(r){
    $("#sr2").html("");
    $("#sr2").html(r);
    settings9();            
  }, "text");
}

function settings9(){
  $("#item_list .cl").click(function(){        
    $("#cus_id").val($(this).children().eq(0).html());
    $("#cus_name").val($(this).children().eq(1).html());
    $("#address").val($(this).children().eq(3).html());
    load_customer_history($(this).children().eq(0).html());
    $("#blocker").css("display","none");
    $("#pop_close2").click();                
  })    
}

function load_customer_history(customer){
  loding();
  $.post("index.php/main/load_data/m_customer_inquiries/customer_history", {
    customer :customer
  }, function(res){
    loding();
    item_det="<table><tr><td>";

    item_det+="<h3 style='width:635px; margin-bottom:0px; font-family:calibri;background:#9B9CB2;color:#fff;text-transform:uppercase;'>Customer History</h3>";
    item_det+="<table id='cashTb' style='width:635px;/*margin-top:-20px;*/padding:5px 0px;'>";
    item_det+="<tr><td style='width:10%;color:#fff;background:#07646b;'>Customer</td><td style='width:15%;color:#fff;background:#07646b;'>Action</td><td style='color:#fff;background:#07646b;'>Officer</td><td style='width:15%;color:#fff;background:#07646b;'>Note</td><td style='width:2%;color:#fff;background:#07646b;'>Edit</td></tr>";

    for(var x=0; x<res.length; x++){
      item_det+="<tr class='trow'>";
      item_det+="<td style='width:10%;border:1px solid #aaa;padding:3px 5px;text-align:left;'>"+res[x].name+"</td>";
      item_det+="<td style='width:15%;border:1px solid #aaa;padding:3px 5px;text-align:left;'>"+res[x].action+"</td>";
      item_det+="<td style='width:15%;border:1px solid #aaa;padding:3px 5px;text-align:left;'>"+res[x].emp_name+"</td>";
      item_det+="<td style='border:1px solid #aaa;padding:3px 5px;text-align:right;'>"+res[x].note+"</td>";
      item_det+="<td style='display: none;'>"+res[x].nno+"</td>";
      item_det+="<td class='ed' style='cursor:pointer;border:1px solid #aaa;text-align:center;width:12px;'><img width='20px' height='20px' src='img/edit.gif'/></td>";
      
      item_det+="</tr>";
    }  
    item_det+="</table>";
    item_det+="<hr style='width:100%'/>";

    $("#grid_body").html(item_det);

    $("#cashTb").tableScroll({height:315});
    settings_load();

  }, "json");
}

function settings_load(){
  $(document).on('click','#cashTb .ed', function(){
    //var code = $(this).children().eq(4).html();
    var code = $(this).closest('tr').find('td').eq(4).html();
    set_edit(code);
  });
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
        loding();
        sucess_msg();
      }else if(pid == 2){
        set_msg("No permission to add data.","error");
      }else if(pid == 3){
        set_msg("No permission to edit data.","error");
      }else{
        set_msg(pid,"error");
      }

    }
  });
}



function validate(){
  if($("#cus_id").val() == ""){
    set_msg("Please select customer.","error");
    $("#cus_id").focus();
    return false;
  }else if($("#act").val() ==""){
    set_msg("Please select action.","error");
    $("#act").focus();
    return false;
  }else if($("#officer").val() ==""){
    set_msg("Please select officer.","error");
    $("#officer").focus();
    return false;
  }else if($("#note").val() ==""){
    set_msg("Please type note.","error");
    $("#note").focus();
    return false;
  }else{
    return true;
  }
}

function set_delete(code){
  if(confirm("Are you sure delete "+code+"?")){
    loding();
    $.post("index.php/main/delete/m_customer_inquiries", {
      code : code
    }, function(res){
      loding();
      if(res == 1){
        delete_msg();
      }else{
        set_msg(res,"error");
      }
    }, "text");
  }
}

function set_edit(code){
  loding();
  $.post("index.php/main/get_data/m_customer_inquiries", {
    code :code
  }, function(res){
    loding();
    //alert(res[0].customer);
    $("#id").val(res[0].nno);
    $("#hid").val(res[0].nno);
    $("#cus_id").val(res[0].customer);
    $("#cus_name").val(res[0].name);
    $("#address").val(res[0].address1);
    $("#act").val(res[0].action);
    $("#act_des").val(res[0].action_des);
    $("#officer").val(res[0].officer);
    $("#officer_des").val(res[0].emp_name);
    $("#note").val(res[0].note);
    $("#amount").val(res[0].amount);
    $("#p_date").val(res[0].promiss_date);
    $("#s_date").val(res[0].salary_date);
  }, "json");
}