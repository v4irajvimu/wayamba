$(document).ready(function () {
	
	$("#tabs").tabs();

	$("#cashier_code").keypress(function(e){
	 	if(e.keyCode == 112){
	 		$("#pop_search").val($("#cashier_code").val());
	 		load_cashier();
	 	  $("#serch_pop").center();
      $("#blocker").css("display", "block");
     	setTimeout("$('#pop_search').focus()", 100);
	 	}
	 	$("#pop_search").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_cashier();
      }
    }); 
		if(e.keyCode == 46){
    	$("#cashier_code").val("");
    	$("#cashier_des").val("");
		}
	});

  $("#id").keypress(function(e){
    if(e.keyCode==13){
      load_data($(this).val());
    }
  });

  $("#btnDelete").click(function(){
    set_delete();
  });

  $("#btnReset").click(function(){
    location.href="";
  });

  $("#btnPrint").click(function(){
    $("#print_pdf").submit();
  });

  $("#to_cl").keypress(function(e){
    if(e.keyCode == 112){
      $("#pop_search12").val($("#to_cl").val());
      load_cluster();
      $("#serch_pop12").center();
      $("#blocker").css("display", "block");
      setTimeout("$('#pop_search12').focus()", 100);
    }
    $("#pop_search12").keyup(function(e){
      if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
        load_cluster();
      }
    }); 
    if(e.keyCode == 46){
      $("#to_cl").val("");
      $("#to_cl_des").val("");
    }
  });

  $("#to_branch").keypress(function(e){
    if($("#to_cl").val()!=""){
      if(e.keyCode == 112){
        $("#pop_search13").val($("#to_branch").val());
        load_tbranch();
        $("#serch_pop13").center();
        $("#blocker").css("display", "block");
        setTimeout("$('#pop_search13').focus()", 100);
      }
      $("#pop_search13").keyup(function(e){
        if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
          load_tbranch();
        }
      });
    }else{
      set_msg("Please select cluster");
    } 
    if(e.keyCode == 46){
      $("#to_branch").val("");
      $("#to_branch_des").val("");
    }
  });

	$("#hand_ot").keypress(function(e){
	 	if(e.keyCode == 112){
	 		$("#pop_search2").val($("#hand_ot").val());
	 		load_hand_ot();
	 		$("#serch_pop2").center();
          	$("#blocker").css("display", "block");
          	setTimeout("$('#pop_search2').focus()", 100);
	 	}
	 		$("#pop_search2").keyup(function(e){
          	if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
               load_hand_ot();
          	}
      	}); 
      		if(e.keyCode == 46){
          	$("#hand_ot").val("");
          	$("#hand_ot_des").val("");
      		}
	 	});

	$("#transfer_am").keyup(function(e){
		calculation();
	});

	$("#cash_bk").keypress(function(e){
	 	if(e.keyCode == 112){
	 		$("#pop_search10").val($("#cash_bk").val());
	 		load_cash_book();
	 		$("#serch_pop10").center();
          	$("#blocker").css("display", "block");
          	setTimeout("$('#pop_search10').focus()", 100);
	 	}
	 		$("#pop_search10").keyup(function(e){
          	if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
               load_cash_book();
          	}
      	}); 
      		if(e.keyCode == 46){
          	$("#cash_bk").val("");
          	$("#cash_bk_des").val("");
      		}
	 	});

	cash_bk_bal($("#cash_bk").val());
	calculation();

});

function load_cashier(){
	$.post("index.php/main/load_data/utility/f1_selection_list_emp", {
        
        search : $("#pop_search").val() 
    }, function(r){
        $("#sr").html(r);
        settings_cashier();            
    }, "text");
}

function settings_cashier(){
    $("#item_list .cl").click(function(){        
        $("#cashier_code").val($(this).children().eq(0).html());
        $("#cashier_des").val($(this).children().eq(1).html());
        $("#pop_close").click();                
    })    
}

function load_hand_ot(){
	$.post("index.php/main/load_data/utility/f1_selection_list_emp", {
        
        search : $("#pop_search2").val() 
    }, function(r){
        $("#sr2").html(r);
        settings_hand_ot();            
    }, "text");
}

function settings_hand_ot(){
    $("#item_list .cl").click(function(){        
        $("#hand_ot").val($(this).children().eq(0).html());
        $("#hand_ot_des").val($(this).children().eq(1).html());
        $("#pop_close2").click();                
    })    
}

function load_cash_book(){
	$.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_default_account",
      field:"acc_code",
      field2:"description",
      preview2:"Code",
      search : $("#pop_search10").val() 
  }, function(r){
      $("#sr10").html(r);
      settings_cash_bk();      
  }, "text");
}

function settings_cash_bk(){
    $("#item_list .cl").click(function(){        
        $("#cash_bk").val($(this).children().eq(0).html());
        $("#cash_bk_des").val($(this).children().eq(1).html());
        cash_bk_bal($(this).children().eq(0).html());
        $("#pop_close10").click();                
    })    
}

function load_cluster(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_cluster",
      field:"code",
      field2:"description",
      preview2:"Name",
      search : $("#pop_search12").val() 
  }, function(r){
      $("#sr12").html(r);
      settings_cluster();      
  }, "text");
}

function settings_cluster(){
  $("#item_list .cl").click(function(){        
      $("#to_cl").val($(this).children().eq(0).html());
      $("#to_cl_des").val($(this).children().eq(1).html());
      $("#pop_close12").click();                
  })    
}

function load_tbranch(){
  $.post("index.php/main/load_data/utility/f1_selection_list", {
      data_tbl:"m_branch",
      field:"bc",
      field2:"name",
      preview2:"Name",
      add_query:" AND bc != '"+$("#fr_branch").val()+"' AND cl='"+$('#to_cl').val()+"'",
      search : $("#pop_search13").val() 
  }, function(r){
      $("#sr13").html(r);
      settings_tbranch();      
  }, "text");
}

function settings_tbranch(){
  $("#item_list .cl").click(function(){        
      $("#to_branch").val($(this).children().eq(0).html());
      $("#to_branch_des").val($(this).children().eq(1).html());
      $("#pop_close13").click();                
  })    
}


function cash_bk_bal(acc_code){
	$.post("index.php/main/load_data/t_fund_transfer/cash_bk_bal", {
      acc_code:acc_code
  }, function(r){
         $("#cash_bb").val(m_round(r));
  }, "text");
}

function calculation(){
		var cash_bk_bal=$('#cash_bb').val();
		var tr_amount=$('#transfer_am').val();

		//var ccb=parseFloat(cash_bk_bal)+parseFloat(tr_amount);
    var ccb=parseFloat(cash_bk_bal)-parseFloat(tr_amount);
		if(isNaN(ccb)){
			$("#cc_bal").val("0.00");
		}else{
		$("#cc_bal").val(m_round(ccb));
		}
}

function validate(){
  return true;
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
  $.post("index.php/main/get_data/t_fund_transfer/", {
      id: id
  }, function(r){
    if(r=="2"){
      set_msg("No records");
    }else{
      $("#id").attr("readonly",true);
      $("#id").val(r[0].nno);
      $("#hid").val(r[0].nno);
      $("#date").val(r[0].ddate);
      $("#ref_no").val(r[0].ref_no);
      $("#to_cl").val(r[0].sub_cl);
      $("#to_cl_des").val(r[0].cl_name);
      $("#to_branch").val(r[0].sub_bc);
      $("#to_branch_des").val(r[0].b_name);
      $("#tr_acc").val(r[0].cash_transit_acc_code);
      $("#tr_acc_des").val(r[0].tansit_des);
      $("#cash_bk").val(r[0].cash_book_acc_code);
      $("#cash_bk_des").val(r[0].cb_des);
      $("#cashier_code").val(r[0].cashier);
      $("#cashier_des").val(r[0].c_name);
      $("#hand_ot").val(r[0].hand_over);
      $("#hand_ot_des").val(r[0].h_name);
      $("#cash_bb").val(r[0].cash_book_bal);
      $("#transfer_am").val(r[0].transfer_amount);
      $("#cc_bal").val(r[0].cur_cashier_bal);
     
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
    if(confirm("Are you sure to delete this funnd transfer no ["+$("#hid").val()+"]? ")){
      $.post("index.php/main/delete/t_fund_transfer", {
        id:id,
        f_bc:$("#fr_branch_des").val()
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