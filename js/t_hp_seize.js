var tc=pr_type=0;
$(document).ready(function () {
	
	$("#tabs").tabs(); 
	$("#tabs").tabs();
	$("#tabs2").tabs();
	$('#tabs3').tabs();
	$('#tabs4').tabs();
	$("#tgrid").tableScroll({height:90});
	$("#tgrid2").tableScroll({height:90});
	$("#tgrid3").tableScroll({height:40});
	$("#tgrid4").tableScroll({height:90});

	$("#id").keypress(function(e){
    if(e.keyCode == "13"){
      load_data($(this).val());
    }
  });

  $("#btnDelete").click(function(){
	  set_delete();
	});

	$("#btnPrint").click(function(){
	  $("#print_pdf").submit();
	});


	$("#agr_no").keypress(function(e){
		if(e.keyCode == 112){
			$("#pop_search").val();
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
		if(e.keyCode == 46){
			
		}
	});

	$("#rivert_person").keypress(function(e){
		if(e.keyCode == 112){
			$("#pop_search4").val();
			load_rvt_person();
			$("#serch_pop4").center();
			$("#blocker").css("display", "block");
			setTimeout("$('#pop_search4').focus()", 100);
		}
		$("#pop_search4").keyup(function(e){
			if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
				load_rvt_person();
			}
		}); 
		if(e.keyCode == 46){
			$("#rivert_person").val("");
			$("#rivert_person_des").val("");
		}
	});

	$("#store_code").keypress(function(e){
		if(e.keyCode == 112){
			$("#pop_search2").val();
			load_seize_stores();
			$("#serch_pop2").center();
			$("#blocker").css("display", "block");
			setTimeout("$('#pop_search2').focus()", 100);
		}
		$("#pop_search2").keyup(function(e){
			if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
				load_seize_stores();
			}
		}); 
		if(e.keyCode == 46){
			$("#store_code").val("");
			$("#store_des").val("");
		}
	});

	$("#officer").keypress(function(e){
		if(e.keyCode == 112){
			$("#pop_search6").val();
			load_officer();
			$("#serch_pop6").center();
			$("#blocker").css("display", "block");
			setTimeout("$('#pop_search6').focus()", 100);
		}
		$("#pop_search6").keyup(function(e){
			if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
				load_officer();
			}
		}); 
		if(e.keyCode == 46){
			$("#officer").val("");
			$("#officer_des").val("");
		}
	});

	$("#tgrid .cl1").dblclick(function(){
		set_cid($(this).children().find('input').eq(1).attr("id")); 
		settings_load_below_grid(scid);
	});

	$(".fo").keypress(function(e) {
		if(e.keyCode == 46){
			set_cid($(this).attr("id")); 
			clear_grid(scid);
		}
	});

	$("#btnExit1").click(function(event) {
		document.getElementById('light').style.display='none';
  	document.getElementById('fade').style.display='none';  
	});

	$('input[type=text]').blur(function() {
		set_cid($(this).attr("id")); 
		cal_values(scid);
	});

});


function load_agr_no(){
	$.post("index.php/main/load_data/t_hp_seize/load_agr_no", {
		search: $("#pop_search").val(),
	}, function (r) {
		$("#sr").html(r);
		settings_agr_no();
	}, "text");
}

function settings_agr_no(){
	$("#item_list .cl").click(function(){        
		$("#agr_no").val($(this).children().eq(4).html());
		$("#cus_id").val($(this).children().eq(5).html());
		$("#cus_des").val($(this).children().eq(6).html());
		$("#cus_add").val($(this).children().eq(7).html());
		$("#tel").val($(this).children().eq(8).html());
		$("#hp_no").val($(this).children().eq(9).html());
		$("#hp_date").val($(this).children().eq(10).html());
		$("#hp_ref_no").val($(this).children().eq(11).html());
		$("#loan_amt").val($(this).children().eq(12).html());
		$("#down_payment").val($(this).children().eq(13).html());
		$("#int_amt").val($(this).children().eq(14).html());
		$("#period").val($(this).children().eq(15).html());
		$("#rate").val($(this).children().eq(16).html());
		$("#doc_charges").val($(this).children().eq(17).html());
		$("#g1_address").val($(this).children().eq(18).html());
		$("#g1_name").val($(this).children().eq(19).html());
		$("#g1_tp_no").val($(this).children().eq(20).html());
		$("#g2_address").val($(this).children().eq(21).html());
		$("#g2_name").val($(this).children().eq(22).html());
		$("#g2_tp_no").val($(this).children().eq(23).html());
		$("#hp_store").val($(this).children().eq(24).html());
		$("#hp_storedes").val($(this).children().eq(25).html());
		load_receipt_details($(this).children().eq(4).html(),$(this).children().eq(9).html(),1);
		$("#pop_close").click(); 
	});    
}

function load_receipt_details(agr_no,nno,status){
	loding();
	var g=[];
	$.post("index.php/main/load_data/t_hp_seize/load_agr_receipt_details", {
		agr_no: agr_no,
		no:nno
	}, function (r) {
		loding();
		if(r.c!=2){
			var tbl="";
			for(var i=0; i<r.c.length; i++){
				tbl += "<tr style='background-color:#f2f2f2'>";
				tbl += "<td style='text-align:right;'>"+r.c[i].nno+"</td>";
				tbl += "<td style='text-align:right;'>"+r.c[i].ddate+"</td>";
				tbl += "<td style='text-align:right;'>"+r.c[i].paid_amount+"</td>";
				tbl += "</tr>";
			}
			$("#rcpt_details").html(tbl);
		}
		if(r.s!=2){
			var tbl="";
			for(var i=0; i<r.s.length; i++){
				tbl += "<tr style='background-color:#f2f2f2'>";
				tbl += "<td style='text-align:right;'>"+r.s[i].ins_no+"</td>";
				tbl += "<td style='text-align:right;'>"+r.s[i].due_date+"</td>";
				tbl += "<td style='text-align:right;'>"+m_round(r.s[i].ins_amount)+"</td>";
				tbl += "</tr>";
			}
			$("#ins_details").html(tbl);
		}
		if(status==1){
			if(r.items!=2){
				for(var i=0; i<r.items.length; i++){
					$("#itemcode_"+i).val(r.items[i].item_code);
					$("#itemdes_"+i).val(r.items[i].item_name);
					$("#btt_"+i).val(r.items[i].batch_no);
					$("#qty_"+i).val(r.items[i].qty);
					$("#price_"+i).val(r.items[i].price);
					$("#amt_"+i).val(r.items[i].amount);
					$("#discount_"+i).val(r.items[i].discount);
					$("#net_"+i).val(r.items[i].net_amount);
					$("#serial_"+i).val(r.items[i].serials);
					$("#is_free_"+i).val(r.items[i].is_free);
				}
			}
		}
	}, "json");
}

function settings_load_below_grid(x){

    if($("#itemcode_"+x).val() != ""){

    	var item_code =$("#itemcode_"+x).val();
     	var item_des  =$("#itemdes_"+x).val();
	    var batch 		=$("#btt_"+x).val();
	    var qty 			=$("#qty_"+x).val();
	    var price 		=$("#price_"+x).val();
	    var amount    =$("#amt_"+x).val();
	    var discount 	=$("#discount_"+x).val();
	    var net 			=$("#net_"+x).val();
	    var serial 		=$("#serial_"+x).val();
	    var is_free 	=$("#is_free_"+x).val();
	    

    for(var i=0; i<25 ;i++){      		
      if(item_code == "0" || item_code ==""){
    	}else{
      	if($("#0_"+i).val()==item_code){
        	return false;
      	}else if($("#0_"+i).val()==""){
        	if($("#df_is_serial").val()=='1'){
          	check_is_serial_item2(item_code,i);
        	}

	        $("#h1_"+i).val(item_code);
	        $("#0_"+i).val(item_code);
	        $("#itemdes1_"+i).val(item_des);
	        $("#btt1_"+i).val(batch);
	        $("#qty1_"+i).val(qty);
	        $("#price1_"+i).val(price);
	        $("#amt1_"+i).val(amount);
	        $("#discount1_"+i).val(discount);
	        $("#net1_"+i).val(net);
	        $("#serial1_"+i).val(serial);
	        $("#is_free1_"+i).val(is_free);
	        free_item(item_code);
	        break;		
	      }
    	}
  	}
  	}else{
    $("#h1_"+x).val("");
    $("#0_"+x).val("");
    $("#itemdes1_"+x).val("");
    $("#btt1_"+x).val(""); 
    $("#qty1_"+x).val(""); 
    $("#serial1_"+x).val(""); 
    $("#is_free1_"+x).val(""); 
    $("#price1_"+x).val(""); 
    $("#amt1_"+x).val(""); 
    $("#discount1_"+x).val(""); 
    $("#net1_"+x).val(""); 
  }
  cal_values(x);
}

function free_item(item){ 
	loding();
  $.post("index.php/main/load_data/t_hp_seize/get_free_item/",{
    item_code:item,
    b_date:$("#hp_date").val()  
  },function(res){  
  	loding();
    for(var y=1; y<26; y++){
      for(var x=0; x<res.free.length; x++){
        if(res.free[x].item==$("#itemcode_"+y).val()){       
          if($("#0_"+y).val() == "0" || $("#0_"+y).val() ==""){            
            $("#0_"+y).val($("#itemcode_"+y).val());
            $("#h1_"+i).val($("#h_"+i).val());
		        $("#0_"+i).val($("#itemcode_"+i).val());
		        $("#itemdes1_"+i).val($("#itemdes_"+i).val());
		        $("#btt1_"+i).val($("#btt_"+i).val());
		        $("#qty1_"+i).val($("#qty_"+i).val());
		        $("#price1_"+i).val($("#price_"+i).val());
		        $("#amt1_"+i).val($("#amt_"+i).val());
		        $("#discount1_"+i).val($("#discount_"+i).val());
		        $("#net1_"+i).val($("#net_"+i).val());
		        $("#serial1_"+i).val($("#serial_"+i).val());
		        $("#is_free1_"+i).val($("#is_free_"+i).val());
            check_is_serial_item2($("#itemcode_"+y).val(),y);
          }
        }
      }
    }          
  },"json");
}

function clear_grid(x){
	$("#h1_"+x).val("");
  $("#0_"+x).val("");
  $("#itemdes1_"+x).val("");
  $("#btt1_"+x).val(""); 
  $("#qty1_"+x).val(""); 
  $("#serial1_"+x).val(""); 
  $("#is_free1_"+x).val(""); 
  $("#price1_"+x).val(""); 
  $("#amt1_"+x).val(""); 
  $("#discount1_"+x).val(""); 
  $("#net1_"+x).val("");
  $("#btn_"+x).css("display","none");  
}

function cal_values(t){
	var qty 	= parseFloat($("#qty1_"+t).val());
	var price = parseFloat($("#price1_"+t).val());
	var dis 	= parseFloat($("#discount1_"+t).val());
	var rvt_chg = parseFloat($("#rt_chargers").val());
	var amount=net_amount=total=parseFloat(0);

	if(isNaN(qty)){qty=0;}
	if(isNaN(price)){price=0;}
	if(isNaN(dis)){dis=0;}
	if(isNaN(rvt_chg)){rvt_chg=0;}

	amount  = qty * price;
	net_amount = amount - (dis * qty);

	if($("#0_"+t).val()!=""){
		$("#amt1_"+t).val(m_round(amount));
		$("#net1_"+t).val(m_round(net_amount));
	}

	$(".cnt").each(function(e){
		if($("#net1_"+e).val() > 0){
			total+=parseFloat($("#net1_"+e).val());
		}
	});
	$("#tot_amount").val(m_round(total+rvt_chg));
}

function load_rvt_person(){
	$.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_employee",
    field:"code",
    field2:"name",
    preview2:"Employee Name",
    search : $("#pop_search4").val() 
  }, function(r){
    $("#sr4").html(r);
    settings_rvt_emp();
  }, "text");
}

function settings_rvt_emp(){
  $("#item_list .cl").click(function(){        
  	$("#rivert_person").val($(this).children().eq(0).html());
    $("#rivert_person_des").val($(this).children().eq(1).html());
    $("#pop_close4").click(); 
  })    
}

function load_seize_stores(){
	$.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_stores",
    field:"code",
    field2:"description",
    preview2:"Description",
    add_query:" AND cl='"+$("#cluster").val()+"' AND bc='"+$("#branch").val()+"' ",
    search : $("#pop_search2").val() 
  }, function(r){
    $("#sr2").html(r);
    settings_seize();
  }, "text");
}

function settings_seize(){
  $("#item_list .cl").click(function(){        
  	$("#store_code").val($(this).children().eq(0).html());
    $("#store_des").val($(this).children().eq(1).html());
    $("#pop_close2").click(); 
  })    
}

function load_officer(){
	$.post("index.php/main/load_data/utility/f1_selection_list", {
    data_tbl:"m_employee",
    field:"code",
    field2:"name",
    preview2:"Employee Name",
    search : $("#pop_search6").val() 
  }, function(r){
    $("#sr6").html(r);
    settings_officer();
  }, "text");
}

function settings_officer(){
  $("#item_list .cl").click(function(){        
  	$("#officer").val($(this).children().eq(0).html());
    $("#officer_des").val($(this).children().eq(1).html());
    $("#pop_close6").click(); 
  })    
}

function validate(){
	if($("#agr_no").val()==""){
	  set_msg("Please Select Agreenment number","error");
	  $("#agr_no").focus();
	  return false;
	}else if($("#rivert_person").val()==""){
		set_msg("Please Select rivert person","error");
	  $("#rivert_person").focus();
	  return false;
	}else if($("#store_code").val()==""){
		set_msg("Please select Seize store","error");
	  $("#store_code").focus();
	  return false;
	}else if($("#officer").val()==""){
		set_msg("Please select collection officer","error");
	  $("#officer").focus();
	  return false;
	}else if(parseFloat($("#tot_amount").val()) <= 0){
		set_msg("Total amount should be greater than 0","error");
	  return false;
	}else{
		return true;
	}
}


function save(){
  var frm = $('#form_');
  $("#qno").val($("#id").val());
  loding();
  $.ajax({
    type: frm.attr('method'),
    url: frm.attr('action'),
    data: frm.serialize(),
    success: function (pid){
      loding();
      if(pid==1){
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

function load_data(id){
	var g=[];
  loding();
  $.post("index.php/main/get_data/t_hp_seize/", {
      id: id
  }, function(r){
    loding();
    if(r.sum=="2"){
      set_msg("No records");
    }else{
    	$("#id").attr("readonly",true);
      $("#id").val(r.sum[0].nno);
      $("#qno").val(r.sum[0].nno);
      $("#hid").val(r.sum[0].nno);
      $("#agr_no").val(r.sum[0].agr_no);
      $("#cus_id").val(r.sum[0].customer);
      $("#hp_no").val(r.sum[0].hp_nno);
      $("#rivert_person").val(r.sum[0].rivert_person);
      $("#rivert_person_des").val(r.sum[0].rivertp_name);
      $("#note").val(r.sum[0].note);
      $("#store_code").val(r.sum[0].stores);
      $("#store_des").val(r.sum[0].store_name);
      $("#officer").val(r.sum[0].collection_officer);
      $("#officer_des").val(r.sum[0].col_name);
      $("#tot_amount").val(r.sum[0].net_amount);
      $("#rt_chargers").val(r.sum[0].revert_chargers);
			$("#cus_des").val(r.hp_sum[0].cus_name);
			$("#cus_add").val(r.hp_sum[0].cus_address);
			$("#tel").val(r.hp_sum[0].tp);
			$("#hp_date").val(r.hp_sum[0].ddate);
			$("#hp_ref_no").val(r.hp_sum[0].ref_no);
			$("#loan_amt").val(r.hp_sum[0].net_amount);
			$("#down_payment").val(r.hp_sum[0].down_payment);
			$("#int_amt").val(r.hp_sum[0].installment_amount);
			$("#period").val(r.hp_sum[0].no_of_installments);
			$("#rate").val(r.hp_sum[0].interest_rate);
			$("#doc_charges").val(r.hp_sum[0].document_charges);
			$("#g1_address").val(r.hp_sum[0].g1_address);
			$("#g1_name").val(r.hp_sum[0].gurantor1_name);
			$("#g1_tp_no").val(r.hp_sum[0].g1_tp);			
			$("#g2_address").val(r.hp_sum[0].g2_address);
			$("#g2_name").val(r.hp_sum[0].gurantor2_name);
			$("#g2_tp_no").val(r.hp_sum[0].g2_tp);
			$("#hp_store").val(r.hp_sum[0].store_id);
			$("#hp_storedes").val(r.hp_sum[0].store_name);

			load_receipt_details(r.sum[0].agr_no,r.sum[0].hp_nno,2);

			for(var x=0; x<r.det.length; x++){
				$("#0_"+x).val(r.det[x].item_code);
				$("#itemdes1_"+x).val(r.det[x].item_name);
				$("#btt1_"+x).val(r.det[x].batch);
				$("#qty1_"+x).val(r.det[x].qty);
				$("#price1_"+x).val(r.det[x].price);
				$("#amt1_"+x).val(r.det[x].amount);
				$("#discount1_"+x).val(r.det[x].discount);
				$("#net1_"+x).val(r.det[x].net_amount);
				$("#serial1_"+x).val(r.det[x].serials);
				check_is_serial_item2(r.det[x].item_code,x);

				if($("#df_is_serial").val()=='1'){
          check_is_serial_item2(r.det[x].item_code,x);
          $("#numofserial_"+x).val(r.det[x].qty);
          for(var a=0;a<r.serial.length;a++){
            if(r.det[x].item_code==r.serial[a].item){
              g.push(r.serial[a].serial_no);
              $("#all_serial_"+x).val(g);
            }   
          }
          g=[];                 
        }
			}
   
      if(r.sum[0].is_cancel==1){
        set_msg("Record deleted ! ! ! ");
        $("#btnDelete").attr("disabled", "disabled");
        $("#btnSave").attr("disabled", "disabled");
        $("#mframe").css("background-image", "url('img/cancel.png')");
      }
    } 
               
  }, "json");
}

function set_delete(){
  var id = $("#hid").val();
  if(id != 0){
    if(confirm("Are You Sure To Delete This HP Seize ["+$("#hid").val()+"]? ")){
      $.post("index.php/main/delete/t_hp_seize", {
        id:id,
        hp_no:$("#hp_no").val()
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