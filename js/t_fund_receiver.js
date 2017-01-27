$(document).ready(function () {
	
	$("#tabs").tabs();

  $("#id").keypress(function(e){
    if(e.keyCode == "13"){
      load_data($(this).val());
      $(this).attr("readonly",true);
    }
  });

  $("#btnDelete").click(function(){
    set_delete();
  });

  $("#btnReset").click(function(){
    location.href="";
  });

	$("#received_by").keypress(function(e){
	 	if(e.keyCode == 112){
	 		$("#pop_search").val($("#received_by").val());
	 		load_received_by();
	 		$("#serch_pop").center();
    	$("#blocker").css("display", "block");
    	setTimeout("$('#pop_search').focus()", 100);
	 	}
	 	$("#pop_search").keyup(function(e){
     	if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_received_by();
     	}
    }); 
    if(e.keyCode == 46){
     	$("#received_by").val("");
     	$("#received_by_des").val("");
    }
	});

  $("#fr_branch").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search4").val($("#fr_branch").val());
      load_branch();
      $("#serch_pop4").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search4').focus()", 100);
    }
    $("#pop_search4").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
         load_branch();
      }
    }); 
    if(e.keyCode == 46){
      $("#fr_branch").val("");
      $("#fr_branch_des").val("");
    }
  });

  $("#transfer_no").keypress(function(e){
    if($("#fr_branch").val()!=""){
      if(e.keyCode == 112){
        $("#pop_search11").val($("#transfer_no").val());
        load_transfer_no();
        $("#serch_pop11").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search11').focus()", 100);
      }
      $("#pop_search11").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
           load_transfer_no();
        }
      }); 
      if(e.keyCode == 46){
        $("#transfer_no").val("");
      }
    }else{
      set_msg("Please Select from branch");
    }
  });
});

function load_received_by(){
	$.post("index.php/main/load_data/utility/f1_selection_list_emp", {
        search : $("#pop_search").val() 
    }, function(r){
        $("#sr").html(r);
        settings_received_by();            
    }, "text");
}

function settings_received_by(){
    $("#item_list .cl").click(function(){        
        $("#received_by").val($(this).children().eq(0).html());
        $("#received_by_des").val($(this).children().eq(1).html());
        $("#pop_close").click();                
    })    
}

function load_branch(){
  $.post("index.php/main/load_data/t_fund_receiver/load_branch", {
    search : $("#pop_search4").val() 
  }, function(r){
      $("#sr4").html(r);
      settings_load_branch();            
  }, "text");
}

function settings_load_branch(){
    $("#item_list .cl").click(function(){        
        $("#fr_branch").val($(this).children().eq(0).html());
        $("#fr_branch_des").val($(this).children().eq(1).html());
        $("#fr_cl").val($(this).children().eq(2).html());
        $("#pop_close4").click();                
    })    
}

function load_transfer_no(){
  $.post("index.php/main/load_data/t_fund_receiver/transfer_no", {
    search : $("#pop_search11").val(),
    s_cl : $("#fr_cl").val(),
    s_bc : $("#fr_branch").val()
  }, function(r){
      $("#sr11").html(r);
      settings_trans_no();            
  }, "text");
}

function settings_trans_no(){
    $("#item_list .cl").click(function(){        
        $("#transfer_no").val($(this).children().eq(0).html());
        $("#tr_acc").val($(this).children().eq(3).html());
        $("#tr_acc_des").val($(this).children().eq(4).html());
        $("#cashier_code").val($(this).children().eq(5).html());
        $("#cashier_des").val($(this).children().eq(6).html());
        $("#hand_ot").val($(this).children().eq(7).html());
        $("#hand_ot_des").val($(this).children().eq(8).html());
        $("#cash_amount").val($(this).children().eq(9).html());
        $("#pop_close11").click();                
    })    
}



function validate(){
  if($("#fr_branch").val()==""){
    set_msg("Please add item code");
    return false;
  }else if($("#transfer_no").val()==""){
    set_msg("Please select transfer no");
    return false;
  }else if($("#tr_acc").val()==""){
    set_msg("Please enter cash tansit account");
    return false;
  }else if($("#cashier_code").val()==""){
    set_msg("Please enter cashier officer");
    return false;
  }else if($("#hand_ot").val()==""){
    set_msg("Please enter hand over officer");
    return false;
  }else if($("#cash_amount").val()==""){
    set_msg("Please enter amount");
    return false;
  }else if($("#received_by").val()==""){
    set_msg("Please select received officer");
    return false;
  }else{
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
        if(confirm("Save Completed, Do You Want A print?")){
          if($("#is_prnt").val()==1){
            $("#print_pdf").submit();
          }
              location.href="";
          }else{
              location.href="";
          }
        }else{
          loding();
          set_msg(pid,"error");
        }
      }
  });
}


function load_data(id){
  loding();
  $.post("index.php/main/get_data/t_fund_receiver/", {
      id: id
  }, function(r){
    if(r=="2"){
      set_msg("No records");
    }else{
      $("#id").val(r[0].nno);
      $("#hid").val(r[0].nno);
      $("#date").val(r[0].ddate);
      $("#ref_no").val(r[0].ref_no);
      $("#fr_cl").val(r[0].from_cl);
      $("#fr_branch").val(r[0].from_bc);
      $("#transfer_no").val(r[0].transfer_no);
      $("#tr_acc").val(r[0].cash_transit_acc_code);
      $("#tr_acc_des").val(r[0].description);
      $("#cashier_code").val(r[0].cashier);
      $("#cashier_des").val(r[0].cashier_name);
      $("#hand_ot").val(r[0].hand_over);
      $("#hand_ot_des").val(r[0].hand_des);
      $("#cash_amount").val(r[0].cash_amount);
      $("#received_by").val(r[0].received_by);
      $("#received_by_des").val(r[0].receive_name);
      $("#note").val(r[0].note);
      $("#fr_branch_des").val(r[0].b_name);

      $("#transfer_no").attr("readonly",true);
      if(r[0].is_cancel==1){
        set_msg("Record deleted ! ! ! ");
        $("#btnDelete").attr("disabled", "disabled");
        $("#btnSave").attr("disabled", "disabled");
        $("#mframe").css("background-image", "url('img/cancel.png')");
      }
    } 
    loding();           
  }, "json");
}

function set_delete(){
  var id = $("#hid").val();
  if(id != 0){
    if(confirm("Are you sure to delete this funnd receive no ["+$("#hid").val()+"]? ")){
      $.post("index.php/main/delete/t_fund_receiver", {
        id:id,
        fr_cl:$("#fr_cl").val(),
        fr_branch:$("#fr_branch").val(),
        transfer_no:$("#transfer_no").val()
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