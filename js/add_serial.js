$(document).ready(function(){
	$("#add_serials").click(function() {
		$("#light_serial").css("display","block");
		$("#fade").css("display","block");
		$("#type_0").focus();
	});

	$("#sbtn_exit").click(function(){
		$("#light_serial").css("display","none");
		$("#fade").css("display","none");
	});

	$("#sbtn_save").click(function(){
		$("#light_serial").css("display","none");
		$("#fade").css("display","none");
		add_to_txt();
	});


	$(document).on('keypress', '.sr_no', function(e){
		if(e.keyCode=="13"){
			set_serial_cid($(this).attr("id"));
			var sr_txt_count=0;
			var sr_txt_count2=-1;
			$(".sr_no").each(function(){
				sr_txt_count++;
				sr_txt_count2++;
			})
			if(isNaN(sr_txt_count)){sr_txt_count=0}
				var sr_scid=sr_txt_count2;
			var sscid = parseInt(s_scid)+parseInt(1);
			if(sr_txt_count%4==0){
				var sr_b=sr_txt_count-1;
				if($("#type_"+sr_b).val()!=""){
					var sr_tbl="";
					sr_tbl ="<tr>";
					sr_tbl +="<td><input type='text' id='type_"+parseInt(sr_scid+1)+"' class='input_txt sr_no' placeholder='Serial No' style='width:150px;' /></td>";
					sr_tbl +="<td><input type='text' id='type_"+parseInt(sr_scid+2)+"' class='input_txt sr_no' placeholder='Serial No' style='width:150px;' /></td>";
					sr_tbl +="<td><input type='text' id='type_"+parseInt(sr_scid+3)+"' class='input_txt sr_no' placeholder='Serial No' style='width:150px;' /></td>";
					sr_tbl +="<td><input type='text' id='type_"+parseInt(sr_scid+4)+"' class='input_txt sr_no' placeholder='Serial No' style='width:150px;' /></td>";
					sr_tbl +="<tr>";
					$("#serial_ttbl").append(sr_tbl)
					$("#type_"+parseInt(sr_scid+1)).focus();
				}
			}
			$("#type_"+sscid).focus();
		}
	});
});


function set_serial_cid(id){
	id = id.split('_');
	s_fcid = id[0];
	s_scid = id[1];
}

function add_to_txt(){
	var serial_arry = [];
	$(".sr_no").each(function(e){
		if($("#type_"+e).val()!=""){
			serial_arry.push($("#type_"+e).val());
		}
	});
	var arrDuplicate = [];
	for (var i = 0; i < serial_arry.length - 1; i++) {
	    if (serial_arry[i + 1] == serial_arry[i]) {
	        arrDuplicate.push(serial_arry[i]);
	    }
	}

	if(arrDuplicate.length===0){
		$("#selected_serials").val(serial_arry);
		get_item_details();
	}else{
		alert("This Serial Numbers Duplicate : "+arrDuplicate);
	}
}

function get_item_details(){
	loding();
	$.post("index.php/main/load_data/add_serial/serial_item_detials", {
		data:$("#selected_serials").val(),
		trans_code:$("#transCode").val(),
		cl:$("#hid_cl").val(),
		bc:$("#hid_bc").val(),
		stores :$(".store11").val(),
		v_stores :$("#v_store").val(),
		type :$("#types").val(),  
		type_no:$("#inv_no").val()   
	}, function(r){
		loding();
		if(r.invalid!=""){
			alert("Invalid Serial Numbers "+r.invalid);
		}else{
			if($("#chk_find").val()=="1"){
				var yyy=0;
				for(var x=0; x<r.all.length; x++){							
					for(var y=0; y<25; y++){
						//if($(".sitem_"+y).val()!=""){
							if(r.all[x][0].item==$(".sitem_"+y).val() && r.all[x][0].batch_no == $(".btt_"+y).val() && $("#isaddse_"+y).val()!="1"){
								var qt_cnt = parseInt($(".qtycl"+y).val());
								var a_serial = $("#all_serial_"+y).val();
								if(a_serial=="0"){
									var n_serial = r.all[x][0].serial_no;
								}else{
									var n_serial = a_serial+','+r.all[x][0].serial_no;
								}
								if(isNaN(qt_cnt)){qt_cnt=0;}
								var new_qty = qt_cnt+1;
								$(".btt_"+y).val(r.all[x][0].batch_no);
								$(".icst_"+y).val(r.all[x][0].purchase_price);
								$(".imin_"+y).val(r.all[x][0].min_price);
								
								if($("#transCode").val()=="5" || $("#transCode").val()=="4"){
									if(is_main_branch=="1"){
										$(".imax_"+y).val(r.all[x][0].min_price);
									}else{
										$(".imax_"+y).val(r.all[x][0].max_price);
									}
								}else{
									$(".imax_"+y).val(r.all[x][0].max_price);
								}

								$(".iqry_"+y).val(r.all[x][0].cur_qty);
								$("#all_serial_"+y).val(n_serial);
								$(".qtycl"+y).val(new_qty);
								$("#numofserial_"+y).val(new_qty);
								var tot= parseFloat(r.all[x][0].min_price) * parseFloat(new_qty);
								$(".tot_"+y).val(m_round(tot));								
							}else if(r.all[x][0].item==$(".sitem_"+y).val() && r.all[x][0].batch_no != $(".btt_"+y).val()){
								if(r.all[x][0].item==$(".sitem_"+y).val() && $(".btt_"+y).val() ==""){
									var qt_cnt = parseInt($(".qtycl"+y).val());
									var a_serial = $("#all_serial_"+y).val();
									if(a_serial=="0"){
										var n_serial = r.all[x][0].serial_no;
									}else{
										var n_serial = a_serial+','+r.all[x][0].serial_no;
									}
									if(isNaN(qt_cnt)){qt_cnt=0;}
									var new_qty = qt_cnt+1;

									$(".btt_"+y).val(r.all[x][0].batch_no);
									$(".icst_"+y).val(r.all[x][0].purchase_price);
									$(".imin_"+y).val(r.all[x][0].min_price);
									
									if($("#transCode").val()=="5" || $("#transCode").val()=="4"){
										if(is_main_branch=="1"){
											$(".imax_"+y).val(r.all[x][0].min_price);
										}else{
											$(".imax_"+y).val(r.all[x][0].max_price);
										}
									}else{
										$(".imax_"+y).val(r.all[x][0].max_price);
									}

									$(".iqry_"+y).val(r.all[x][0].cur_qty);
									$("#all_serial_"+y).val(n_serial);
									$(".qtycl"+y).val(new_qty);
									$("#numofserial_"+y).val(new_qty);
									var tot= parseFloat(r.all[x][0].min_price) * parseFloat(new_qty);
									$(".tot_"+y).val(m_round(tot));
								}else{
									for(var z=0; z<25; z++){
										if(r.all[x][0].item==$(".sitem_"+z).val() && r.all[x][0].batch_no == $(".btt_"+z).val()){
											break;
										}else{
											if($(".sitem_"+z).val()==""){
												$(".sitem_"+z).val(r.all[x][0].item);
												$(".ides_"+z).val(r.all[x][0].item_des);
												$(".imdl_"+z).val(r.all[x][0].model);
												$(".btt_"+z).val(r.all[x][0].batch_no);
												$(".icst_"+z).val(r.all[x][0].purchase_price);
												$(".imin_"+z).val(r.all[x][0].min_price);
												
												if($("#transCode").val()=="5" || $("#transCode").val()=="4"){
													if(is_main_branch=="1"){
														$(".imax_"+z).val(r.all[x][0].min_price);
													}else{
														$(".imax_"+z).val(r.all[x][0].max_price);
													}
												}else{
													$(".imax_"+z).val(r.all[x][0].max_price);
												}

												$(".iqry_"+z).val(r.all[x][0].cur_qty);
												$("#all_serial_"+z).val(r.all[x][0].serial_no);
												$(".qtycl"+z).val(1);
												$("#numofserial_"+z).val(1);
												yyy++;
												$("#isaddse_"+z).val(1);
												check_is_serial_item2(r.all[x][0].item,z);
												var tot= parseFloat(r.all[x][0].min_price) * parseFloat(1);
												$(".tot_"+z).val(m_round(tot));
												break;
											}
										}
									}
								}
							}else{
								if($("#transCode").val()=="5" || $("#transCode").val()=="4" || $("#transCode").val()=="11" || $("#transCode").val()=="12" || $("#transCode").val()=="13" || $("#transCode").val()=="120"){
									for(var z=0; z<25; z++){
										if(r.all[x][0].item==$(".sitem_"+z).val() && r.all[x][0].batch_no == $(".btt_"+z).val()){
											break;
										}else{
											
											if($(".sitem_"+z).val()==""){
												$(".sitem_"+z).val(r.all[x][0].item);
												$(".ides_"+z).val(r.all[x][0].item_des);
												$(".imdl_"+z).val(r.all[x][0].model);
												$(".btt_"+z).val(r.all[x][0].batch_no);
												$(".icst_"+z).val(r.all[x][0].purchase_price);
												$(".imin_"+z).val(r.all[x][0].min_price);
												
												if($("#transCode").val()=="5" || $("#transCode").val()=="4"){
													if(is_main_branch=="1"){
														$(".imax_"+z).val(r.all[x][0].min_price);
													}else{
														$(".imax_"+z).val(r.all[x][0].max_price);
													}
												}else{
													$(".imax_"+z).val(r.all[x][0].max_price);
												}

												$(".iqry_"+z).val(r.all[x][0].cur_qty);
												$("#all_serial_"+z).val(r.all[x][0].serial_no);
												$(".qtycl"+z).val(1);
												$("#numofserial_"+z).val(1);
												yyy++;
												$("#isaddse_"+z).val(1);
												check_is_serial_item2(r.all[x][0].item,z);

												if($("#transCode").val()=="5" || $("#transCode").val()=="4"){
													if(is_main_branch=="1"){
														var tot= parseFloat(r.all[x][0].min_price) * parseFloat(1);
													}else{
														var tot= parseFloat(r.all[x][0].max_price) * parseFloat(1);
													}
												}else{
													var tot= parseFloat(r.all[x][0].max_price) * parseFloat(1);
												}
											    $(".tot_"+z).val(m_round(tot));
											break;
										}
									}
								}
							}
							$("#isaddse_"+y).val(0);
						}
					//}
				}
			}
			$(".qtycl0").blur();
			for(var t=0; t<25; t++){
				if($(".sitem_"+t).val()!="" && parseFloat($(".qtycl"+t).val())>0 && $(".btt_"+t).val()!=""){
					$(".sitem_"+t).attr("readonly",true);
					$(".qtycl"+t).attr("readonly",true);
					$(".btt_"+t).attr("readonly",true);
				}
			}
		}else{
				// add item newly to grid
			}
			$("#add_serials").attr("disabled",true);
		}
	}, "json");
}