$(document).ready(function(){

	$("#tgrid").tableScroll({height:230});


	$("#customer").keypress(function(e) {
		if(e.keyCode == 112){
			$("#pop_search").val($("#customer").val());
			load_customer();
			$("#serch_pop").center();
			$("#blocker").css("display", "block");
			setTimeout("$('#pop_search').focus()", 100);
		}
		$("#pop_search").keyup(function(e){
			if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
				load_customer();
			}
		}); 
		if(e.keyCode == 46){
			$("#customer").val("");
			$("#customer_id").val("");
			$("#Address").val("");
		}
	});

	$("#driver_id").keypress(function(e){
		if(e.keyCode == 112){
			$("#pop_search2").val();
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

		if(e.keyCode == 46){
			$("#driver_id").val("");
			$("#driver").val("");
		}
	});


	$("#helper_id").keypress(function(e){
		if(e.keyCode == 112){
			$("#pop_search12").val();
			load_helper();
			$("#serch_pop12").center();
			$("#blocker").css("display", "block");
			setTimeout("$('#pop_search12').focus()", 100);
		}

		$("#pop_search2").keyup(function(e){            
			if(e.keyCode != 13 && e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 112 ) { 
				load_helper();
			}
		}); 

		if(e.keyCode == 46){
			$("#helper_id").val("");
			$("#helper").val("");
		}
	});

	$(".qty").keyup(function(){
		set_cid($(this).attr("id"));
		cal_tot_qty();
		var balance = parseFloat($("#4_"+scid).val());
		var qty = parseFloat($("#5_"+scid).val());

		if(qty>balance){
			alert("Quantity Should Be Less Than Balance");
			$("#5_"+scid).val("");
		}
	});

	$("#btnDelete").click(function(){
		set_delete($("#id").val());
	});

	$("#id").keypress(function(e){
		if(e.keyCode == 13){
			$("#id").attr("readonly","readonly")  
			load_data($(this).val());
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
});

function validate(){
	if($("#customer").val()==""){
		set_msg("Please select customer");
		return false;
	}else if($("#memo").val()==""){
		set_msg("Please enter note");
		return false;
	}else if($("#driver_id").val()==""){
		set_msg("Please select driver");
		return false;
	}else if($("#helper_id").val()==""){
		set_msg("Please select helper");
		return false;
	}else if(parseFloat($("#tot_qty").val())<=0){
		set_msg("Total delivery quantity should be greater than 0");
		return false;
	}else{
		return true;
	}   
}

function cal_tot_qty(){
	var qty = dqty = parseFloat(0);
	for(var x=0; x<25; x++){
		if($("#5_"+x).val()!=""){
			qty+=parseFloat($("#5_"+x).val());
		}
		if($("#6_"+x).val()!=""){
			dqty+=parseFloat($("#6_"+x).val());
		}
	}
	$("#tot_qty").val(qty);
	$("#tot_del_qty").val(dqty);
}

function load_customer(){
	$.post("index.php/main/load_data/utility/f1_selection_list_customer", {
		data_tbl      : "m_customer",
		field         : "code",
		field2        : "name",
		field3        : "nic",
		field4:"tp",
		field_address : "field_address",
		preview_name1 : "Customer ID",
		preview_name2 : "Customer Name",
		preview_name3 : "Customer NIC",
		search : $("#pop_search").val() 
	}, function(r){
		$("#sr").html("");
		$("#sr").html(r);
		settings_customer();            
	}, "text");
}

function settings_customer(){
	$("#item_list .cl").click(function(){        
		$("#customer").val($(this).children().eq(0).html());
		$("#customer_id").val($(this).children().eq(1).html());
		$("#Address").val($(this).children().eq(3).html());
		load_pending_delevery();
		$("#blocker").css("display","none");
		$("#pop_close").click();                
	})    
}

function load_pending_delevery(){
	clear_grid();
	loding();  
	$.post("index.php/main/load_data/t_delevery_note/load_delevery_data", {
		customer_id:$("#customer").val()
	}, function(r){
		loding();
		var tot_d_qty=b_qty=parseFloat(0);
		if(r!=2){  
			for(var i=0; i<r.det.length;i++){
				$("#0_"+i).val(r.det[i].t_name);
				$("#invtype_"+i).val(r.det[i].t_code);
				$("#n_"+i).val(r.det[i].ddate);
				$("#1_"+i).val(r.det[i].sub_trans_no);
				$("#2_"+i).val(r.det[i].item);
				$("#3_"+i).val(r.det[i].item_name);
				$("#4_"+i).val(r.det[i].balance);
				
				$("#6_"+i).val(r.det[i].deleverd_qty);
				tot_d_qty+=parseFloat(r.det[i].deleverd_qty);
				b_qty+=parseFloat(r.det[i].balance);
			}
			//$("#tot_qty").val(b_qty);
			$("#tot_del_qty").val(tot_d_qty);
		}else{
			set_msg("This customer hasn't delevery Note");
		}
	}, "json");
}


function clear_grid(){
	for(var i=0; i<100;i++){
		$("#0_"+i).val("");
		$("#n_"+i).val("");
		$("#1_"+i).val("");
		$("#2_"+i).val("");
		$("#3_"+i).val("");
		$("#4_"+i).val("");
		$("#5_"+i).val("");
		$("#6_"+i).val("");
		$("#7_"+i).val("");
	}   
} 

function load_driver(){
	$.post("index.php/main/load_data/utility/f1_selection_list_emp", {
		filter_emp_cat:"driver",
		search : $("#pop_search2").val() 
	}, function(r){
		$("#sr2").html("");
		$("#sr2").html(r);
		settings_driver();            
	}, "text");
}


function settings_driver(){
	$("#item_list .cl").click(function(){        
		$("#driver_id").val($(this).children().eq(0).html());
		$("#driver").val($(this).children().eq(1).html());
		$("#pop_close2").click();                
	})    
}

function load_helper(){
	$.post("index.php/main/load_data/utility/f1_selection_list_emp", {
		filter_emp_cat:"helper",
		search : $("#pop_search12").val() 
	}, function(r){
		$("#sr12").html("");
		$("#sr12").html(r);
		settings_helper();            
	}, "text");
}


function settings_helper(){
	$("#item_list .cl").click(function(){        
		$("#helper_id").val($(this).children().eq(0).html());
		$("#helper").val($(this).children().eq(1).html());
		$("#pop_close12").click();                
	})    
}


function save(){

	var frm = $('#form_');
	loding();
	$.ajax({
		type: frm.attr('method'),
		url: frm.attr('action'),
		data: frm.serialize(),
		success: function (pid){
			var sid=pid.split('@');
			if(sid[0] == 1){
				$("#qno").val(sid[1]);
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

function set_delete(id){
	if(confirm("Are you sure delete delivery note no "+id+"?")){
		loding();
		$.post("index.php/main/delete/t_delevery_note", {
			trans_no : id
		}, function(res){
			if(res == 1){
				delete_msg();
			}else{
				set_msg("Item deleting fail.");
			}
			loding();
		}, "text");
	}
}

function load_data(id){
	clear_grid();
	loding();
	$.post("index.php/main/get_data/t_delevery_note/", {
		no: id
	}, function(r){
		if(r=="2"){
			set_msg("No records");
		}else{
			$("#hid").val(id);  
			$("#qno").val(id);   

			$("#date").val(r.sum[0].ddate);
			$("#ref_no").val(r.sum[0].ref_no);
			$("#customer").val(r.sum[0].customer);
			$("#customer_id").val(r.sum[0].cus_name);
			$("#Address").val(r.sum[0].cus_address);
			$("#memo").val(r.sum[0].note);
			$("#vehicle_no").val(r.sum[0].vehicle);
			$("#driver_id").val(r.sum[0].driver);
			$("#driver").val(r.sum[0].driver_name);
			$("#helper_id").val(r.sum[0].helper);
			$("#helper").val(r.sum[0].helper_name);
			
			if(r.sum[0].is_cancel==1){
				$("#form_").css("background-image", "url('img/cancel.png')");
				$("#btnDelete").attr("disabled", true);
				$("#btnSave").attr("disabled", true);
			}
			
			for(var i=0; i<r.det.length;i++){
				$("#0_"+i).val(r.det[i].t_des);
				$("#invtype_"+i).val(r.det[i].inv_type);
				$("#n_"+i).val(r.det[i].inv_date);
				$("#1_"+i).val(r.det[i].inv_no);
				$("#2_"+i).val(r.det[i].item);
				$("#3_"+i).val(r.det[i].item_name);
				$("#4_"+i).val(r.det[i].balance);
				$("#5_"+i).val(r.det[i].qty);
				$("#6_"+i).val(r.det[i].deliverd_qty);
			}
		}
		loding();
		cal_tot_qty();
	}, "json");
}
